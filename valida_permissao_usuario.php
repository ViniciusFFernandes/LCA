<?php
  require_once("plano.class.php");
  //
  $dadosUser = $usuarios->buscarUsuario();
  //
  $plano = new plano();
  $assinatura = $plano->buscarUltimaAssinaturaPaga($dadosUser->id);
  //
  if(strtotime($assinatura->attributes->date_expire) < strtotime(date("Y-m-d"))){
    header('location: ../permissao/');
		exit;
  }
  //
?>