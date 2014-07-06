<?php
	class bancokit extends banco{
		
		function AdicionaSacola($idkit){
			$Sql = "Select * from c_kit where nome = '".$idkit."' ";
			$result = $banco->Execute($Sql);
			$num_rows = $banco->Linha($result);
			var_dump($result);die;
		}
	}
?>