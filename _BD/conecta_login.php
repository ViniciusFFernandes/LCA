<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
date_default_timezone_set('America/Sao_Paulo');
//
//Adicona os path padrões do sistema
$path = PATH_SEPARATOR . '../Class/';
$path .= PATH_SEPARATOR . 'Class/';
$path .= PATH_SEPARATOR . '../privado/';
$path .= PATH_SEPARATOR . 'privado/';
$path .= PATH_SEPARATOR . '../_BD/';
$path .= PATH_SEPARATOR . '_BD/';
$path .= PATH_SEPARATOR . 'vendor/';
$path .= PATH_SEPARATOR . '../vendor/';
set_include_path(get_include_path() . $path);
//
require_once("usuarios.class.php");
require_once("html.class.php");
require_once("util.class.php");
require_once("constantes.lca");
//
//Se não existe define como null para evitar avisos de erro
if (!isset($_POST['operacao'])) {
	$_POST['operacao'] = null;
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
	$retorno = array();
	//
	//Busca os dados do usuario na API
	$dados = $usuarios->buscarUsuarioLogin($_POST['usuario'], $_POST['senha']);
	//
	if(!empty($dados->jwt)){
		$retorno['erro'] = 0;
		//
		$_SESSION['logado'] 						= true;
		$_SESSION['username'] 						= $dados->user->username;
		$_SESSION['email'] 							= $dados->user->email;
		$_SESSION['idusuario']				 	    = $dados->user->id;
		$_SESSION['jwt']				 	    	= $dados->jwt;
		//
		if($_REQUEST['redirect'] != ""){
			$retorno['url'] = '..'. $_SERVER['BASE'] . '/' . base64_decode($_POST['redirect']);
		}else{
			$retorno['url'] = '..' . $_SERVER['BASE'] . '/blog/';
		}
	}else{
		$_SESSION['logado'] = false;
		$retorno['erro'] = 1;
	}
	//
	echo json_encode($retorno);
	exit;
}

//
//Operação para inserir novo usuario
if($_POST['operacao'] == 'novaConta'){
	//
	$retorno = array();
	//
	$dados = $usuarios->incluirNovoUsuario($_POST);
	//
	if(!empty($dados->jwt)){
		$retorno['erro'] = 0;
		if($_POST['redirect'] != ""){
			$dados = $usuarios->buscarUsuarioLogin($_POST['cpf'], $_POST['senha']);
			//
			$_SESSION['logado'] 						= true;
			$_SESSION['username'] 						= $dados->user->username;
			$_SESSION['email'] 							= $dados->user->email;
			$_SESSION['idusuario']				 	    = $dados->user->id;
			$_SESSION['jwt']				 	    	= $dados->jwt;
			//
			$retorno['tipo'] = 1;
			$retorno['url'] = '../' . $_SERVER['BASE'] . '/' . base64_decode($_POST['redirect']);
		}else{
			$retorno['tipo'] = 2;
		}
	}else{
		$retorno['erro'] = 1;
	}
	//
	echo json_encode($retorno);
	exit;
}

//
//Operação para deslogar do sistema
if ($_POST['operacao'] == "Sair") {
	session_destroy();
	header('Location: ../index.php');
	exit;
}

// if (!isset($_SESSION['logado'])) {
// 	session_destroy();
// 	header('Location: ../index.php');
// 	exit;
// }
?>
