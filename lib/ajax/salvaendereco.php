<?php
	#cadastra email
	include('../../functions/banco.php');
	include('../../conf/tags.php');
	$banco = new banco;
	$banco->Conecta();
	
	$endereco = $_POST["endereco"];
	
	$aux = explode('/', $endereco);
	$endereco = array(
		'nome-destinatario' =>   $aux[0],
		'cep' 				=>   $aux[1],
		'endereco-entrega' 	=>   $aux[2],
		'numero' 			=>   $aux[3],
		'complemento' 		=>   $aux[4],
		'bairro' 			=>   $aux[5],
		'cidade' 			=>   $aux[6],
		'estado' 			=>   $aux[7],
		'pais' 				=>   $aux[8]
		);
	if($banco->FinalzarCompra($endereco)){
		return true;
	}else{
		return false;
	}
?>