<?php
    #include das funcoes da tela inico
    include('functions/banco-pedido.php');

    #Instancia o objeto
    $banco = new bancopedido();

    if($banco->VerificaSessao()){

        $idpedido = $this->PaginaAux[0];
        $result = $banco->VerificaPedido($idpedido,$_SESSION['idusuario']);
        if($result == true){

            $Pedido = $banco->BuscaPedido($idpedido);

            #Imprimi valores
            $Conteudo = $banco->CarregaHtml('pedido');
            $Conteudo = str_replace('<%URLPADRAO%>',UrlPadrao,$Conteudo);
            $Conteudo = str_replace('<%PEDIDO%>',$Pedido,$Conteudo);
            $Conteudo = str_replace('<%IDPEDIDO%>',$idpedido,$Conteudo);
        }else{
            $banco->RedirecionaPara('cadastro/acesso-negado');
        }
    }else{
		$banco->RedirecionaPara('cadastro/acesso-negado');
	}
?>