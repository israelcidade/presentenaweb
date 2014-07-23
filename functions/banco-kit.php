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

			$Sql = "Select P.*,P.nome as nomeproduto, K.*
					FROM c_produtos P
					INNER JOIN c_kits K ON P.idproduto = K.idproduto
					AND K.nome = '".$nomekit."' ";
			$result = $this->Execute($Sql);
			$num_rows = $this->Linha($result);
			while($rs = mysql_fetch_array($result , MYSQL_ASSOC)){
				$cont++;
				$Linha = $Auxilio;
				$Linha = str_replace('<%NOMEPRODUTO%>',$rs['nomeproduto'],$Linha);
				$Linha = str_replace('<%DESCRICAO%>',$rs['descricao'],$Linha);
				$Linha = str_replace('<%ALTURA%>',$rs['altura'],$Linha);
				$Linha = str_replace('<%LARGURA%>',$rs['largura'],$Linha);
				$Linha = str_replace('<%COMPRIMENTO%>',$rs['comprimento'],$Linha);
				$Linha = str_replace('<%CONT%>',$cont,$Linha);
				$Itens .= $Linha;
			}

			return $Itens;
		}

		function MontaImagens($nomekit){
			$Auxilio1= parent::CarregaHtml('itens/fotos-itens');
			$Auxilio2 = parent::CarregaHtml('itens/imagens-itens');

			//Busca todos os produtos do kit
			$Sql = "Select * from c_kits where nome = '".$nomekit."'";
			$result = $this->Execute($Sql);

			//Lista eles individualmente e joga numa variavel para HTML
			while ($rs = mysql_fetch_array($result , MYSQL_ASSOC)){

				$Sql = "Select * from c_fotos where idproduto = '".$rs['idproduto']."'";
				$result2 = $this->Execute($Sql);
				$LinhaAux = $Auxilio2;

				//Pra cada produtos lista todas as fotos dele e joga no HTML!
				while ($rs2 = mysql_fetch_array($result2 , MYSQL_ASSOC)){
					
					$Fotos .= $Auxilio1;
					$Fotos = str_replace('<%CAMINHO%>',$rs2['caminho'],$Fotos);
					$Fotos = str_replace('<%URLPADRAO%>',UrlPadrao,$Fotos);
				}

				$LinhaPrincipal .= $LinhaAux;
				$LinhaPrincipal = str_replace('<%FOTOS%>',$Fotos,$LinhaPrincipal);
				$LinhaPrincipal = str_replace('<%CONT%>',$cont+1,$LinhaPrincipal);
				$cont = $cont+1;
				$Fotos = '';

			}
		
			return $LinhaPrincipal;
			
			/*
			$LinhaPrincipal = $Auxilio2;
			$Fotos = $Auxilio1;
			$Fotos = str_replace('<%CAMINHO%>',$files[0]['caminho'],$Fotos);
			$Fotos = str_replace('<%URLPADRAO%>',UrlPadrao,$Fotos);
			$Fotos .= $Auxilio1;
			$Fotos = str_replace('<%CAMINHO%>',$files[1]['caminho'],$Fotos);
			$Fotos = str_replace('<%URLPADRAO%>',UrlPadrao,$Fotos);
			$Fotos .= $Auxilio1;
			$Fotos = str_replace('<%CAMINHO%>',$files[2]['caminho'],$Fotos);
			$Fotos = str_replace('<%URLPADRAO%>',UrlPadrao,$Fotos);
			$LinhaPrincipal = str_replace('<%FOTOS%>',$Fotos,$LinhaPrincipal);
			return $LinhaPrincipal;
			*/
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
			$total = ceil($total);
			$total = (number_format($total+15, 2, ',', '.'));
			return $total;
		}
	}
?>