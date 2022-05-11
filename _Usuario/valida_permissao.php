<?php
  require_once("_BD/conecta_login.php");
  require_once("plano.class.php");
  //
  if (isset($_SESSION['mensagem'])) {
    $msg = $html->mostraMensagem($_SESSION['tipoMsg'], $_SESSION['mensagem']);
    unset($_SESSION['mensagem'], $_SESSION['tipoMsg']);
  }
  //
  //Abre o arquivo html e Inclui mensagens e trechos php
  $html = $html->buscaHtml(pathinfo( __FILE__ ));
  $html = str_replace("##Mensagem##", $msg, $html);
  echo $html;
  exit;
?>