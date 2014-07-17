<?php
	class bancofinalizar extends banco{
		
		function FinalzarCompra($pedido,$idusuario,$sacola){
			$Sql = "Insert into c_pedidos (nomedestinatario,cep,enderecoentrega,numero,complemento,bairro,cidade,estado,pais) 
			VALUES ('".$pedido['nome-destinatario']."','".$pedido['cep']."','".$pedido['endereco-entrega']."','".$pedido['numero']."','".$pedido['complemento']."','".$pedido['bairro']."','".$pedido['cidade']."','".$pedido['estado']."','".$pedido['pais']."')";
			$result = $this->Execute($Sql);
			$num_rows = $this->Linha($result);
			return 'ok';
		}
	}
?>