<?php
	#include das funcoes da tela inico
	include('functions/banco-finalizar.php');

	#Instancia o objeto
	$banco = new bancofinalizar();

	if($banco->VerificaSessao()){

		session_start('sacola');

		//foreach ($_POST as $key => $value) {
			//$pedido[$key] = strip_tags(trim(addslashes($_POST[$key])));
		//}
		
		$ItensPagSeguro          = $banco->MontaItens($_SESSION['sacola']);
		$ItensPagSeguroComprador = $banco->MontaItensComprador($_SESSION['email']);
		
		#Imprimi valores
		$Conteudo = $banco->CarregaHtml('finalizar-pedido');
		$Conteudo = str_replace('<%MSG%>', $msg, $Conteudo);
		$Conteudo = str_replace('<%ITENSPAGSEGURO%>', $ItensPagSeguro, $Conteudo);
		$Conteudo = str_replace('<%ITENSPAGSEGUROCOMPRADOR%>', $ItensPagSeguroComprador, $Conteudo);
	}else{
		$banco->RedirecionaPara('inicio/acesso-negado');
	}
?>