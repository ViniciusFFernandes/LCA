<?php 
  //Inicia Sessão
  session_start(); 
  //
  //Desativa os erros e permite apenas avisos
  error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
  //
  //Verifica se já está logado
  if($_SESSION['logado']){
    header('Location: _Blog/blog.php');
    exit;
  }
  //
  if(!realpath("privado/constantes.lca")){
    echo "Constante não encontrato!<br>Verifique e tente novamente...";
    exit;
  }
  //
  require_once("set_path.php");
  //
  require_once("privado/constantes.lca");
  //
  //Inclui classes
  require_once("html.class.php");
  $html = new html('');
  //
  //Monta variaveis de exibição
  if (isset($_SESSION['mensagem'])) {
    $msg = $html->mostraMensagem($_SESSION['tipoMsg'], $_SESSION['mensagem']);
    unset($_SESSION['mensagem'], $_SESSION['tipoMsg']);
  }
  //
  //Abre o arquivo html e Inclui mensagens e trechos php
  $html = file_get_contents('login.html');
  $html = str_replace("##Mensagem##", $msg, $html);
  echo $html;
  exit;
?>
