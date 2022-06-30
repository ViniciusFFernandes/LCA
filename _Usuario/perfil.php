<?php
  require_once("_BD/conecta_login.php");
  //
  //Precisa estar logado
  if (!isset($_SESSION['logado'])) {
    session_destroy();
    header('Location: ../index.php');
    exit;
  }
  //
  require_once("plano.class.php");
  //
  $dadosUser = $usuarios->buscarUsuario();
  //
  $plano = new plano();
  $assinaturas = $plano->buscarAssinaturas($dadosUser->id);
  //
   //
   $htmlAssinaturas = '';
   //
   foreach($assinaturas->data AS $assinaturaDados){
     $htmlAssinaturas .= $plano->geraListaAssinatura($assinaturaDados);
   }
  //
  $escondeCarteirinha = '';
  $mostraNaoAssinante = 'style="display:none;"';
  $assinatura = $plano->buscarUltimaAssinaturaPaga($dadosUser->id);
  //
  if(strtotime($assinatura->attributes->date_expire) < strtotime(date("Y-m-d"))){
    $escondeCarteirinha = 'style="display:none;"';
    $mostraNaoAssinante = '';
  }
  //
  $mostraSemAssinaturas = '';
  if(!empty($htmlAssinaturas)){
    $mostraSemAssinaturas = 'style="display:none;"';
  }
  //
  //Abre o arquivo html e Inclui mensagens e trechos php
  $html = $html->buscaHtml(pathinfo( __FILE__ ));
  $html = str_replace("##Mensagem##", $msg, $html);
  $html = str_replace("##nome##", $dadosUser->attributes->name, $html);
  $html = str_replace("##apelido##", $dadosUser->attributes->surname, $html);
  $html = str_replace("##cpf##", $dadosUser->attributes->CPF, $html);
  $html = str_replace("##rg##", $dadosUser->attributes->RG, $html);
  $html = str_replace("##rua##", $dadosUser->attributes->street, $html);
  $html = str_replace("##numero##", $dadosUser->attributes->address_number, $html);
  $html = str_replace("##cidade##", $dadosUser->attributes->city, $html);
  $html = str_replace("##estado##", $dadosUser->attributes->state, $html);
  $html = str_replace("##bairro##", $dadosUser->attributes->district, $html);
  $html = str_replace("##cep##", $dadosUser->attributes->CEP, $html);
  $html = str_replace("##validade##", '', $html);
  $html = str_replace("##email##", $dadosUser->attributes->users_permissions_user->data->attributes->email, $html);
  $html = str_replace("##numeroMembro##", $dadosUser->id, $html);
  $html = str_replace("##idcliente##", $dadosUser->id, $html);
  $html = str_replace("##idcliente_iugu##", $dadosUser->attributes->id_iugu, $html);
  $html = str_replace("##listaDeAssinaturas##", $htmlAssinaturas, $html);
  $html = str_replace("##escondeCarteirinha##", $escondeCarteirinha, $html);
  $html = str_replace("##mostraNaoAssinante##", $mostraNaoAssinante, $html);
  $html = str_replace("##mostraSemAssinaturas##", $mostraSemAssinaturas, $html);
  echo $html;
  exit;
?>