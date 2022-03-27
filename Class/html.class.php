<?php
	class html{

		function __construct(){

		}

		public function mostraErro($mensagem){
			$html = file_get_contents("componentes/msgErro.html");
            //
            $html = str_replace("##mensagem##", $mensagem, $html);
			//
			echo $html;
			exit;
		}

		public function mostraMensagem($tipo, $mensagem){
			$html = file_get_contents("componentes/msg.html");
            //
            $html = str_replace("##tipo##", $tipo, $html);
            $html = str_replace("##mensagem##", $mensagem, $html);
			return $msg;
		}

		public function defineChecked($string){
			if($string == "SIM"){
				return "checked";
			}else{
				return "";
			}
		}

		public function defineSelected($valorPadrao, $valor){
			if($valorPadrao == $valor){
				return 'selected="selected"';
			}else{
				return "";
			}
		}

		public function buscaHtml($pathComponente){
			$menu = file_get_contents('componentes/menu.html');
			if($_SESSION['logado']){
				$menu = str_replace("##MinhaConta##", file_get_contents('componentes/btnMinhaConta.html'), $menu);
			}else{
				$menu = str_replace("##MinhaConta##", file_get_contents('componentes/btnLogin.html'), $menu);
			}
			//
			$includes = file_get_contents('componentes/includes.html');
			//
			// var_dump($pathComponente);
			$patch = end(explode("\\", $pathComponente['dirname']));
			$nomeArquivo = $pathComponente['filename'] . ".html";
			// var_dump(file_get_contents($patch . "/_HTML/" . $nomeArquivo));
			$html = file_get_contents($patch . "/_HTML/" . $nomeArquivo);
			$html = str_replace("##Menu##", $menu, $html);
			$html = str_replace("##includes##", $includes, $html);
			$html = str_replace("##includesRelatorios##", $includesRelatorios, $html);
			//
			return $html;
		}

		
	}
?>
