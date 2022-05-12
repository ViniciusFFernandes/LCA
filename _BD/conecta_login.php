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
	//Busca os dados do usuario na API
	$dados = $usuarios->buscarUsuarioLogin($_POST['usuario'], $_POST['senha']);
	// var_dump($dados);
	// exit;
	//
	if(!empty($dados->jwt)){
		//
		$_SESSION['logado'] 						= true;
		$_SESSION['username'] 						= $dados->user->username;
		$_SESSION['email'] 							= $dados->user->email;
		$_SESSION['idusuario']				 	    = $dados->user->id;
		$_SESSION['jwt']				 	    	= $dados->jwt;
		//
		if($_REQUEST['redirect'] != ""){
			header('Location: ../' . base64_decode($_REQUEST['redirect']));
		}else{
			header('Location: ../blog/');
		}
		exit;
	}else{
		$_SESSION['logado'] = false;
		$_SESSION['mensagem'] = "Usuario ou senha incorretos!!!<br>Tente novamente";
    	$_SESSION['tipoMsg'] = "danger";
		header('location: ../index.php');
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
		if($_REQUEST['redirect'] != ""){
			$dados = $usuarios->buscarUsuarioLogin($_POST['cpf'], $_POST['senha']);
			//
			$_SESSION['logado'] 						= true;
			$_SESSION['username'] 						= $dados->user->username;
			$_SESSION['email'] 							= $dados->user->email;
			$_SESSION['idusuario']				 	    = $dados->user->id;
			$_SESSION['jwt']				 	    	= $dados->jwt;
			//
			header('Location: ../' . base64_decode($_REQUEST['redirect']));
		}else{
			header('location: ../index.php');
		}
		exit;
	}else{
		$_SESSION['mensagem'] = "Erro ao cadastrar novo usuario!";
    	$_SESSION['tipoMsg'] = "error";
		header('location: cadastrar');
		exit;
	}
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
