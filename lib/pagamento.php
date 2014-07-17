<?php
	#include das funcoes da tela inico
	include('functions/banco-pagamento.php');

	#Instancia o objeto
	$banco = new bancopagamento();

	#Imprimi valores
	$Conteudo = $banco->CarregaHtml('pagamento');
?>