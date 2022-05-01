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
//inicia as classes nescessarias
$usuarios = new usuarios();
$html = new html();
$util = new util();
?>
