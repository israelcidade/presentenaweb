<?php
	class bancocadastro extends banco{

		function BuscaUsuario($usuario,$senha){
			$Sql = "Select * from c_usuarios where nome = '".$usuario."' AND senha = '".$senha."' ";
			$result = parent::Execute($Sql);
			$num_rows = parent::Linha($result);
			return $num_rows;
		}
		
		function BuscaUsuarioPorCpf($cpf){
			$Sql = "Select * from c_usuarios where cpf = '".$cpf."' ";
			$result = parent::Execute($Sql);
			$num_rows = parent::Linha($result);
			return $num_rows;
		}

	}
?>