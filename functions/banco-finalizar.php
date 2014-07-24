<?php
	class bancofinalizar extends banco{

		function MontaItens($arr){
			$i = 0;
			foreach ($arr as $value) {
				
				$Sql = "Select * from c_produtos where idproduto = '".$value."'";
				
				
				$result = $this->Execute($Sql);
				$rs = mysql_fetch_array($result , MYSQL_ASSOC);

				$total = ceil($rs['valorvenda']);
				$total = number_format($total, 2, '.', '');

				$Auxilio = parent::CarregaHtml('itens/pagseguro-itens');
				
				$Linha = $Auxilio;
				$Linha = str_replace('<%I%>',$i+1,$Linha);
				$Linha = str_replace('<%IDPRODUTO%>',$rs['idproduto'],$Linha);
				$Linha = str_replace('<%NOME%>',$rs['nome'],$Linha);
				$Linha = str_replace('<%VALOR%>',$total,$Linha);
				$Linha = str_replace('<%QTD%>','1',$Linha);

				$Produtos .= $Linha;
				$i = $i + 1;
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

		function MontaReferencia(){
			while($codigo = parent::GeraCodigo(10,true,true,false)){
				$Sql = "Select referencia from c_pedidos where referencia = '".$codigo."'";
				$result = parent::Execute($Sql);
				$num_rows = parent::Linha($result);
				if($num_rows == '0'){
					break;
				}
			}
			return $codigo;
		}
	}
?>