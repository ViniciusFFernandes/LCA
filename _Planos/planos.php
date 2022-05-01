<?php
  require_once("_BD/conecta_login.php");
  require_once("plano.class.php");
  //
  $plano = new plano();
  //
  $planos = $plano->buscarPlanos();
  //
  if(!empty($planos->error)){
    if($planos->error->status == 403){
      $html->mostraErro("Você não tem acesso a este conteudo, crie uma conta e tente novamente!");
    }else{
      $html->mostraErro("Erro ao carregar conteudo!");
    }
  }
  //
  $htmlPlanos = '';
  //
  foreach($planos->data AS $planoDados){
    $htmlPlanos .= $plano->geraPlano($planoDados);
  }
  //
  if (isset($_SESSION['mensagem'])) {
    $msg = $html->mostraMensagem($_SESSION['tipoMsg'], $_SESSION['mensagem']);
    unset($_SESSION['mensagem'], $_SESSION['tipoMsg']);
  }
  //
  //Abre o arquivo html e Inclui mensagens e trechos php
  $html = $html->buscaHtml(pathinfo( __FILE__ ));
  $html = str_replace("##Mensagem##", $msg, $html);
  $html = str_replace("##listaPlanos##", $htmlPlanos, $html);
  echo $html;
  exit;
?>