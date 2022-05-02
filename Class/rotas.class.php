<?php

	/*
	FAZ GESTÃO DE LINKS E URL AMIGAVEIS INCLUINDO NUMEROS DE PAGINAÇÃO, PASTAS, ARQUIVOS E LINKS
	*/

	$route = \PlugRoute\RouteFactory::create();

	$route->get('/', function() {
		require_once("login.php");
	});

	$route->get('/cadastrar', function() {
		require_once("_Usuario/nova_conta.php");
	});

	$route->get('/perfil/', function() {
		require_once("_Usuario/perfil.php");
	});

	$route->get('/planos/', function() {
		require_once("_Planos/planos.php");
	});

	$route->group(['prefix' => '/blog'], function($route) {
		$route->get('/', function() {
			require_once("_Blog/blog.php");
		});
		//
		$route->get('/{post}', function(\PlugRoute\Http\Request $request) {
			$idpost = $request->parameter('post');
			//
			require_once("_Blog/blog_post.php");
		});
	});

	$route->notFound(function(){
		echo "Pagina não encontrada";
	});

	$route->on();

?>