<?php
	#include das funcoes da tela inico
	include('functions/banco-conta.php');

	#Instancia o objeto
	$banco = new bancoconta();

	if($banco->VerificaSessao()){

		//Busca todas as compras realizadas
		$Auxilio = $banco->CarregaHtml('itens/minha-conta-itens');

		$Produtos = $banco->ListaProdutos($_SESSION['idusuario'],$Auxilio);
		#Imprimi valores
		$Conteudo = $banco->CarregaHtml('minha-conta');
		$Conteudo = str_replace('<%PRODUTOS%>',$Produtos,$Conteudo);
	}else{
		$banco->RedirecionaPara('cadastro/acesso-negado');
	}
?>