<?php
	#include das funcoes da tela inico
	include('functions/banco-admin.php');

	#Instancia o objeto
	$banco = new bancoadmin();

	//Trabalha com produto-cadastrado
	if($this->PaginaAux[0] == 'produto-cadastrado'){
		$msg = MSG_OK_PRODUTO_CADASTRADO;
	}

	#Trabalha com Post de Login
	if( isset($_POST["acao"]) && $_POST["acao"] != '' && $_POST["acao"] == 'cadastrar'){
		$produto['nome'] = strip_tags(trim(addslashes($_POST["nome"])));
		$produto['descricao'] = strip_tags(trim(addslashes($_POST["descricao"])));
		$produto['valorcompra'] = strip_tags(trim(addslashes($_POST["valorcompra"])));
		$produto['de'] = strip_tags(trim(addslashes($_POST["de"])));
		$produto['valorvenda'] = strip_tags(trim(addslashes($_POST["valorvenda"])));
		$produto['foto'] = $_FILES["foto"];

		$msg = $banco->InsereProduto($produto);

		if($msg == 'ok'){
			$banco->RedirecionaPara('admin/produto-cadastrado');
		}

	}

	#Imprimi valores
	$Conteudo = $banco->CarregaHtml('admin');
	$Conteudo = str_replace('<%MSG%>', $msg, $Conteudo);
?>