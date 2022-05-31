<?php
  require_once("_BD/conecta_login.php");
  require_once("blog.class.php");
  //
  $blog = new blog();
  $posts = $blog->buscarPosts();
  //
  $htmlPosts = '';
  //
  foreach($posts->data AS $post){
    $htmlPosts .= $blog->geraPost($post);
  }
  //
  //Abre o arquivo html e Inclui mensagens e trechos php
  $html = $html->buscaHtml(pathinfo( __FILE__ ));
  $html = str_replace("##listaPosts##", $htmlPosts, $html);
  echo $html;
  exit;
?>