<?php
	class banco{
		
		#Funcao que inicia conexao com banco
		function Conecta(){	
			$link = mysql_connect(DB_Host,DB_User,DB_Pass);
			if (!$link) {
				$this->ChamaManutencao();
			}
			$db_selected = mysql_select_db(DB_Database, $link);
			if (!$db_selected) {
				$this->ChamaManutencao();
			}
		}	
		
		#funcao que chama manutencao
		function ChamaManutencao(){
			$filename = 'html/manutencao.html';
			$handle = fopen($filename,"r");
			$Html = fread($handle,filesize($filename));
			fclose($handle);
			$SaidaHtml = $this->CarregaHtml('modelo');
			$SaidaHtml = str_replace('<%CONTEUDO%>',$Html,$SaidaHtml);
			$SaidaHtml = str_replace('<%URLPADRAO%>',UrlPadrao,$SaidaHtml);
			echo $SaidaHtml;
		}
		
		#funcao que monta o conteudo
		function MontaConteudo(){
			#verifica se nao tem nada do lado da URLPADRAO
			if(!isset($this->Pagina)){
				return $Conteudo = $this->ChamaPhp('inicio');
			#verifica se a pagina existe e chama ela
			}elseif($this->BuscaPagina()){
				return $Conteudo = $this->ChamaPhp($this->Pagina);
			#Se nao tiver pagina chama 404
			}else{
				return $Conteudo = $this->CarregaHtml('404');
			}
		}

		#abre a sessao
		function IniciaSessao($email){
			session_start('login');
			$Sql = "Select * from c_usuarios where email = '".$email."'";
			$result = $this->Execute($Sql);
			$num_rows = $this->Linha($result);
			$rs = mysql_fetch_array($result , MYSQL_ASSOC);
			$_SESSION['usuario'] = $rs['nome'];
			$_SESSION['email'] = $rs['email'];
			$_SESSION['idusuario'] = $rs['idusuario'];
		}

		#fecha sessao
		function FechaSessao(){
			session_start('login');
			$_SESSION = array();
			session_destroy();
		}

		function VerificaSessao(){
			session_start('login');
			if( isset($_SESSION['usuario']) ){
				return true;
			}else{
				return false;
			}
		}
		
		#Busca a pagina e verifica se existe
		function BuscaPagina(){
			$Sql = "Select * from c_paginas where nome = '".$this->Pagina."'";
			$result = $this->Execute($Sql);
			$num_rows = $this->Linha($result);
			if($num_rows){
				return true;
			}else{
				return false;
			}
		}
		
		#Fun��o que chama a pagina.php desejada.
		public function ChamaPhp($Nome){
			@require_once('lib/'.$Nome.'.php');
			return $Conteudo;
		}
	
		#Fun��o que monta o html da pagina
		public function CarregaHtml($Nome){
			$filename = 'html/'.$Nome.".html";
			$handle = fopen($filename,"r");
			$Html = fread($handle,filesize($filename));
			fclose($handle);
			return $Html;
		}
		
		#Funcao que executa uma Sql e retorna.
		static function Execute($Sql){
			$result = mysql_query($Sql);
			return $result;
		}
		
		#Funcao que retorna o numero de linhas 
		static function Linha($result){
			$num_rows = mysql_num_rows($result);
			return $num_rows;
		}
		
		#Funcao que redireciona para pagina solicitada
		function RedirecionaPara($nome){
			header("Location: ".UrlPadrao.$nome);
		}
		
		#Funcao que carrega as p�ginas
		function CarregaPaginas(){
			$primeiraBol = true;
			$uri = $_SERVER["REQUEST_URI"];
			$exUrls = explode('/',$uri);
			$SizeUrls = count($exUrls)-1;

			$p = 0;
			foreach( $exUrls as $chave => $valor ){
				if( $valor != '' && $valor != UrlDesenvolve ){
					$valorUri = $valor;
					$valorUri = strip_tags($valorUri);
					$valorUri = trim($valorUri);
					$valorUri = addslashes($valorUri);
					
					if( $primeiraBol ){
						$this->Pagina = $valorUri;
						$primeiraBol = false;
					}else{
						$this->PaginaAux[$p] = $valorUri;
						$p++;
					}
				}
			}
		}

		#funcao imprime conteudo
		function Imprime($Conteudo){
			if($this->Pagina == 'admin'){
				$SaidaHtml = $this->CarregaHtml('modelo-admin');
			}else{
				$SaidaHtml = $this->CarregaHtml('modelo');
			}
			$SaidaHtml = $this->InfoSacola($SaidaHtml,$Conteudo);
			$SaidaHtml = $this->InfoUsuario($SaidaHtml,$Conteudo);
			$SaidaHtml = str_replace('<%CONTEUDO%>',$Conteudo,$SaidaHtml);
			$SaidaHtml = str_replace('<%URLPADRAO%>',UrlPadrao,$SaidaHtml);
			echo $SaidaHtml;
		}

		function GeraCodigo($tamanho,$maiusculas,$numeros,$simbolos){
			$lmin = 'abcdefghijklmnopqrstuvwxyz';
			$lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$num = '1234567890';
			$simb = '!@#$%*-';
			$retorno = '';
			$caracteres = '';

			$caracteres .= $lmin;
			if ($maiusculas) $caracteres .= $lmai;
			if ($numeros) $caracteres .= $num;
			if ($simbolos) $caracteres .= $simb;

			$len = strlen($caracteres);
			for ($n = 1; $n <= $tamanho; $n++) {
				$rand = mt_rand(1, $len);
				$retorno .= $caracteres[$rand-1];
			}
			return $retorno;
		}

		function InfoSacola($SaidaHtml,$Conteudo){
			session_start('sacola');
			if(empty($_SESSION['sacola'])){
				$i = 0;
				$total = '000,00';
				$cart = 'sad';
			}else{
				$cart = 'happy';
				foreach ($_SESSION['sacola'] as $key => $value) {
					$Sql = "Select * from c_produtos where idproduto = '".$value."'";
					$result = $this->Execute($Sql);
					$num_rows = $this->Linha($result);
					$rs = mysql_fetch_array($result , MYSQL_ASSOC);
					$i++;
					$total = $total + $rs['valorvenda'];
				}
				$total = ceil($total);
				$total = number_format($total+15, 2, ',', '.');
			}
			
			$SaidaHtml = str_replace('<%QUANTIDADE%>',$i,$SaidaHtml);
			$SaidaHtml = str_replace('<%TOTAL%>',$total,$SaidaHtml);
			$SaidaHtml = str_replace('<%CART%>',$cart,$SaidaHtml);
			return $SaidaHtml;
		}

		function InfoUsuario($SaidaHtml,$Conteudo){
			$usuario = '';
			$deslogar = "Bem vindo: ".$_SESSION['usuario']." <a href='".UrlPadrao."inicio/deslogar'>(Sair)</a>";
			$minhaconta = "<a href='".UrlPadrao."minha-conta'>Minha Conta</a>";
			$entrar = "<a href='".UrlPadrao."cadastro'>Entrar</a>";
			$cadastro = "<a href='".UrlPadrao."cadastro'>Cadastre-se</a>";
			$alterasenha = "<a href='javascript:AlterarSenha()'>Alterar Senha</a>";
			if($this->VerificaSessao()){
				//Variaveis se Tiver Logado
				$usuario = $_SESSION['usuario'];

				$SaidaHtml = str_replace('<%SAIR%>',$deslogar,$SaidaHtml);
				$SaidaHtml = str_replace('<%USUARIO%>',$usuario,$SaidaHtml);
				$SaidaHtml = str_replace('<%ENTRAR%>',$minhaconta,$SaidaHtml);
				$SaidaHtml = str_replace('<%CADASTRESE%>',$alterasenha,$SaidaHtml);
			}else{
				//Variaveis se estiver deslogado
				$SaidaHtml = str_replace('<%SAIR%>','Ol&aacute;, Fique a Vontade!',$SaidaHtml);
				$SaidaHtml = str_replace('<%ENTRAR%>',$entrar,$SaidaHtml);
				$SaidaHtml = str_replace('<%CADASTRESE%>',$cadastro,$SaidaHtml);
			}
			return $SaidaHtml;
		}
//$deslogar = "Bem Vindo ".$_SESSION['usuario']." <a href='".UrlPadrao."inicio/deslogar/' onClick=\"return confirm('Tem certeza que deseja deslogar ?')\" > (Sair)</a>";
		function FinalzarCompra($pedido){
			$Sql = "Insert into c_pedidos (nomedestinatario,cep,enderecoentrega,numero,complemento,bairro,cidade,estado,pais) 
			VALUES ('".$pedido['nome-destinatario']."','".$pedido['cep']."','".$pedido['endereco-entrega']."','".$pedido['numero']."','".$pedido['complemento']."','".$pedido['bairro']."','".$pedido['cidade']."','".$pedido['estado']."','".$pedido['pais']."')";
			$result = $this->Execute($Sql);
			$num_rows = $this->Linha($result);
			return 'ok';
		}

		function MontaMsg($tipo,$msg){
			if($tipo == 'erro'){
				$flag = "<div class='alert alert-danger' role='alert'>
      			<strong>Erro!</strong> ".$msg." </div>";
			}elseif($tipo == 'ok'){
				$flag = "<div class='alert alert-success' role='alert'>
      			<strong>OK!</strong> ".$msg." </div>";
			}elseif($tipo == 'atencao'){
				$flag = "<div class='alert alert-warning' role='alert'>
      			<strong>Aviso!</strong> ".$msg." </div>";
			}
			return $flag;
		}
	}
?>