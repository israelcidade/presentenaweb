<?php
	#include das funcoes da tela inico
	include('functions/banco-sacola.php');

	#Instancia o objeto
	$banco = new bancosacola();

	//inicia session sacola pra trabalhar com a sacola
	session_start('sacola');

	if($this->PaginaAux[0] == 'add'){
		$msg = MSG_OK_KIT_ADICIONADO_SACOLA;
	}

	if($this->PaginaAux[0] == 'remove'){
		$msg = $banco->RemoveSacola($this->PaginaAux[1]);

		if($msg == 'ok'){
			$msg = MSG_OK_REMOVE_PRODUTO_SACOLA;
		}
	}

	//Lista Itens da Sacola
	#Carrega o html de Auxilio
	$Auxilio = $banco->CarregaHtml('itens/lista-produtos-itens');

	$Produtos = $banco->ListaProdutosSacola($_SESSION['sacola'],$Auxilio);

	$Total = $banco->ValorTotal($_SESSION['sacola']);

	#Imprimi valores
	$Conteudo = $banco->CarregaHtml('sacola');
	$Conteudo = str_replace('<%MSG%>', $msg, $Conteudo);
	$Conteudo = str_replace('<%PRODUTOS%>', $Produtos, $Conteudo);
	$Conteudo = str_replace('<%TOTAL%>', $Total, $Conteudo);
?>