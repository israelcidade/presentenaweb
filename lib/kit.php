<?php
	#include das funcoes da tela inico
	include('functions/banco-kit.php');

	#Instancia o objeto
	$banco = new bancokit();

	$Kit = $banco->BuscaKit($PaginaAux[0]);

	$idkit = 1;

	#Imprimi valores
	$Conteudo = $banco->CarregaHtml('kit');
	$Conteudo = str_replace('<%MSG%>', $msg, $Conteudo);
	$Conteudo = str_replace('<%IDKIT%>', $idkit, $Conteudo);
?>