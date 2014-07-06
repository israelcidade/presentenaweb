<?php
	class bancokit extends banco{
		
		function AdicionaSacola($idkit){
			$Sql = "Select * from c_kits where nome = '".$idkit."' ";
			$result = $this->Execute($Sql);
			$num_rows = $this->Linha($result);
			
			while($rs = mysql_fetch_array($result , MYSQL_ASSOC)){
				
			}
		}
	}
?>