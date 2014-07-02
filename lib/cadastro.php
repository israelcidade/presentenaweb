<?php
	#include das funcoes da tela inico
	include('functions/banco-cadastro.php');

	#Instancia o objeto
	$banco = new bancocadastro();

	$msg = '';
	$usuario = array();

	if($banco->VerificaSessao()){
		$banco->RedirecionaPara('minha-conta');
	}else{

		if($this->PaginaAux[0] == "ativar"){
			$msg = MSG_AVISO_ATIVAR;
		}

		#Trabalha com Post de Login
		if( isset($_POST["acao"]) && $_POST["acao"] != '' && $_POST["acao"] == 'login'){
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
			$usuario['nome'] = strip_tags(trim(addslashes($_POST["nome"])));
			$usuario['cpf'] = strip_tags(trim(addslashes($_POST["cpf"])));
			$usuario['email'] = strip_tags(trim(addslashes($_POST["email"])));
			$usuario['senha'] = strip_tags(trim(addslashes($_POST["senha"])));
			$usuario['senha2'] = strip_tags(trim(addslashes($_POST["senha2"])));

			$msg = $banco->InsereUsuario($usuario);
			if($msg == 'ok'){
				$banco->RedirecionaPara('cadastro/ativar');
			}
		}
	}

	#Imprimi valores
	$Conteudo = $banco->CarregaHtml('cadastro');
	$Conteudo = str_replace('<%MSG%>', $msg, $Conteudo);
?>