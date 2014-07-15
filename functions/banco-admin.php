<?php
	class bancoadmin extends banco{

		function InsereProduto($produto,$files){
			$Sql = "
				Insert into c_produtos (idcategoria,idsubcategoria,nome,descricao,valorcompra,de,valorvenda) 
				VALUES 
				('','','".$produto['nome']."','".$produto['descricao']."','".$produto['valorcompra']."','".$produto['de']."','".$produto['valorvenda']."') 
			";

			$this->SalvaImagemFisica($files);

			if($result = parent::Execute($Sql)){
				return 'ok';
			}else{
				return MSG_ERRO_SALVAR_PRODUTO;
			}
		}

		function SalvaImagemFisica($files){
			//Busca Ultimo id dos produtos
			$idproduto = $this->BuscaIdProduto();

			for ($i = 0; $i < sizeof($files); $i++){ 
				//Salva foto no caminho com nome correto
				preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $files[$i]["name"], $ext);
				$caminho_foto = "arq/produtos/".md5(uniqid(time())).'.'.$ext[1];
				move_uploaded_file($files[$i]["tmp_name"], $caminho_foto);
				//Salva em c_fotos
				$SqlBanco = "Insert Into c_fotos (idproduto ,caminho) VALUES ('".$idproduto."','".$caminho_foto."')";
				$result2 = parent::Execute($SqlBanco);
			}
		}
		

		function BuscaIdProduto(){
			$Sql = " select MAX(idproduto) as idproduto FROM c_produtos ";
			$result = parent::Execute($Sql);
			$rs = mysql_fetch_array($result , MYSQL_ASSOC);
			if($rs['idproduto'] == 'NULL'){
				$rs['idproduto'] = 0;
			}
			$ultimoid = $rs['idproduto'] + 1;
			return $ultimoid;
		}

		function MontaSelectProdutos(){
			$protudos = '<select name="produto">';
			$protudos .= '<option value="0">Selecione um Produto</option>';
			$Sql = "Select * from c_produtos";
			$result = parent::Execute($Sql);
			while($aux = mysql_fetch_array($result, MYSQL_ASSOC))
			{
				$selected = '';
				if($protudos == $aux['idproduto']){
					$selected = 'selected';
				}
				$protudos .= '<option value="'.$aux['idproduto'].'" '.$selected.'>'.$aux['nome'].'</option>';
			}
			$protudos .= '</select>';
			return $protudos;
		}

		function InsereKit($kit){
			$Sql = "Insert Into c_kits (nome) VALUES ('".$kit['nomekit']."') ";
			if($result = parent::Execute($Sql)){
				return 'ok';
			}else{
				return MSG_ERRO_SALVAR_KIT;
			}
		}
	}
?>