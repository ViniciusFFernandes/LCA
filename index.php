<?php 
  //Inicia Sessão
  session_start(); 
  //
  // require_once("set_path.php");
  //
  //Desativa os erros e permite apenas avisos
  error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
  //
  require_once("vendor/autoload.php");
  //
  //Inclui as rotas
  require_once("Class/rotas.class.php");
?>
