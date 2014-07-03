<?php
	class bancocadastro extends banco{

		function BuscaUsuario($email,$senha){
			$Sql = "Select * from c_usuarios where email = '".$email."' AND senha = '".$senha."' ";
			$result = parent::Execute($Sql);
			$num_rows = parent::Linha($result);

			$Sql2 = "Select ativo from c_usuarios where email = '".$email."'";
			$result2 = parent::Execute($Sql);
			$num_rows2 = parent::Linha($result);
			$rs = mysql_fetch_array($result2 , MYSQL_ASSOC);

			if(!$num_rows){
				return MSG_ERRO_SENHA_OU_EMAIL;
			}elseif($rs['ativo'] == '0'){
				return MSG_AVISO_ATIVAR;
			}else{
				return 'ok';
			}  
		}
		
		function BuscaUsuarioPorCpf($cpf){
			$Sql = "Select * from c_usuarios where cpf = '".$cpf."' ";
			$result = parent::Execute($Sql);
			$num_rows = parent::Linha($result);
			return $num_rows;
		}

		function InsereUsuario($usuario){
			$Sql = "Insert into c_usuarios (nome,senha,cpf,email,ativo) VALUES ('".$usuario['nome']."','".$usuario['senha']."','".$usuario['cpf']."','".$usuario['email']."',0) ";
			
			if($this->BuscaUsuarioPorCpf($usuario['cpf'])){
				return MSG_ERRO_CPF_EXISTENTE;
			}elseif($usuario['senha'] != $usuario['senha2']){
				return MSG_ERRO_SENHA_DIFERENTE;
			}elseif(!parent::Execute($Sql)){
				return MSG_ERRO_BANCO;
			}else{
				$this->DisparaEmailAtivador($usuario);
				return 'ok';
			}
		}

		function DisparaEmailAtivador($usuario){
			
		}
	}
?>