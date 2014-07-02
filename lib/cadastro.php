<?php
	#include das funcoes da tela inico
	include('functions/banco-cadastro.php');

	#Instancia o objeto
	$banco = new bancocadastro();

	$msg = '';

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
			$senha2 = strip_tags(trim(addslashes($_POST["senha2"])));

			if($banco->BuscaUsuarioPorCpf($cpf)){
				$msg = "Usuario ja cadastrado com esse Cpf";
			}elseif($senha != $senha2){
				$msgsenha = "Senhas Diferentes";
			}else{
				$Sql = "Insert into c_usuarios (nome,senha,cpf,email) VALUES ('".$nome."','".$senha."','".$cpf."','".$email."')";
				$banco->Execute($Sql);
				$banco->RedirecionaPara('minha-conta');
			}
		}
	}

	#Imprimi valores
	$Conteudo = $banco->CarregaHtml('cadastro');
	$Conteudo = str_replace('<%MSGUSUARIO%>', $msg, $Conteudo);
	$Conteudo = str_replace('<%MSGSENHA%>', $msgsenha, $Conteudo);
?>