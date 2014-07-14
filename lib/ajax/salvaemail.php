<?php
	#cadastra email
	include('../../functions/banco.php');
	include('../../conf/tags.php');
	$banco = new banco;
	$banco->Conecta();
	
	$email = $_POST["email"];
	$Syntaxe='#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#';  
	if(preg_match($Syntaxe, $email)){
		$Sql = "Insert into c_emails (email) VALUES ('".$email."')";
		$result = $banco->Execute($Sql);
		echo true;
	}else{
		echo false;
	}
?>