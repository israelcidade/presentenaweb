<?php
	#include das funcoes da tela inico
	include('functions/banco-inicio.php');

	#Instancia o objeto
	$banco = new bancoinicio();

	if($this->PaginaAux[0] == 'deslogar'){
		$banco->FechaSessao();
		$banco->RedirecionaPara('inicio');
	}

	if($this->PaginaAux[0] == 'acesso-negado'){
		$msg = "Acesso Negado";
	}

	#Trabalha com Post
	if( isset($_POST["acao"]) && $_POST["acao"] != '' ){
		$usuario = strip_tags(trim(addslashes($_POST["usuario"])));
		$senha = strip_tags(trim(addslashes($_POST["senha"])));

		$flag = $banco->BuscaUsuario($usuario,$senha);

		if($flag){
			$banco->IniciaSessao($usuario);
			$banco->RedirecionaPara('minha-conta');
		}
	}

	if($banco->VerificaSessao()){
		$deslogar = "<a href='".UrlPadrao."inicio/deslogar/' onClick=\"return confirm('Tem certeza que deseja deslogar ?')\" >Deslogar</a>";
	}

	#Imprimi valores
	$Conteudo = $banco->CarregaHtml('inicio');
	$Conteudo = str_replace('<%SAIR%>', $deslogar, $Conteudo);
	$Conteudo = str_replace('<%MSG%>', $msg, $Conteudo);
?>