<?php
  require_once("_BD/conecta_login.php");
  require_once("eventos.class.php");
  //
  $eventos = new eventos();
  $posts = $eventos->buscarPosts();
  //
  $htmlPosts = '';
  //
  foreach($posts->data AS $post){
    $htmlPosts .= $eventos->geraPost($post);
  }
  //
  //Abre o arquivo html e Inclui mensagens e trechos php
  $html = $html->buscaHtml(pathinfo( __FILE__ ));
  $html = str_replace("##listaPosts##", $htmlPosts, $html);
  echo $html;
  exit;
?>