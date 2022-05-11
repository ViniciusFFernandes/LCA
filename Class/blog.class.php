<?php
    require_once("util.class.php");

	class blog {
        private $util;

		function __construct(){
            $this->util = new Util();
		}

		public function buscarPosts(){
			//
			$headers = array();
            $headers[] = "Content-Type: application/json";
            $headers[] = "Authorization: Bearer " . $_SESSION['jwt'];
            //
            $parameters = array();
            $parameters['populate'] = '*';
			//
            $url = API . "/posts?" . http_build_query($parameters);
            //
            ob_start();
			//
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_exec($ch);
			//
            // JSON de retorno  
            $resposta = json_decode(ob_get_contents());
            // echo "<pre>";
            // print_r($resposta);
            // echo "</pre>";
            // exit;
            // $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            // $erro = curl_errno($ch);
            // $info = curl_getinfo($ch);
			//
            ob_end_clean();
            curl_close($ch);
			//
			return $resposta;
		}

        public function buscaPost($id_cadastro){
			//
			$headers = array();
            $headers[] = "Content-Type: application/json";
            $headers[] = "Authorization: Bearer " . $_SESSION['jwt'];
            //
            $parameters = array();
            $parameters['populate'] = '*';
			//
            $url = API . "/posts/{$id_cadastro}?" . http_build_query($parameters);
            //
            ob_start();
			//
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_exec($ch);
			//
            // JSON de retorno  
            $resposta = json_decode(ob_get_contents());
            $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $erro = curl_errno($ch);
            $info = curl_getinfo($ch);
			//
            ob_end_clean();
            curl_close($ch);
			//
			return $resposta;
		}

        public function geraPost($dados){
            $html = file_get_contents("_Blog/_HTML/componentes/postMini.html");
            //
            $html = str_replace("##tituloPost##", $dados->attributes->title, $html);
            $html = str_replace("##description##", substr($dados->attributes->content, 0, 80) . '...', $html);
			$html = str_replace("##idPost##", $dados->id, $html);
			$html = str_replace("##imgPost##", $dados->attributes->banner->data->attributes->url, $html);
			$html = str_replace("##dataPublicacao##", $this->util->convertDataAPI($dados->attributes->publishedAt, false), $html);
            //
            return $html;
        }
	}


?>
