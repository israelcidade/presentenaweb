<?php
	#Definições do Sistema
	date_default_timezone_set('America/Sao_Paulo');
	define('UrlPadrao' , "http://localhost/presentenaweb/");
	define('UrlDesenvolve',"presentenaweb");
	
	#Definições do Banco de Dados
	define('DB_Host' , "localhost");
	define('DB_Database' , "presentenaweb");
	define('DB_User' , "root");
	define('DB_Pass' , "");
	
	#Definições FPDF
	define('DPI', 96);
	define('MM_IN_INCH', 25.4);
	define('A4_HEIGHT', 210);
	define('A4_WIDTH', 297);
	// tweak these values (in pixels)
	define('MAX_WIDTH', 500);
	define('MAX_HEIGHT', 500);

	//Mensagens de Erro
	define('MSG_ERRO_BANCO','Falha ao conectar no banco de dados, tente novamente mais tarde!');
	define('MSG_ERRO_CPF_EXISTENTE','Ja possuimos um cadastro com esse cpf');
	define('MSG_ERRO_SENHA_DIFERENTE','Senhas diferentes');

	//Mensagens de Ok
	define('MSG_OK_USUARIO','Cadastro Realizado com Sucesso!');

	//Mensagens de Avisos
	define('MSG_AVISO_ATIVAR','Por Favor, ative sua conta antes de acessar!');
?>