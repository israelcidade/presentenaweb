<?php
	//Definições do Sistema
	date_default_timezone_set('America/Sao_Paulo');
	define('UrlPadrao' , "http://localhost/presentenaweb/");
	define('UrlDesenvolve',"presentenaweb");
	
	//Definições do Banco de Dados
	define('DB_Host' , "localhost");
	define('DB_Database' , "presentenaweb");
	define('DB_User' , "root");
	define('DB_Pass' , "");

	//Definicoes do Eamil para contato
	define('EMAIL_USER', "israelcbj@gmail.com");
	define('EMAIL_PASS', "m4r4n4t4");
	define('EMAIL_RECEB', "israelcbj@gmail.com");

	//-----------------------------------------------------------------------------------------//

	//Mensagens de Erro
	define('MSG_ERRO_BANCO','Falha ao conectar no banco de dados, tente novamente mais tarde!');
	define('MSG_ERRO_CPF_EXISTENTE','Ja possuimos um cadastro com esse cpf');
	define('MSG_ERRO_SENHA_DIFERENTE','Senhas diferentes');
	define('MSG_ERRO_SENHA_OU_EMAIL','Senha ou Email Invalidos');
	define('MSG_ERRO_DISPARA_EMAIL','Erro ao disparar email com ativador');
	define('MSG_ERRO_ATIVAR_CONTA','Erro ao Ativar conta! entre em contato.');
	define('MSG_ERRO_SALVAR_PRODUTO','Erro ao Salvar o Produto.');
	define('MSG_ERRO_SALVAR_KIT','Erro ao Salvar o Kit.');
	define('MSG_ERRO_ADICIONAR_SACOLA','Erro ao Adicionar Kit na Sacola');

	//Mensagens de Ok
	define('MSG_OK_USUARIO','Cadastro Realizado com Sucesso!');
	define('MSG_OK_CONTA_ATIVADA','Conta Ativada com Sucesso!');
	define('MSG_OK_PRODUTO_CADASTRADO','Produto Cadastrado com Sucesso!');
	define('MSG_OK_KIT_CADASTRADO','KIT Cadastrado com sucesso!');
	define('MSG_OK_KIT_ADICIONADO_SACOLA','KIT adicionado na sacola com sucesso');

	//Mensagens de Avisos
	define('MSG_AVISO_ATIVAR','Por Favor, ative sua conta antes de acessar!');
?>