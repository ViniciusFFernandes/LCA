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
//inicia as classes nescessarias
$usuarios = new usuarios();
$html = new html();
$util = new util();
//
//
if(!$_SESSION['logado'] ){
    $dados = $usuarios->buscarUsuarioLogin(USER_PADRAO_USUARIO, USER_PADRAO_SERNHA);
    //
    $_SESSION['logado'] 				= false;
    $_SESSION['username'] 				= $dados->user->username;
    $_SESSION['email'] 					= $dados->user->email;
    $_SESSION['idusuario']				= $dados->user->id;
    $_SESSION['jwt']				 	= $dados->jwt;
}
?>
