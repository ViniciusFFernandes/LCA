<?php
  require_once("../_BD/conecta_login.php");
  require_once("usuarios.class.php");
  //
  $usuarios = new usuarios();
  //
  $dadosUser = $usuarios->buscarUsuario();
  //
  if (isset($_SESSION['mensagem'])) {
    $msg = $html->mostraMensagem($_SESSION['tipoMsg'], $_SESSION['mensagem']);
    unset($_SESSION['mensagem'], $_SESSION['tipoMsg']);
  }
  //
  //Abre o arquivo html e Inclui mensagens e trechos php
  $html = $html->buscaHtml("blog");
  $html = str_replace("##Mensagem##", $msg, $html);
  $html = str_replace("##nome##", $dadosUser->username, $html);
  $html = str_replace("##email##", $dadosUser->email, $html);
  echo $html;
  exit;
?>