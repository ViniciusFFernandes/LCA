<?php
  require_once("_BD/conecta_login.php");
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
  $html = $html->buscaHtml(pathinfo( __FILE__ ));
  $html = str_replace("##Mensagem##", $msg, $html);
  $html = str_replace("##nome##", $dadosUser->username, $html);
  $html = str_replace("##apelido##", '', $html);
  $html = str_replace("##cpf##", '', $html);
  $html = str_replace("##rg##", '', $html);
  $html = str_replace("##cidade##", '', $html);
  $html = str_replace("##estado##", '', $html);
  $html = str_replace("##email##", $dadosUser->email, $html);
  $html = str_replace("##numeroMembro##", $dadosUser->id, $html);
  echo $html;
  exit;
?>