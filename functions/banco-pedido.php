<?php
	class bancopedido extends banco{
		function VerificaPedido($idpedido,$idusuario){
			$Sql = "Select * from c_pedidos where idpedido = '".$idpedido."' AND idusuario = '".$idusuario."'";
			$result = parent::Execute($Sql);
			$num_rowns = parent::Linha($result);

			if($num_rowns){
				return true;
			}else{
				return false;
			}
		}

		function BuscaPedido($idpedido){
			$Auxilio = parent::CarregaHtml('itens/pedido-itens');
			$Sql = "Select P.*,R.*,K.nome as nomekit,S.nome as nomestatus from c_pedidos P 
					INNER JOIN c_rastreios R ON P.idpedido = R.idpedido 
					INNER JOIN c_kits K ON P.produtos = K.busca
					INNER JOIN fixo_status S ON P.status = S.idstatus
					Where P.idpedido = '".$idpedido."'
					";
					

			$result = parent::Execute($Sql);
			$num_rows = parent::Linha($result);
			if($num_rows){
				while($rs = mysql_fetch_array($result , MYSQL_ASSOC)){
					if($rs['codigo'] == '0'){
						$codigo = 'Aguarde...';
					} 
					$Linha = $Auxilio;
					$Linha = str_replace('<%KIT%>',$rs['nomekit'],$Linha);
					$Linha = str_replace('<%VALORTOTAL%>','R$ '.number_format($rs['total'], 2, ',', '.'),$Linha);
					$Linha = str_replace('<%STATUS%>',$rs['nomestatus'],$Linha);
					$Linha = str_replace('<%RASTREIO%>',$codigo,$Linha);
					$Pedidos .= $Linha;
				}
			}
			return $Pedidos;
		}
	}
?>