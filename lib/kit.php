<?php
	#include das funcoes da tela inico
	include('functions/banco-kit.php');

	#Instancia o objeto
	$banco = new bancokit();

	$nomekit = $this->PaginaAux[0];

	if(isset($_POST["acao"]) && $_POST["acao"] != '' && $_POST["acao"] == 'sacola'){
		//Recebe o kit escolhido e joga ele na SACOLA.
		//Depois redireciona para a tela de sacola.
		$idkit = strip_tags(trim(addslashes($_POST["idkit"])));
		
		$msg = $banco->AdicionaSacola($idkit);

		if($msg == 'ok'){
			$banco->RedirecionaPara('sacola/add');
		}else{
			$msg = MSG_ERRO_ADICIONAR_SACOLA;
		}
	}

	$Descricao = $banco->MontaDescricao($nomekit);

	#Imprimi valores
	$Conteudo = $banco->CarregaHtml('kit');
	$Conteudo = str_replace('<%MSG%>', $msg, $Conteudo);
	$Conteudo = str_replace('<%IDKIT%>', $nomekit, $Conteudo);
	$Conteudo = str_replace('<%DESCRICAOITENS%>', $Descricao, $Conteudo);
?>