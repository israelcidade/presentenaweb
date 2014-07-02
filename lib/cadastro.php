<?php
	#include das funcoes da tela inico
	include('functions/banco-cadastro.php');

	#Instancia o objeto
	$banco = new bancocadastro();

	if($banco->VerificaSessao()){
		$banco->RedirecionaPara('minha-conta');
	}else{

		#Trabalha com Post de Login
		if( isset($_POST["acao"]) && $_POST["acao"] != '' ){
		$usuario = strip_tags(trim(addslashes($_POST["usuario"])));
		$senha = strip_tags(trim(addslashes($_POST["senha"])));

		$flag = $banco->BuscaUsuario($usuario,$senha);

			if($flag){
				$banco->IniciaSessao($usuario);
				$banco->RedirecionaPara('minha-conta');
			}
		}

		#Trabalha com Post de Cadastro
		if( isset($_POST["acao"]) && $_POST["acao"] != '' && $_POST["acao"] == 'cadastro'){
			$nome = strip_tags(trim(addslashes($_POST["nome"])));
			$cpf = strip_tags(trim(addslashes($_POST["cpf"])));
			$email = strip_tags(trim(addslashes($_POST["email"])));
			$senha = strip_tags(trim(addslashes($_POST["senha"])));

			

		}
	}

	#Imprimi valores
	$Conteudo = $banco->CarregaHtml('cadastro');
?>