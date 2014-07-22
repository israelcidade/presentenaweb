<?php
	#include das funcoes da tela inico
	include('functions/banco-sacola.php');

	#Instancia o objeto
	$banco = new bancosacola();

	//inicia session sacola pra trabalhar com a sacola
	session_start('sacola');
	
	if($this->PaginaAux[0] == 'add'){
		$msg = $this->MontaMsg('ok',MSG_OK_KIT_ADICIONADO_SACOLA);
	}

	if($this->PaginaAux[0] == 'remove'){
		$msg = $banco->RemoveSacola($this->PaginaAux[1]);
		if($msg == 'ok'){
			$banco->RedirecionaPara('sacola');
		}
	}

	//Lista Itens da Sacola
	if($Produtos = $banco->ListaProdutosSacola($_SESSION['sacola']) == 'vazio'){
		$msg = $banco->MontaMsg('atencao',MSG_ERRO_SACOLA_VAZIA);
	}else{
		$Produtos = $banco->ListaProdutosSacola($_SESSION['sacola']);
	}

	$Total = $banco->ValorTotal($_SESSION['sacola']);

	#Imprimi valores
	$Conteudo = $banco->CarregaHtml('sacola');
	$Conteudo = str_replace('<%MSG%>', $msg, $Conteudo);
	$Conteudo = str_replace('<%PRODUTOS%>', $Produtos, $Conteudo);
	$Conteudo = str_replace('<%TOTAL%>', $Total, $Conteudo);
?>