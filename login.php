<?php 
  //
  //Verifica se já está logado
  if($_SESSION['logado']){
    header('Location: blog/');
    exit;
  }
  //
  if(!realpath("privado/constantes.lca")){
    echo "Constante não encontrato!<br>Verifique e tente novamente...";
    exit;
  }
  //
  require_once("privado/constantes.lca");
  //
  //Inclui classes
  require_once("Class/html.class.php");
  $html = new html();
  //
  //Monta variaveis de exibição
  $redirectCadastro = '';
  if(!empty($_REQUEST['redirect'])) $redirectCadastro = '?redirect=' . $_REQUEST['redirect'];
  //
  //Abre o arquivo html e Inclui mensagens e trechos php
  $html = file_get_contents('login.html');
  $html = str_replace("##redirect##", $_REQUEST['redirect'], $html);
  $html = str_replace("##redirectCadastrar##", $redirectCadastro, $html);
  echo $html;
  exit;
?>
