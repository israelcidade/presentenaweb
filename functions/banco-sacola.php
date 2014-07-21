<?php
	class bancosacola extends banco{
		
		function ListaProdutosSacola($arr,$Auxilio){
			if(!empty($arr)){
				foreach ($arr as $value){
					$Sql = "Select P.*, F.* from c_produtos P
							INNER JOIN c_fotos F 
							ON P.idproduto = F.idproduto
							Where F.principal = '1'
							And p.idproduto = '".$value."' ";
					$result = parent::Execute($Sql);
					$num_rows = parent::Linha($result);
					$rs = mysql_fetch_array($result , MYSQL_ASSOC);

					$Linha = $Auxilio;
					$Linha = str_replace('<%ID%>',$rs['idproduto'],$Linha);
					$Linha = str_replace('<%NOME%>',utf8_encode($rs['nome']),$Linha);
					$Linha = str_replace('<%URLPADRAO%>',UrlPadrao,$Linha);
					$Linha = str_replace('<%CAMINHO%>',$rs['caminho'],$Linha);
					$Linha = str_replace('<%VALORVENDA%>',str_replace('.', ',',$rs['valorvenda']),$Linha);
					$Produtos .= $Linha;
				}
			}else{
				
			}
			return $Produtos;
		}

		function RemoveSacola($id){
			session_start('sacola');
			//$key = array_search($id,$_SESSION['sacola']);
			//unset($_SESSION['sacola'][$key]);
			unset($_SESSION['sacola']);
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
			$total = number_format($total, 2, ',', '.');
			return $total;
		}
	}
?>