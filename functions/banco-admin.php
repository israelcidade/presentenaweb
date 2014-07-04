<?php
	class bancoadmin extends banco{

		function InsereProduto($produto){
			$Sql = "
				Insert into c_produtos (idcategoria,idsubcategoria,nome,descricao,valorcompra,de,valorvenda) 
				VALUES 
				('','','".$produto['nome']."','".$produto['descricao']."','".$produto['valorcompra']."','".$produto['de']."','".$produto['valorvenda']."') 
			";

			$this->SalvaImagemFisica($produto['foto']);

			$result = parent::Execute($Sql);
		}

		function SalvaImagemFisica($arr){

			//Busca Ultimo id dos produtos
			$Sql = " select MAX(idproduto) as idproduto FROM c_produtos ";
			$result = parent::Execute($Sql);
			$rs = mysql_fetch_array($result , MYSQL_ASSOC);
			if($rs['idproduto'] == 'NULL'){
				$rs['idproduto'] = 0;
			}
			$ultimoid = $rs['idproduto'] + 1;

			//Salva foto no caminho com nome correto
			preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $arr["name"], $ext);
			$caminho_foto = "arq/produtos/".$ultimoid.'.'.$ext[1];
			move_uploaded_file($arr["tmp_name"], $caminho_foto);

			//Salva em c_fotos
			$SqlBanco = "Insert Into c_fotos (idproduto ,caminho) VALUES ('".$ultimoid."','".$caminho_foto."')";
			$result2 = parent::Execute($SqlBanco);
		}

	}
?>