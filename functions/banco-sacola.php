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
				$Linha = str_replace('<%NOME%>',$rs['nome'],$Linha);
				$Linha = str_replace('<%URLPADRAO%>',UrlPadrao,$Linha);
				$Linha = str_replace('<%VALORVENDA%>',str_replace('.', ',',$rs['valorvenda']),$Linha);
				$Produtos .= $Linha;
			}

			return $Produtos;
		}

		function RemoveSacola($id){
			session_start('sacola');
			$key = array_search($id,$_SESSION['sacola']);
			unset($_SESSION['sacola'][$key]);
			return 'ok';
		}

		function ValorTotal($arr){
			foreach ($arr as $value) {
				$Sql = "Select * from c_produtos where idproduto = '".$value."' ";
				$result = parent::Execute($Sql);
				$num_rows = parent::Linha($result);
				$rs = mysql_fetch_array($result , MYSQL_ASSOC);
				$total = $total + $rs['valorvenda'];
			}
			$total = str_replace('.',',',$total);
			return $total;
		}
	}
?>