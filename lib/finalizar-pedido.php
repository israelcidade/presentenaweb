<?php
	#include das funcoes da tela inico
	include('functions/banco-finalizar.php');

	#Instancia o objeto
	$banco = new bancofinalizar();

	if( isset($_POST["acao"]) && $_POST["acao"] != '' && $_POST["acao"] == 'finalizar'){
		echo 'entrei';die;

	}

	#Imprimi valores
	$Conteudo = $banco->CarregaHtml('finalizar-pedido');
	$Conteudo = str_replace('<%MSG%>', $msg, $Conteudo);
	$Conteudo = str_replace('<%CEP%>', $cep, $Conteudo);
	$Conteudo = str_replace('<%CIDADE%>', $arr['cidade'], $Conteudo);
	$Conteudo = str_replace('<%BAIRRO%>', $arr['bairro'], $Conteudo);
	$Conteudo = str_replace('<%ESTADO%>', $arr['uf'], $Conteudo);
	$Conteudo = str_replace('<%ESDERECOENTREGA%>', $arr['tipo_logradouro'].' '.$arr['logradouro'], $Conteudo);
?>