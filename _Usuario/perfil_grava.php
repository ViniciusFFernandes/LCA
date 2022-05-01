<?php
  require_once("../_BD/conecta_login.php");
  require_once("usuarios.class.php");
  require_once("iugu.class.php");
  //
  if($_POST['operacao'] == 'alterarUsuario'){
      $dadosUser = $usuarios->alteraCliente($_POST);
      //
      echo json_encode($dadosUser);
      exit;
  }

  if($_POST['operacao'] == 'pagarAssinatura'){
    //
    $iugu = new iugu();
    $retorno = $iugu->buscaFatura($_POST['idfatura']);
    //
    echo json_encode($retorno);
    exit;
}
?>