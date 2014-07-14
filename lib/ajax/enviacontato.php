<?php
	#cadastra email
	include('../../functions/banco.php');
	include('../../conf/tags.php');
	include_once("../../app/PHPMailer/class.phpmailer.php");
	include("../../app/PHPMailer/class.smtp.php");
	$banco = new banco;
	$banco->Conecta();
	
	$nome = $_POST["nome"];
	$email = $_POST["email"];
	$assunto = $_POST["assunto"];
	$Syntaxe='#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#';  
	
	if(preg_match($Syntaxe, $email)){
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
?>