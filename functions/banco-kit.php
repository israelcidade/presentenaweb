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
			$Auxilio1= parent::CarregaHtml('itens/fotos-itens');
			$Auxilio2 = parent::CarregaHtml('itens/imagens-itens');

			$Sql = "Select K.* , F.*, P.nome
					From c_kits K
					Inner join c_fotos F ON F.idproduto = K.idproduto 
					Inner join c_produtos P ON p.idproduto = F.idproduto
					AND K.nome = '".$nomekit."'";	
			$result = parent::Execute($Sql);
			$num_rows = parent::Linha($result);
			
			while($rs = mysql_fetch_array($result , MYSQL_ASSOC)){
				$files[ ] = array(
	         	'idproduto'     => $rs['idproduto'],
	         	'caminho'     	=> $rs['caminho'],
	         	'nome' 			=> $rs['nome']
	     		);
			}

			$result = count($files);
			$LinhaPrincipal = $Auxilio2;
			$cont = 0;
			switch ($result) {
				case 3:
					echo 'array com 3';
				break;
				case 6:
					for ($i=0; $i <= 2; $i++) { 
						$Fotos = $Auxilio1;
						$Fotos = str_replace('<%CAMINHO%>',$files[$i]['caminho'],$Fotos);
						$Fotos = str_replace('<%URLPADRAO%>',UrlPadrao,$Fotos);
						$FotosFinal1 .= $Fotos;
					}
					$LinhaPrincipal = str_replace('<%FOTOS%>',$FotosFinal1,$LinhaPrincipal);
					$LinhaPrincipal = str_replace('<%CONT%>','1',$LinhaPrincipal);
					$LinhaPrincipal2 .= $Auxilio2;
					for ($i=3; $i <=5 ; $i++) { 
						$Fotos = $Auxilio1;
						$Fotos = str_replace('<%CAMINHO%>',$files[$i]['caminho'],$Fotos);
						$Fotos = str_replace('<%URLPADRAO%>',UrlPadrao,$Fotos);
						$FotosFinal2 .= $Fotos;
					}
					$LinhaPrincipal2 = str_replace('<%FOTOS%>',$FotosFinal2,$LinhaPrincipal2);
					$LinhaPrincipal2 = str_replace('<%CONT%>','2',$LinhaPrincipal2);
					$LinhaPrincipal .= $LinhaPrincipal2;
				break;
				case 9:
					echo 'array com 9';
				break;
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
			
			return str_replace('.',',', $total);
		}
	}
?>