<?php 
  //Inicia Sessão
  session_start(); 
  //
  //Desativa os erros e permite apenas avisos
  error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
  //
  require_once("set_path.php");
  require_once("privado/constantes.lca");
  //
  //Inclui classes
  require_once("html.class.php");
  $html = new html();
  //
  //Monta variaveis de exibição
  $linkLogin = $_SERVER['BASE'] . "/";
  if(!empty($_REQUEST['redirect'])) $linkLogin .= '?redirect=' . $_REQUEST['redirect'];
  //
  //Abre o arquivo html e Inclui mensagens e trechos php
  $html = $html->buscaHtml(pathinfo( __FILE__ ));
  $html = str_replace("##redirect##", $_REQUEST['redirect'], $html);
  $html = str_replace("##linkLogin##", $linkLogin, $html);
  echo $html;
  exit;
?>
