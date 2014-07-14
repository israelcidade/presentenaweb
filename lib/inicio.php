<?php
	#include das funcoes da tela inico
	include('functions/banco-inicio.php');

	#Instancia o objeto
	$banco = new bancoinicio();

	if($this->PaginaAux[0] == 'deslogar'){
		$banco->FechaSessao();
		$banco->RedirecionaPara('inicio');
	}

	if($this->PaginaAux[0] == 'acesso-negado'){
		$msg = "Acesso Negado";
	}

	#Imprimi valores
	$Conteudo = $banco->CarregaHtml('inicio');
	$Conteudo = str_replace('<%MSG%>', $msg, $Conteudo);
?>