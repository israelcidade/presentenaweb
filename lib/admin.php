<?php
	#include das funcoes da tela inico
	include('functions/banco-admin.php');

	#Instancia o objeto
	$banco = new bancoadmin();

	#Imprimi valores
	$Conteudo = $banco->CarregaHtml('admin');
?>