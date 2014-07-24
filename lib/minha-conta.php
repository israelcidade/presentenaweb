<?php
	#include das funcoes da tela inico
	include('functions/banco-conta.php');

	#Instancia o objeto
	$banco = new bancoconta();

	if($banco->VerificaSessao()){

		if($this->PaginaAux[0] == 'check'){
			//$teste = 'http://localhost/presentenaweb/minha-conta/check/?id_pagseguro=F498A827-7870-42D7-B3A6-777F0A87241A';
			$aux = explode('=',$this->PaginaAux[1]);
			$codigo_pagseguro = $aux[1];
		}	
		

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