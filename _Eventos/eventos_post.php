<?php
  require_once("_BD/conecta_login.php");
  require_once("valida_permissao_usuario.php");
  require_once("eventos.class.php");
  //
  $eventos = new eventos();
  $conversorMark = new Parsedown();
  //
  $post = $eventos->buscaPost($idpost);
  //
  //Abre o arquivo html e Inclui mensagens e trechos php
  $html = $html->buscaHtml(pathinfo( __FILE__ ));
  $html = str_replace("##tituloPost##", $post->data->attributes->title, $html);
  $html = str_replace("##conteudoPost##", $conversorMark->text($post->data->attributes->content), $html);
  $html = str_replace("##imgPost##", $post->data->attributes->banner->data->attributes->url, $html);
  $html = str_replace("##dataPublicacao##", $util->convertDataAPI($post->data->attributes->publishedAt), $html);
  echo $html;
  exit;
?>