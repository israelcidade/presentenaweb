<?php
	#include das funcoes da tela inico
	include('functions/banco-conta.php');

	#Instancia o objeto
	$banco = new bancoconta();

	if($banco->VerificaSessao()){


		#Imprimi valores
		$Conteudo = $banco->CarregaHtml('minha-conta');
	}else{
		$banco->RedirecionaPara('inicio/acesso-negado');
	}
?>