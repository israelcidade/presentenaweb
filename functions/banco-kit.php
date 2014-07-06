<?php
	class bancokit extends banco{
		
		function AdicionaSacola($idkit){

			//inicia session sacola pra trabalhar com sacola
			session_start('sacola');


			//Zerar variavel Session !!!
			//$_SESSION['sacola'] = '';
			//die;

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
	}
?>