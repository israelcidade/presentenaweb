<?php
	#cadastra email
	include('../../functions/banco.php');
	include('../../conf/tags.php');
	include_once("../../app/PHPMailer/class.phpmailer.php");
	include("../../app/PHPMailer/class.smtp.php");
	$banco = new banco;
	$banco->Conecta();
	
	$email = $_POST["email"];
	$Syntaxe='#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#';  
	
	
	if(preg_match($Syntaxe, $email)){
		$Sql = "Select * from c_usuarios where email = '".$email."'";
		$result = $banco->Execute($Sql);
		$num_rowns = $banco->Linha($result);
		if($num_rowns){
			$novaSenha = $banco->GeraCodigo('10',false,false,false);
			$Sql = "Update c_usuarios set senha = '".$novaSenha."' where email = '".$email."'";
			$result = $banco->Execute($Sql);

			#Carrega classe MAILER
			$mail = new PHPMailer();
			// Charset para evitar erros de caracteres
			$mail->Charset = 'UTF-8';
			// Dados de quem está enviando o email
			$mail->From = 'contato@presentenaweb.com.br';
			$mail->FromName = 'Presente na Web';

			// Setando o conteudo
			$mail->IsHTML(true);
			$mail->Subject = "Nova Senha Site Presente Na Web";
			$mail->Body = utf8_decode("
				Nova Senha: $novaSenha
				");
	            
	        // Validando a autenticação
			$mail->IsSMTP();
			$mail->SMTPAuth = true;
			$mail->Host     = "ssl://smtp.gmail.com";
			$mail->Port     = 465;
			$mail->Username = EMAIL_USER;
			$mail->Password = EMAIL_PASS;

			// Setando o endereço de recebimento
			$mail->AddAddress($email);
	            
			// Enviando o e-mail para o usuário
	        $enviado = $mail->Send();
	        if($enviado){
	        	echo 'enviado';
	        }else{
				echo 'false';
	        }
	    }else{
	    	echo 'sememail';
	    }
	}else{
		echo 'emailerrado';
	}
?>