<?php
	#cadastra email
	include('../../functions/banco.php');
	include('../../conf/tags.php');
	$banco = new banco;
	$banco->Conecta();
	
	$pedido = $_POST["endereco"];
	$produtos = '';

	session_start('sacola');

	foreach ($_SESSION['sacola'] as $value) {
		$produtos .= $value.'/';
		$Sql = "Select valorvenda from c_produtos where idproduto = '".$value."'";
		$result = $banco->Execute($Sql);
		$rs = mysql_fetch_array($result , MYSQL_ASSOC);
		$total = $total + $rs['valorvenda'];
	}
	$total = number_format($total, 2, ',', '.');

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
		'produtos'			=>	 $produtos,
		'status'			=>	 '1',
		'total'				=>	 $total
		);
	
	$SqlInsert = "Insert into c_pedidos (idusuario,nomedestinatario,cep,enderecoentrega,numero,complemento,bairro,cidade,estado,pais,produtos,status,total) 
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
					'".$pedido['produtos']."',
					'".$pedido['status']."',
					'".$pedido['total']."')";

	if($result = $banco->Execute($SqlInsert)){
		$Sql = " select MAX(idpedido) as idpedido FROM c_pedidos ";
		$result = $banco->Execute($Sql);
		$rs = mysql_fetch_array($result , MYSQL_ASSOC);
		$idpedido = $rs['idpedido'];
		$SqlInsertRastreio = "Insert into c_rastreios (idpedido,codigo) VALUEs ('".$idpedido."',0)";
		$result = $banco->Execute($SqlInsertRastreio);
	}
	echo true;
?>