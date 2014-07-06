<?php
	#include das funcoes da tela inico
	include('functions/banco-finalizar.php');

	#Instancia o objeto
	$banco = new bancofinalizar();

	#Trabalha com Post de Login
	if( isset($_POST["acao"]) && $_POST["acao"] != '' && $_POST["acao"] == 'busca-cep'){
		$cep = strip_tags(trim(addslashes($_POST["buscar-cep"])));
		echo $cep;die;
	}

	#Imprimi valores
	$Conteudo = $banco->CarregaHtml('finalizar-pedido');
?>