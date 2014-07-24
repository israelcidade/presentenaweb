<?php
	class bancoconta extends banco{
		function ListaProdutos($idusuario,$Auxilio){
			$Sql = "Select P.total,P.idpedido,K.nome as nomekit,S.nome 
					from c_pedidos P INNER JOIN c_kits K ON P.produtos = K.busca 
					INNER JOIN fixo_status S ON P.status = S.idstatus 
					AND P.idusuario = '".$idusuario."'
				";
				
			$result = parent::Execute($Sql);
			$num_rows = parent::Linha($result);
			if($num_rows){
				while($rs = mysql_fetch_array($result , MYSQL_ASSOC)){
					$total = ceil($rs['total']);
					$total = number_format($total+15, 2, ',', '.');
					$Linha = $Auxilio;
					$Linha = str_replace('<%IDPEDIDO%>',$rs['idpedido'],$Linha);
					$Linha = str_replace('<%NOMEKIT%>',$rs['nomekit'],$Linha);
					$Linha = str_replace('<%VALORTOTAL%>','R$ '.$total,$Linha);
					$Linha = str_replace('<%STATUS%>',$rs['nome'],$Linha);
					$Linha = str_replace('<%URLPADRAO%>',UrlPadrao,$Linha);
					$Produtos .= $Linha;
				}
			}else{
				$msg = parent::MontaMsg('atencao',MSG_AVISO_MINHA_CONTA_VAZIA);
				$Produtos = "<tr><td colspan=5>".$msg."</td></tr>";
			}
			return $Produtos;
		}

		function UltimoPedido(){
			$Sql = "SELECT max(idpedido) as id FROM c_pedidos";
			$result = parent::Execute($Sql);
			$rs = mysql_fetch_array($result , MYSQL_ASSOC);
			return $rs['id'];
		}

		function InsereReferencia($idpedido,$codigo){
			$Sql = "Insert Into c_referencia (idpedido,codigo) VALUES ('".$idpedido."','".$codigo."')";
			$result = parent::Execute($Sql);
			return true;
		}
	}
?>