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
					$Linha = $Auxilio;
					$Linha = str_replace('<%IDPEDIDO%>',$rs['idpedido'],$Linha);
					$Linha = str_replace('<%NOMEKIT%>',$rs['nomekit'],$Linha);
					$Linha = str_replace('<%VALORTOTAL%>','R$ '.number_format($rs['total'], 2, ',', '.'),$Linha);
					$Linha = str_replace('<%STATUS%>',$rs['nome'],$Linha);
					$Linha = str_replace('<%URLPADRAO%>',UrlPadrao,$Linha);
					$Produtos .= $Linha;
				}
			}
			return $Produtos;
		}
	}
?>