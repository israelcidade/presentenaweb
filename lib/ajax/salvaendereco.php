<?php
	#cadastra email
	include('../../functions/banco.php');
	include('../../conf/tags.php');
	$banco = new banco;
	$banco->Conecta();
	
	$pedido = $_POST["endereco"];
	$produtos = '';

	session_start('sacola');

	for ($i=0; $i < sizeof($_SESSION['sacola']); $i++) { 
		$produtos .= $_SESSION['sacola'][$i].'/';
	}

	session_start('login');
	$idusuario = $_SESSION['idusuario'];
	
	$aux = explode('/', $pedido);
	$pedido = array(
		'idusuario'         =>   $idusuario,
		'nome-destinatario' =>   $aux[0],
		'cep' 				=>   $aux[1],
		'endereco-entrega' 	=>   $aux[2],
		'numero' 			=>   $aux[3],
		'complemento' 		=>   $aux[4],
		'bairro' 			=>   $aux[5],
		'cidade' 			=>   $aux[6],
		'estado' 			=>   $aux[7],
		'pais' 				=>   $aux[8],
		'produtos'			=>	 $produtos
		);
	
	$Sql = "Insert into c_pedidos (idusuario,nomedestinatario,cep,enderecoentrega,numero,complemento,bairro,cidade,estado,pais,produtos) 
			VALUES ('".$pedido['idusuario']."',
					'".$pedido['nome-destinatario']."',
					'".$pedido['cep']."',
					'".$pedido['endereco-entrega']."',
					'".$pedido['numero']."',
					'".$pedido['complemento']."',
					'".$pedido['bairro']."',
					'".$pedido['cidade']."',
					'".$pedido['estado']."',
					'".$pedido['pais']."',
					'".$pedido['produtos']."')";

	$result = $banco->Execute($Sql);
	echo true;
?>