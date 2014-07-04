<?php
	class bancoadmin extends banco{

		function InsereProduto($produto){
			$Sql = "
				Insert into c_produtos (idcategoria,idsubcategoria,nome,descricao,valorcompra,de,valorvenda) 
				VALUES 
				('','','".$produto['nome']."','".$produto['descricao']."','".$produto['valorcompra']."','".$produto['de']."','".$produto['valorvenda']."') 
			";

			$this->SalvaImagemFisica($produto['foto']);
		}

		function SalvaImagemFisica($arr){
			$Sql = " select MAX(idproduto) as idproduto FROM c_produtos ";
			$result = parent::Execute($Sql);
			$rs = mysql_fetch_array($result , MYSQL_ASSOC);
			$ultimoid = $rs['idproduto'] + 1;
			preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $arr["name"], $ext);
			$caminho_foto = "arq/produtos/".$ultimoid.'.'.$ext[1];
			move_uploaded_file($foto["tmp_name"], $caminho_foto);
			$SqlBanco = "Insert Into c_marcas (marca, foto) VALUES ('".$marca."','".$caminho_foto."')";
		}

	}
?>