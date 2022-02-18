<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
date_default_timezone_set('America/Sao_Paulo');
//
// print_r($_REQUEST);exit;
require_once("../set_path.php");
require_once("usuarios.class.php");
require_once("html.class.php");
require_once("util.class.php");
require_once("constantes.lca");
//
//Se não existe define como null para evitar avisos de erro
if (!isset($_POST['operacao'])) {
	$_POST['operacao'] = null;
}
if (!isset($_SESSION['logado'])) {
	$_SESSION['logado'] = null;
}
//
//inicia as classes nescessarias
$usuarios = new usuarios();
$html = new html();
$util = new util();
//
//Efetua o login
if ($_POST['operacao'] == "logar") {
	//
	//Busca os dados do usuario na API
	$dados = $usuarios->buscarUsuarioLogin($_POST['usuario'], $_POST['senha']);
	//
	if(!empty($dados->jwt)){
		//
		$_SESSION['logado'] 						= true;
		$_SESSION['username'] 						= $dados->user->username;
		$_SESSION['email'] 							= $dados->user->email;
		$_SESSION['idusuario']				 	    = $dados->user->id;
		$_SESSION['jwt']				 	    	= $dados->jwt;
		header('Location: ../_Blog/blog');
		exit;
	}else{
		$_SESSION['logado'] = false;
		$_SESSION['mensagem'] = "Usuario ou senha incorretos!!!<br>Tente novamente";
    	$_SESSION['tipoMsg'] = "danger";
		header('location:../');
		exit;
	}
}

//
//Operação para inserir novo usuario
if($_POST['operacao'] == 'novaConta'){
	$dados = $usuarios->incluirNovoUsuario($_POST);
	//
	if(!empty($dados->jwt)){
		$_SESSION['mensagem'] = "Usuario cadastrado com sucesso!";
    	$_SESSION['tipoMsg'] = "succes";
		header('location:../');
		exit;
	}else{
		$_SESSION['mensagem'] = "Erro ao cadastrar novo usuario!";
    	$_SESSION['tipoMsg'] = "error";
		header('location:../nova_conta');
		exit;
	}
}

//
//Operação para deslogar do sistema
if ($_POST['operacao'] == "Sair") {
	session_destroy();
	header('Location: ../');
	exit;
}

// //
// //Verifica se o ususario pode acessar a pagina atual
// $usuarios = new Usuarios($db, $util, $_SESSION['idusuario'], $_SESSION['idgrupos_acessos']);
// if(!$usuarios->usuario_pode_executar()){
// 	$html->mostraErro("Você não tem permissão para executar este programa!<br>Consulte um administrador do sistema!<br> Programa: " . basename($_SERVER['PHP_SELF']));
// 	exit;
// }
?>
