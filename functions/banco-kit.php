<?php
	class bancokit extends banco{
		
		function AdicionaSacola($idkit){
			//inicia session sacola pra trabalhar com sacola
			session_start('sacola');

			//contia script
			$Sql = "Select * from c_kits where nome = '".$idkit."' ";
			$result = $this->Execute($Sql);
			$num_rows = $this->Linha($result);
			
			while($rs = mysql_fetch_array($result , MYSQL_ASSOC)){
				if(!in_array($rs['idproduto'], $_SESSION['sacola'])){
					$_SESSION['sacola'][] = $rs['idproduto'];
				}
			}

			return 'ok';
		}

		function MontaDescricao($nomekit){
			$Auxilio = parent::CarregaHtml('itens/descricao-itens');

			$Sql = "Select P.*, K.*
					FROM c_produtos P
					INNER JOIN c_kits K ON P.idproduto = K.idproduto
					AND K.nome = '".$nomekit."' ";
			$result = $this->Execute($Sql);
			$num_rows = $this->Linha($result);
			while($rs = mysql_fetch_array($result , MYSQL_ASSOC)){
				$cont++;
				$Linha = $Auxilio;
				$Linha = str_replace('<%DESCRICAO%>',utf8_encode($rs['descricao']),$Linha);
				$Linha = str_replace('<%CONT%>',$cont,$Linha);
				$Itens .= $Linha;
			}

			return $Itens;
		}

		function MontaImagens($nomekit){
			$Fotos = parent::CarregaHtml('itens/fotos-itens');
			$LinhaFotos = parent::CarregaHtml('itens/imagens-itens');

			$Sql1 = "Select * from c_kits where nome = '".$nomekit."'";

				$result = $this->Execute($Sql1);
				$num_rows = $this->Linha($result);

				while($rs = mysql_fetch_array($result , MYSQL_ASSOC)){
					$Sql2 = "Select * from c_fotos where idproduto = '".$rs['idproduto']."' ";
					$result2 = $this->Execute($Sql2);
					$num_rows2 = $this->Linha($result2);
					while($rs2 = mysql_fetch_array($result2 , MYSQL_ASSOC)){
						$Linha = $Fotos;
						$Linha = str_replace('<%IDPRODUTO%>',$rs2['idproduto'],$Linha);
						$Linha = str_replace('<%CAMINHOFOTO%>',$rs2['caminho'],$Linha);
						$Linha = str_replace('<%URLPADRAO%>',UrlPadrao,$Linha);
						$fotos .= $Linha;
					}
					
					echo $fotos;die;
				}
				
			return $fotos;
		}

		function MontaTotal($nomekit){
			$Sql = "Select P.*, K.*
					FROM c_produtos P
					INNER JOIN c_kits K ON P.idproduto = K.idproduto
					AND K.nome = '".$nomekit."' ";
			$result = $this->Execute($Sql);
			$num_rows = $this->Linha($result);
			while($rs = mysql_fetch_array($result , MYSQL_ASSOC)){
				$total = $total + $rs['valorvenda'];
			}
			
			return str_replace('.',',', $total);
		}
	}
?>