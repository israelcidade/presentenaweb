<?php
	#include das funcoes da tela inico
	include('functions/banco-admin.php');

	#Instancia o objeto
	$banco = new bancoadmin();

	#Trabalha com Post de Login
	if( isset($_POST["acao"]) && $_POST["acao"] != '' && $_POST["acao"] == 'cadastrar'){
		$produto['nome'] = strip_tags(trim(addslashes($_POST["nome"])));
		$produto['descricao'] = strip_tags(trim(addslashes($_POST["descricao"])));
		$produto['valorcompra'] = strip_tags(trim(addslashes($_POST["valorcompra"])));
		$produto['de'] = strip_tags(trim(addslashes($_POST["de"])));
		$produto['valorvenda'] = strip_tags(trim(addslashes($_POST["valorvenda"])));
		$myfiles = $_FILES['foto'];

		for( $i = 0; $i < count( $myfiles[ 'name' ] ); $i++ )
		{
    		$files[ ] = array(
         	'name'     => $myfiles[ 'name' ] [ $i ],
         	'type'     => $myfiles[ 'type' ] [ $i ],
         	'tmp_name' => $myfiles[ 'tmp_name' ] [ $i ],
         	'error'    => $myfiles[ 'error' ] [ $i ],
         	'size'     => $myfiles[ 'size' ] [ $i ]
     		);
		}

		$msg = $banco->InsereProduto($produto,$files);

		if($msg == 'ok'){
			$msg = MSG_OK_PRODUTO_CADASTRADO;
		}

	}

	if( isset($_POST["acao"]) && $_POST["acao"] != '' && $_POST["acao"] == 'cadastrar-kit'){
		$kit['nomekit'] = strip_tags(trim(addslashes($_POST["nomekit"])));

		$msg = $banco->InsereKit($kit);

		if($msg == 'ok'){
			$msg = MSG_OK_KIT_CADASTRADO;
		}
	}

	

	#Imprimi valores
	$Conteudo = $banco->CarregaHtml('admin');
	$Conteudo = str_replace('<%MSG%>', $msg, $Conteudo);
	$Conteudo = str_replace('<%PRODUTOS%>', $Produtos, $Conteudo);
?>