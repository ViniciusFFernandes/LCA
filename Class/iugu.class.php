<?php
    require_once("util.class.php");

	class iugu {
        private $util;

		function __construct(){
            $this->util = new Util();
		}

		public function gerarToken(){
			//
			// $headers = array();
            // $headers[] = "Accept: application/json";
            // $headers[] = "Content-Type: application/json";
            // $headers[] = "Authorization: Basic Base64(" . TOKEN_TESTE_IUGU . ":" . ")"; // Coloque aqui seu Token
			// //
			// $url = "https://api.iugu.com/v1/" . ID_CONTA_IUGU . "/api_tokens";
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
        
        public function incluirCliente($dados){
            //
            $headers = array();
            $data['email'] = $dados['email'];
            $data['name'] = $dados['nome'];
            $data['cpf_cnpj'] = $dados['cpf'];
            $data['street'] = $this->util->nulo($dados['rua']);
            $data['number'] = $this->util->nulo($dados['numero']);
            $data['district'] = $this->util->nulo($dados['bairro']);
            $data['city'] = $this->util->nulo($dados['cidade']);
            $data['state'] = $this->util->nulo($dados['estado']);
            $data['zip_code'] = $this->util->nulo($dados['cep']);
            //
            $headers = array();
            $headers[] = "Accept: application/json";
            $headers[] = "Content-Type: application/json";
            $headers[] = "Authorization: Basic Base64(" . TOKEN_TESTE_IUGU . ":" . ")"; // Coloque aqui seu Token
			//
			$url = "https://api.iugu.com/v1/customers?api_token=" . TOKEN_TESTE_IUGU;
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

		public function atualizarCliente($dados){
            //
            $data = array();
            // $data['email'] = $dados['email'];
			$data['name'] = $this->util->nulo($dados['nome']);
            $data['cpf_cnpj'] = $this->util->nulo($dados['cpf']);
            $data['street'] = $this->util->nulo($dados['rua']);
            $data['number'] = $this->util->nulo($dados['numero']);
            $data['district'] = $this->util->nulo($dados['bairro']);
            $data['city'] = $this->util->nulo($dados['cidade']);
            $data['state'] = $this->util->nulo($dados['estado']);
            $data['zip_code'] = $this->util->nulo($dados['cep']);
            //
            $headers = array();
            $headers[] = "Accept: application/json";
            $headers[] = "Content-Type: application/json";
            $headers[] = "Authorization: Basic Base64(" . TOKEN_TESTE_IUGU . ":" . ")"; // Coloque aqui seu Token
			//
			$url = "https://api.iugu.com/v1/customers/{$dados['idcliente_iugu']}?api_token=" . TOKEN_TESTE_IUGU;
            //
			ob_start();
			//
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
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
                $retorno = "Erro";
            }
			//
			return $retorno;
        }

		public function gerarFatura($idassinatura, $dadosPlano, $dadosCliente, $email, $vencimento){
            //
            $data = array();
            $data['email'] = $email;
            $data['due_date'] = $vencimento;
            $data['items'][0]['description'] = "Assinatura de {$dadosPlano->duration_in_months} meses";
            $data['items'][0]['quantity'] = 1;
            $data['items'][0]['price_cents'] = $dadosPlano->value_in_cents;
            $data['return_url'] = "";
            $data['expired_url'] = "";
            $data['notification_url'] = URL_SISTEMA . "/_Planos/webhook_iugu.php";
            // $data['notification_url'] = "";
            $data['ignore_canceled_email'] = false;
            $data['fines'] = false;
            $data['customer_id'] = $dadosCliente->id_iugu;
            $data['ignore_due_email'] = false;
            $data['payable_with'][0] = "credit_card";
            $data['payable_with'][1] = "pix";
            $data['custom_variables'][0]['name'] = "idassinatura";
            $data['custom_variables'][0]['value'] = $idassinatura;
            $data['early_payment_discount'] = false;
            $data['payer']['cpf_cnpj'] = $dadosCliente->CPF;
            $data['payer']['name'] = $dadosCliente->name;
            $data['payer']['phone_prefix'] = "";
            $data['payer']['phone'] = "";
            $data['payer']['email'] = $email;
            $data['payer']['address']['zip_code'] = $dadosCliente->CEP;
            $data['payer']['address']['street'] = $dadosCliente->street;
            $data['payer']['address']['number'] = $dadosCliente->address_number;
            $data['payer']['address']['district'] = $dadosCliente->district;
            $data['payer']['address']['city'] = $dadosCliente->city;
            $data['payer']['address']['state'] = $dadosCliente->state;
            $data['payer']['address']['country'] = "Brasil";
            $data['payer']['address']['complement'] = "";
            $data['order_id'] = $idassinatura;
            //
            $headers = array();
            $headers[] = "Accept: application/json";
            $headers[] = "Content-Type: application/json";
            $headers[] = "Authorization: Basic Base64(" . TOKEN_TESTE_IUGU . ":" . ")"; // Coloque aqui seu Token
			//
			$url = "https://api.iugu.com/v1/invoices?api_token=" . TOKEN_TESTE_IUGU;
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
			return $resposta;
        }

		public function buscaFatura($idfatura){
            //
            //
            $headers = array();
            $headers[] = "Accept: application/json";
            $headers[] = "Content-Type: application/json";
            $headers[] = "Authorization: Basic Base64(" . TOKEN_TESTE_IUGU . ":" . ")"; // Coloque aqui seu Token
			//
			$url = "https://api.iugu.com/v1/invoices/{$idfatura}?api_token=" . TOKEN_TESTE_IUGU;
            //
			ob_start();
			//
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			// curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
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
			return $resposta;
        }

		public function cancelarFatura($idfatura){
            //
            //
            $headers = array();
            $headers[] = "Accept: application/json";
            $headers[] = "Content-Type: application/json";
            $headers[] = "Authorization: Basic Base64(" . TOKEN_TESTE_IUGU . ":" . ")"; // Coloque aqui seu Token
			//
			$url = "https://api.iugu.com/v1/invoices/{$idfatura}/cancel?api_token=" . TOKEN_TESTE_IUGU;
            //
			ob_start();
			//
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			// curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
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
			return $resposta;
        }
	}


?>
