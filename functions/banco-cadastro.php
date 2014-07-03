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
			include_once("../../app/PHPMailer/class.phpmailer.php");
			include("../../app/PHPMailer/class.smtp.php");

			#Carrega classe MAILER
				$mail = new PHPMailer();
				// Charset para evitar erros de caracteres
				$mail->Charset = 'UTF-8';
				// Dados de quem está enviando o email
				$mail->From = $email;
				$mail->FromName = $nome;

				// Setando o conteudo
				$mail->IsHTML(true);
				$mail->Subject = "Contato Site Innovare";
				$mail->Body = utf8_decode("
					Nome: $nome<br>
					Email: $email<br>
					Assunto: $assunto<br>
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
		        	echo 'ok';
		        }else{
					echo 'false';
		        }
			}else{
				echo 'emailerrado';
			}
		}
	}
?>