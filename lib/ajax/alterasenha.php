<?php
	#cadastra email
	include('../../functions/banco.php');
	include('../../conf/tags.php');
	$banco = new banco;
	$banco->Conecta();
	
	session_start('login');
	$senha = $_POST['novasenha'];

	$Sql = "Select senha from c_usuarios where senha = '".$senha."' AND email = '".$_SESSION['email']."'";
	$result = $banco->Execute($Sql);
	$num_rows = $banco->Linha($result);
	if($num_rows){
		$Sql = "Update c_usuarios set senha = '".$senha."' where email = '".$_SESSION['email']."'";
		$result = $banco->Execute($Sql);
		echo 'ok';
	}else{
		echo 'senhaerrada';
	}
?>
