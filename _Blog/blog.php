<?php
  require_once("_BD/conecta_login.php");
  require_once("blog.class.php");
  //
  $blog = new blog();
  //
  $posts = $blog->buscarPosts();
  //
  if(!empty($posts->error)){
    if($posts->error->status == 403){
      $html->mostraErro("Você não tem acesso a este conteudo, crie uma conta e tente novamente!");
    }else{
      $html->mostraErro("Erro ao carregar conteudo!");
    }
  }
  //
  $htmlPosts = '';
  foreach($posts->data AS $post){
    $htmlPosts .= $blog->geraPost($post);
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
  $html = str_replace("##listaPosts##", $htmlPosts, $html);
  echo $html;
  exit;
?>