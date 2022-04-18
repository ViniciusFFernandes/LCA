<?php
  require_once("_BD/conecta_login.php");
  require_once("blog.class.php");
  //
  $blog = new blog();
  //
  $conversorMark = new Parsedown();
  //
  $post = $blog->buscaPost($idpost);
  //
  if(!empty($post->error)){
    if($post->error->status == 403){
      $html->mostraErro("Você não tem acesso a este conteudo, crie uma conta e tente novamente!");
    }else{
      $html->mostraErro("Erro ao carregar conteudo!");
    }
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
  $html = str_replace("##tituloPost##", $post->data->attributes->titulo, $html);
  $html = str_replace("##conteudoPost##", $conversorMark->text($post->data->attributes->content), $html);
  $html = str_replace("##imgPost##", $post->data->attributes->banner->data->attributes->url, $html);
  $html = str_replace("##dataPublicacao##", $util->convertDataAPI($post->data->attributes->publishedAt), $html);
  echo $html;
  exit;
?>