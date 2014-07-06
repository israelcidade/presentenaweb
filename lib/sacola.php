<?php
	#include das funcoes da tela inico
	include('functions/banco-sacola.php');

	#Instancia o objeto
	$banco = new bancosacola();

	//inicia session sacola pra trabalhar com a sacola
	session_start('sacola');

	if($this->PaginaAux[0] == 'add'){
		$msg = MSG_OK_KIT_ADICIONADO_SACOLA;

		var_dump($_SESSION['sacola']);
	}

	#Imprimi valores
	$Conteudo = $banco->CarregaHtml('sacola');
	$Conteudo = str_replace('<%MSG%>', $msg, $Conteudo);
?>