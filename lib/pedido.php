<?php
    #include das funcoes da tela inico
    include('functions/banco-pedido.php');

    #Instancia o objeto
    $banco = new bancopedido();

    if($banco->VerificaSessao()){

	    #Imprimi valores
	    $Conteudo = $banco->CarregaHtml('pedido');
	    $Conteudo = str_replace('<%URLPADRAO%>',UrlPadrao,$Conteudo);
    }else{
		$banco->RedirecionaPara('cadastro/acesso-negado');
	}
?>