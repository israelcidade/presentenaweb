<?php
	class bancosacola extends banco{
		
		function ListaProdutosSacola($arr,$Auxilio){
			$Banco_Vazio = "Banco esta Vazio";

			foreach ($arr as $value){
				$Sql = "Select * from c_produtos where idproduto = '".$value."' ";
				$result = parent::Execute($Sql);
				$num_rows = parent::Linha($result);
				$rs = mysql_fetch_array($result , MYSQL_ASSOC);

				$Linha = $Auxilio;
				$Linha = str_replace('<%ID%>',$rs['idproduto'],$Linha);
				$Produtos .= $Linha;
			}
			
			return $Produtos;
		}
	}
?>