<?php
	#include das funcoes da tela inico
	include('functions/banco-conta.php');

	#Instancia o objeto
	$banco = new bancoconta();

	#Imprimi valores
	$Conteudo = $banco->CarregaHtml('minha-conta');
?>