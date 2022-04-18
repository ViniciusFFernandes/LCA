<?php
    require_once("util.class.php");

	class yugu {
        private $util;

		function __construct(){
            $this->util = new Util();
		}

		public function gerarToken(){
			//
			// $headers = array();
            // $headers[] = "Accept: application/json";
            // $headers[] = "Content-Type: application/json";
            // $headers[] = "Authorization: Basic Base64(" . TOKEN_TESTE_YUGU . ":" . ")"; // Coloque aqui seu Token
			// //
			// $url = "https://api.iugu.com/v1/" . ID_CONTA_YUGU . "/api_tokens";
            // //
			// ob_start();
			// //
			// $ch = curl_init();
			// curl_setopt($ch, CURLOPT_URL, $url);
			// curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			// curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
			// curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			// curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			// curl_exec($ch);
			// //
			// // JSON de retorno  
			// $resposta = json_decode(ob_get_contents());
			// $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			// $erro = curl_errno($ch);
			// $info = curl_getinfo($ch);

			// ob_end_clean();
			// curl_close($ch);
			// //
			// ob_clean();
		}   
        
        public function incluirUsusaio($dados){
            //
            $headers = array();
            $data['email'] = $dados['email'];
            $data['name'] = $dados['nome'];
            $data['cpf_cnpj'] = $dados['cpf'];
            //
            $headers = array();
            $headers[] = "Accept: application/json";
            $headers[] = "Content-Type: application/json";
            $headers[] = "Authorization: Basic Base64(" . TOKEN_TESTE_YUGU . ":" . ")"; // Coloque aqui seu Token
			//
			$url = "https://api.iugu.com/v1/customers?api_token=" . TOKEN_TESTE_YUGU;
            //
			ob_start();
			//
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			// curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
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
            if($code == '200'){
                $retorno = $resposta->id;
            }else{
                $retorno = $resposta->error;
            }
			//
			return $retorno;
        }
	}


?>
