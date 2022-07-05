<?php
    require_once("iugu.class.php");
    require_once("util.class.php");

	class usuarios {
        private $iugu;
        private $util;

		function __construct(){
            $this->iugu = new iugu();
            $this->util = new Util();
		}

		public function buscarUsuarioLogin($usuario, $senha){
			//
			$headers = array();
            $headers[] = "Content-Type: application/json";
			//
			$dados = array();
			$dados['identifier'] = str_replace("-", "", str_replace(".", "", $usuario));
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
        
        public function incluiCliente($data, $idClienteiugu = 0, $jwt, $idusuario){
            //
            $headers = array();
            $headers[] = "Content-Type: application/json";
            $headers[] = "Authorization: Bearer " . $jwt;
            //
            $dados = array();
            $dados['data']['name'] = $data['nome'];
            $dados['data']['CPF'] = $data['cpf'];
            $dados['data']['surname'] = $data['apelido'];
            $dados['data']['city'] = $data['cidade'];
            $dados['data']['state'] = $data['estado'];
            $dados['data']['id_iugu'] = $idClienteiugu;
            $dados['data']['users_permissions_user'] = [$idusuario];
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
            $idClienteiugu = $this->iugu->incluirCliente($data);
            //
            $headers = array();
            $headers[] = "Content-Type: application/json";
            //
            $dados = array();
            $dados['username'] = str_replace("-", "", str_replace(".", "", $data['cpf']));
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
            //
            if(!empty($resposta->jwt)){
                self::incluiCliente($data, $idClienteiugu, $resposta->jwt, $resposta->user->id);
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

        public function alteraCliente($data){
            //
            $idClienteiugu = $this->iugu->atualizarCliente($data);
            //
            $headers = array();
            $headers[] = "Content-Type: application/json";
            $headers[] = "Authorization: Bearer " . $_SESSION['jwt'];
            //
            $dados = array();
            $dados['data']['name'] = $this->util->nulo($data['nome']);
            $dados['data']['surname'] = $this->util->nulo($data['apelido']);
            // $dados['data']['CEP'] = $this->util->nulo($data['cep']);
            // $dados['data']['city'] = $this->util->nulo($data['cidade']);
            // $dados['data']['state'] = $this->util->nulo($data['estado']);
            //
            //
            $url = API . "/clients/{$data['idcliente']}";
            //
            ob_start();
            //
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
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
            return $resposta;
        }
    }



?>
