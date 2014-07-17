<?php
	#cadastra email
	include('../../functions/banco-finalizar.php');
	include('../../conf/tags.php');
	$banco = new banco;
	$banco->Conecta();
	
	$email = $_POST["email"];
	
?>