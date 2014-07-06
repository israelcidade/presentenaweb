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
				$_SESSION['sacola'][] = $rs['idproduto'];
			}

			return 'ok';
		}
	}
?>