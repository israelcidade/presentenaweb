<?php
	class bancofinalizar extends banco{
		
		function FinalzarCompra($pedido){
			$Sql = "Insert into c_pedidos (nomedestinatario,cep,enderecoentrega,numero,complemento,bairro,cidade,estado,pais) 
			VALUES ('".$pedido['nome-destinatario']."','".$pedido['cep']."','".$pedido['endereco-entrega']."','".$pedido['numero']."','".$pedido['complemento']."','".$pedido['bairro']."','".$pedido['cidade']."','".$pedido['estado']."','".$pedido['pais']."')";
			$result = $this->Execute($Sql);
			
			return 'ok';
		}

		function MontaItens($arr){
			for ($i = 0; $i < sizeof($arr); $i++){
				$Sql = "Select * from c_produtos where idproduto = '".$arr[$i]."'";
				
				$result = $this->Execute($Sql);
				$rs = mysql_fetch_array($result , MYSQL_ASSOC);

				$Auxilio = parent::CarregaHtml('itens/pagseguro-itens');
				
				$Linha = $Auxilio;
				$Linha = str_replace('<%I%>',$i+1,$Linha);
				$Linha = str_replace('<%IDPRODUTO%>',$rs['idproduto'],$Linha);
				$Linha = str_replace('<%NOME%>',$rs['nome'],$Linha);
				$Linha = str_replace('<%VALOR%>',$rs['valorvenda'],$Linha);
				$Linha = str_replace('<%QTD%>','1',$Linha);
				$Produtos .= $Linha;
			}
			return $Produtos;
		}

		function MontaItensComprador($var){
			$Sql = "Select * from c_usuarios where email = '".$var."'";
			$result = $this->Execute($Sql);
			$rs = mysql_fetch_array($result , MYSQL_ASSOC);
			$Auxilio = parent::CarregaHtml('itens/pagseguro-comprador-itens');
			$Linha = $Auxilio;
			$Linha = str_replace('<%NOME%>',$rs['nome'],$Linha);
			$Linha = str_replace('<%EMAIL%>',$rs['email'],$Linha);
			$Linha = str_replace('<%CPF%>',$rs['cpf'],$Linha);
			$Produtos = $Linha;
			
			return $Produtos;
		}
	}
?>