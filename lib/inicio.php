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

	if($banco->VerificaSessao()){
		$deslogar = "<a href='".UrlPadrao."inicio/deslogar/' onClick=\"return confirm('Tem certeza que deseja deslogar ?')\" >Deslogar</a>";
	}

	#Imprimi valores
	$Conteudo = $banco->CarregaHtml('inicio');
	$Conteudo = str_replace('<%SAIR%>', $deslogar, $Conteudo);
	$Conteudo = str_replace('<%MSG%>', $msg, $Conteudo);
?>