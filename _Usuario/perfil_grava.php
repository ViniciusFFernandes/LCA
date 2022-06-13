<?php
  require_once("../_BD/conecta_login.php");
  require_once("usuarios.class.php");
  require_once("iugu.class.php");
  require_once("plano.class.php");
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

  if($_POST['operacao'] == 'cancelarAssinatura'){
    //
    $plano = new plano();
    $iugu = new iugu();
    $retorno = $iugu->cancelarFatura($_POST['idfatura']);
    //
    if($retorno->status == 'canceled'){
      $dadosAssinatura = $plano->buscarAssinatura($retorno->id);
      $plano->atualizaAssinatura($dadosAssinatura->id, $retorno->id, 'Processando Cancelamento');
    }
    //
    $assinaturas = $plano->buscarAssinaturasLigadas($_POST['idassinatura']);
    foreach ($assinaturas as $assinatura) {
      $retornoAssinaturaLigada = $iugu->cancelarFatura($assinatura->id_invoice_iugu);
      if($retorno->status == 'canceled'){
        $plano->atualizaAssinatura($assinatura->id, $retornoAssinaturaLigada->id, 'Processando Cancelamento');
      }
    }
    //
    echo json_encode($retorno);
    exit;
  }
?>