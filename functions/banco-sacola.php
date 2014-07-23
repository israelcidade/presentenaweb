<?php
	class bancosacola extends banco{
		
		function ListaProdutosSacola($arr){
			$Auxilio = $this->CarregaHtml('itens/lista-produtos-itens');
			if(!empty($arr)){
				foreach ($arr as $value){
					$valorKit = $this->ValorDoKit($value);
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
					$Linha = str_replace('<%VALOTOTAL%>',$valorKit,$Linha);
					$Linha = str_replace('<%URLPADRAO%>',UrlPadrao,$Linha);
					$Linha = str_replace('<%CAMINHO%>',$rs['caminho'],$Linha);
					$Linha = str_replace('<%VALORVENDA%>',number_format($rs['valorvenda'], 2, ',', '.'),$Linha);
					$Produtos .= $Linha;
				}
			}else{
				$msg = parent::MontaMsg('atencao',MSG_ERRO_SACOLA_VAZIA);
				$Produtos = "<tr><td colspan=6>".$msg."</td></tr>";
			}
			return $Produtos;
		}

		function RemoveSacola($id){
			session_start('sacola');
			$Sql = "Select nome from c_kits where idproduto = '".$id."' ";
			$result = parent::Execute($Sql);
			$rs = mysql_fetch_array($result , MYSQL_ASSOC);
			$Sql = "Select * from c_kits where nome = '".$rs['nome']."' ";
			$result = parent::Execute($Sql);

			while($rs = mysql_fetch_array($result , MYSQL_ASSOC)){
				$i = array_search($rs['idproduto'], $_SESSION['sacola']);
				unset($_SESSION['sacola'][$i]);
			}
			
			return 'ok';
		}

		function ValorTotal($arr){
			if(!empty($arr)){
				foreach ($arr as $value) {
					$Sql = "Select * from c_produtos where idproduto = '".$value."' ";
					$result = parent::Execute($Sql);
					$num_rows = parent::Linha($result);
					if($num_rows){
						$rs = mysql_fetch_array($result , MYSQL_ASSOC);
						$total = $total + $rs['valorvenda'];
						
					}
				}
				$total = ceil($total);
				$total = number_format($total+15, 2, ',', '.');
			}else{
				$total = '000,00';
			}	
			return $total;
		}

		function ValorDoKit($value){
			$Sql = "
				Select P.*,K.* from c_produtos P
				INNER JOIN c_kits K ON P.idproduto = K.idproduto
				AND P.idproduto = '".$value."'
			";
			
			$result = parent::Execute($Sql);
			$rs = mysql_fetch_array($result , MYSQL_ASSOC);

			return $rs['valor'];
		}
	}
?>