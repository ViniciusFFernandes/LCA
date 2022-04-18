<?php
    require_once("yugu.class.php");

	class usuarios {
        private $yugu;

		function __construct(){
            $this->yugu = new yugu();
		}

		public function buscarUsuarioLogin($usuario, $senha){
			//
			$headers = array();
            $headers[] = "Content-Type: application/json";
			//
			$dados = array();
			$dados['identifier'] = $usuario;
			$dados['password'] = $senha;
			//
            $url = API . '/auth/local';
            //
            ob_start();
			//
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dados));
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_exec($ch);
			//
            // JSON de retorno  
            $data = json_decode(ob_get_contents());
            // $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            // $erro = curl_errno($ch);
            // $info = curl_getinfo($ch);
			//
            ob_end_clean();
            curl_close($ch);
			//
			return $data;
		}
        
        public function incluiCliente($data, $idClienteYugu = 0, $jwt, $idusuario){
            //
            $headers = array();
            $headers[] = "Content-Type: application/json";
            $headers[] = "Authorization: Bearer " . $jwt;
            //
            $dados = array();
            $dados['data']['name'] = $data['nome'];
            $dados['data']['CPF'] = $data['cpf'];
            $dados['data']['surname'] = $data['apelido'];
            $dados['data']['RG'] = $data['rg'];
            $dados['data']['street'] = $data['rua'];
            $dados['data']['address_number'] = $data['numero'];
            $dados['data']['district'] = $data['bairro'];
            $dados['data']['city'] = $data['cidade'];
            $dados['data']['state'] = $data['estado'];
            $dados['data']['CEP'] = $data['cep'];
            $dados['data']['id_iugu'] = $idClienteYugu;
            $dados['data']['users_permissions_user'] = [$idusuario];
            //
            var_dump($dados);
            //
            $url = API . '/clients';
            //
            ob_start();
            //
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dados));
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
            // var_dump($resposta);
            // var_dump($code);
            // var_dump($erro);
            // var_dump($info);
            //
            // return $resposta->data;
        }

        public function incluirNovoUsuario($data){
            //
            // $idClienteYugu = $this->yugu->incluirUsusaio($data);
            //
            $headers = array();
            $headers[] = "Content-Type: application/json";
            //
            $dados = array();
            $dados['username'] = $data['nome'];
            $dados['email'] = $data['email'];
            $dados['password'] = $data['senha'];
            //
            $url = API . '/auth/local/register';
            //
            ob_start();
            //
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dados));
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_exec($ch);
            //
            // JSON de retorno  
            $resposta = json_decode(ob_get_contents());
            // $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            // $erro = curl_errno($ch);
            // $info = curl_getinfo($ch);
            //
            ob_end_clean();
            curl_close($ch);
            //
            var_dump($resposta);
            //
            if(!empty($resposta->jwt)){
                self::incluiCliente($data, $idClienteYugu, $resposta->jwt, $resposta->user->id);
            }
            //
            return $resposta;
        }

        public function atualizarUsuario(){
            return;
        }
  
        public function buscarUsuario(){
            $headers = array();
            $headers[] = "Content-Type: application/json";
            $headers[] = "Authorization: Bearer " . $_SESSION['jwt'];
            //
            $parameters = array();
            $parameters['populate'] = '*';
            $parameters['filters']['users_permissions_user'] = $_SESSION['idusuario'];
            //
            $url = API . "/clients?" . http_build_query($parameters);
            //
            ob_start();
            //
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_exec($ch);
            //
            // JSON de retorno  
            $resposta = json_decode(ob_get_contents());
            // $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            // $erro = curl_errno($ch);
            // $info = curl_getinfo($ch);
            //
            ob_end_clean();
            curl_close($ch);
            //
            return $resposta->data[0];
        }
    }



?>
