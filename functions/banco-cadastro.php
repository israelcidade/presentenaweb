<?php
	class bancocadastro extends banco{

		function BuscaUsuario($usuario,$senha){
			$Sql = "Select * from c_usuarios where nome = '".$usuario."' AND senha = '".$senha."' ";
			$result = parent::Execute($Sql);
			$num_rows = parent::Linha($result);
			return $num_rows;
		}
		
		function BuscaUsuarioPorCpf($cpf){
			$Sql = "Select * from c_usuarios where cpf = '".$cpf."' ";
			$result = parent::Execute($Sql);
			$num_rows = parent::Linha($result);
			return $num_rows;
		}

		function InsereUsuario($usuario){
			$Sql = "Insert into c_usuarios (nome,senha,cpf,email) VALUES ('".$usuario['nome']."','".$usuario['senha']."','".$usuario['cpf']."','".$usuario['email']."') ";
			
			if($this->BuscaUsuarioPorCpf($usuario['cpf'])){
				return MSG_ERRO_CPF_EXISTENTE;
			}elseif($usuario['senha'] != $usuario['senha2']){
				return MSG_ERRO_SENHA_DIFERENTE;
			}elseif(!parent::Execute($Sql)){
				return MSG_ERRO_BANCO;
			}else{
				return 'ok';
			}
		}
	}
?>