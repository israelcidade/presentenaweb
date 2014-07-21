<?php
	class bancocadastro extends banco{

		function BuscaUsuario($email,$senha){
			$Sql = "Select * from c_usuarios where email = '".$email."' AND senha = '".$senha."' ";
			$result = parent::Execute($Sql);
			$num_rows = parent::Linha($result);
			$rs = mysql_fetch_array($result , MYSQL_ASSOC);

			if(!$num_rows){
				return $this->MontaMsg('erro',MSG_ERRO_SENHA_OU_EMAIL);
			}elseif($rs['ativo'] == '0'){
				return $this->MontaMsg('erro',MSG_AVISO_ATIVAR);
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

		function BuscaEmail($email){
			$Sql = "Select * from c_usuarios where email = '".$email."' ";
			$result = parent::Execute($Sql);
			$num_rows = parent::Linha($result);
			return $num_rows;
		}

		function InsereUsuario($usuario){
			$Sql = "Insert into c_usuarios (nome,senha,cpf,email,ativo) VALUES ('".$usuario['nome']."','".$usuario['senha']."','".$usuario['cpf']."','".$usuario['email']."',0) ";
			
			if($this->BuscaUsuarioPorCpf($usuario['cpf'])){
				return $this->MontaMsg('erro',MSG_ERRO_CPF_EXISTENTE);
			}elseif($this->BuscaEmail($usuario['email'])){
				return $this->MontaMsg('erro',MSG_ERRO_EMAIL_EXISTENTE);
			}elseif($usuario['senha'] != $usuario['senha2']){
				return MSG_ERRO_SENHA_DIFERENTE;
			}elseif(!parent::Execute($Sql)){
				return MSG_ERRO_BANCO;
			}else{
				$codigo = $this->InsereCodigo($usuario);
				$flag = $this->DisparaEmailAtivador($usuario,$codigo);
				if($flag == true){
					return 'ok';
				}else{
					return MSG_ERRO_DISPARA_EMAIL;
				}
			}
		}

		function InsereCodigo($usuario){
			$Sql = "Select idusuario from c_usuarios where email = '".$usuario['email']."'";
			$codigo = $this->CriaCodigoAtivacao();
			$result = parent::Execute($Sql);
			$num_rows = parent::Linha($result);
			if($num_rows){
				$rs = mysql_fetch_array($result , MYSQL_ASSOC);
				$idusuario = $rs['idusuario'];
				$Sql2 = "Insert into c_codigos (idusuario,codigo) VALUES ('".$idusuario."','".$codigo."') ";
				$result = parent::Execute($Sql2);
				return $codigo;
			}
		}

		function CriaCodigoAtivacao(){
			while($codigo = parent::GeraCodigo(10,true,true,false)){
				$Sql = "Select codigo from c_codigos where codigo = '".$codigo."'";
				$result = parent::Execute($Sql);
				$num_rows = parent::Linha($result);
				if($num_rows == '0'){
					break;
				}
			}
			return $codigo;
		}

		function DisparaEmailAtivador($usuario,$codigo){
			include_once("./app/PHPMailer/class.phpmailer.php");
			include("./app/PHPMailer/class.smtp.php");

			#Carrega classe MAILER
			$mail = new PHPMailer();
			// Charset para evitar erros de caracteres
			$mail->Charset = 'UTF-8';
			// Dados de quem está enviando o email
			$mail->From = EMAIL_USER;
			$mail->FromName = 'Presente Na Web';

			// Setando o conteudo
			$mail->IsHTML(true);
			$mail->Subject = "Bem-Vindo ao Presente Na Web";
			$mail->Body = utf8_decode("
				<a href='localhost/presentenaweb/cadastro/codigo/$codigo'>Ativar Conta</a>
			");
	            
	        // Validando a autenticação
			$mail->IsSMTP();
			$mail->SMTPAuth = true;
			$mail->Host     = "ssl://smtp.gmail.com";
			$mail->Port     = 465;
			$mail->Username = EMAIL_USER;
			$mail->Password = EMAIL_PASS;

			// Setando o endereço de recebimento
			$mail->AddAddress(EMAIL_RECEB);
	            
			// Enviando o e-mail para o usuário
	        if($mail->Send()){
	        	return true;
	        }else{
				return false;
	        }
		}

		function BuscaCodigo($codigo){
			$Sql = "Select * from c_codigos where codigo = '".$codigo."' ";
			$result = parent::Execute($Sql);
			$num_rows = parent::Linha($result);
			if($num_rows){
				$rs = mysql_fetch_array($result , MYSQL_ASSOC);
				$Sql2 = "Update c_usuarios SET ativo = 1 where idusuario = '".$rs['idusuario']."' ";
				$result2 = parent::Execute($Sql2);
				return MSG_OK_CONTA_ATIVADA;
			}else{
				return MSG_ERRO_ATIVAR_CONTA;
			}
		}
	}
?>