<?php
    require_once("util.class.php");
    require_once("iugu.class.php");
    require_once("autoload.php");

	class plano {
        private $util;
        private $iugu;
        private $conversorMark;

		function __construct(){
            $this->util = new Util();
            $this->iugu = new iugu();
            $this->conversorMark = new Parsedown();
		}

		public function buscarPlanos(){
			//
			$headers = array();
            $headers[] = "Content-Type: application/json";
            $headers[] = "Authorization: Bearer " . $_SESSION['jwt'];
            //
            $parameters = array();
            $parameters['populate'] = '*';
			//
            $url = API . "/plans?" . http_build_query($parameters);
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
            // $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            // $erro = curl_errno($ch);
            // $info = curl_getinfo($ch);
			//
            ob_end_clean();
            curl_close($ch);
			//
			return $resposta;
		}

        public function buscarPlano($id){
			//
			$headers = array();
            $headers[] = "Content-Type: application/json";
            $headers[] = "Authorization: Bearer " . $_SESSION['jwt'];
            //
            $parameters = array();
            $parameters['populate'] = '*';
			//
            $url = API . "/plans/{$id}?" . http_build_query($parameters);
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
            // $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            // $erro = curl_errno($ch);
            // $info = curl_getinfo($ch);
			//
            ob_end_clean();
            curl_close($ch);
			//
			return $resposta;
		}
        
        public function geraPlano($dados){
            $html = file_get_contents("_Planos/_HTML/componentes/planoMini.html");
            //
            $html = str_replace("##tituloPlano##", $dados->attributes->title, $html);
            $html = str_replace("##valorPlano##", $this->util->formataMoeda($dados->attributes->value_in_cents / 100), $html);
			$html = str_replace("##duracaoPlano##", $dados->attributes->duration_in_months, $html);
			$html = str_replace("##descricaoPlano##", $this->conversorMark->text($dados->attributes->description), $html);
            if($_SESSION['logado']){
                $html = str_replace("##functionBtnAssinar##", "contratarPlano(##id##)", $html);
            }else{
                $html = str_replace("##functionBtnAssinar##", "logarCriaConta('" . base64_encode("planos/") . "')", $html);
            }
			$html = str_replace("##id##", $dados->id, $html);
            //
            return $html;
        }

        public function gerarAssinatura($dadosPlano, $idcliente, $dadosCliente, $email){
			//
			//
            $headers = array();
            $headers[] = "Content-Type: application/json";
            $headers[] = "Authorization: Bearer " . $jwt;
            //
            $valorParcela = $dadosPlano->value_in_cents / $dadosPlano->parcelas;
            $x = 0;
            $idParcelaPrincipal = '';
            $primeiro = true;
            $retornoFaturaPrincipal = '';
            $vencimento = date("Y-m-d", strtotime("+3 day"));
            while ($x < $dadosPlano->parcelas){
                $dados = array();
                $dados['data']['expires_in_month'] = intval($dadosPlano->duration_in_months);
                $dados['data']['value_in_cents'] = intval($valorParcela);
                $dados['data']['date_buy'] = date("Y-m-d") . "T" . date("H:i:s") . "Z";
                $dados['data']['date_status'] = date("Y-m-d") . "T" . date("H:i:s") . "Z";
                $dados['data']['date_expire'] = date("Y") . '-12-31';
                $dados['data']['status'] = "Pendente";
                $dados['data']['client'] = $idcliente;
                $dados['data']['id_invoice_iugu'] = "0";
                $dados['data']['date_vencto'] = $vencimento;
                //
                if($idParcelaPrincipal > 0) $dados['data']['idsubscription'] = $idParcelaPrincipal;
                //
                $url = API . '/subscriptions';
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
                $retorno = $this->iugu->gerarFatura($resposta->data->id, $dadosPlano, $dadosCliente, $email, $vencimento);
                //
                self::atualizaAssinatura($resposta->data->id, $retorno->id, 'Pendente');
                //
                if($primeiro){
                    $idParcelaPrincipal = $resposta->data->id;
                    $retornoFaturaPrincipal = $retorno;
                }
                $primeiro = false;
                $x++;
                $vencimento = date('Y-m-d', strtotime("+60 days",strtotime($vencimento)));
            }
            //
            return $retornoFaturaPrincipal;
        }

        public function atualizaAssinatura($idassinatura, $idiugu, $status){
			//
			//
            $headers = array();
            $headers[] = "Content-Type: application/json";
            $headers[] = "Authorization: Bearer " . $jwt;
            //
            $dados = array();
            $dados['data']['status'] = $status;
            $dados['data']['id_invoice_iugu'] = $idiugu;
            $dados['data']['date_status'] = date("Y-m-d") . "T" . date("H:i:s") . "Z";
            //
            $url = API . "/subscriptions/{$idassinatura}";
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
            // return $resposta;
        }

        public function buscarAssinaturas($idcliente){
            $headers = array();
            $headers[] = "Content-Type: application/json";
            $headers[] = "Authorization: Bearer " . $_SESSION['jwt'];
            //
            $parameters = array();
            $parameters['populate'] = '*';
            $parameters['sort'] = 'date_buy:desc';
            $parameters['filters']['client'] = $idcliente;
            //
            $url = API . "/subscriptions?" . http_build_query($parameters);
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
            return $resposta;
        }

        public function buscarUltimaAssinaturaPaga($idcliente){
            $headers = array();
            $headers[] = "Content-Type: application/json";
            $headers[] = "Authorization: Bearer " . $_SESSION['jwt'];
            //
            $parameters = array();
            $parameters['populate'] = '*';
            $parameters['sort'] = 'date_buy:desc';
            $parameters['filters']['client'] = $idcliente;
            $parameters['filters']['status'] = 'Paga';
            //
            $url = API . "/subscriptions?" . http_build_query($parameters);
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

        public function buscarAssinaturasLigadas($idassinatura){
            $headers = array();
            $headers[] = "Content-Type: application/json";
            $headers[] = "Authorization: Bearer " . $_SESSION['jwt'];
            //
            $parameters = array();
            $parameters['populate'] = '*';
            $parameters['filters']['idsubscription'] = $idassinatura;
            //
            $url = API . "/subscriptions?" . http_build_query($parameters);
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
            return $resposta->data;
        }

        public function buscarUltimaAssinatura($idcliente){
            $headers = array();
            $headers[] = "Content-Type: application/json";
            $headers[] = "Authorization: Bearer " . $_SESSION['jwt'];
            //
            $parameters = array();
            $parameters['populate'] = '*';
            $parameters['sort'] = 'date_buy:desc';
            $parameters['filters']['client'] = $idcliente;
            //
            $url = API . "/subscriptions?" . http_build_query($parameters);
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

        public function buscarAssinatura($idiugu = '', $idassinatura = ''){
            $headers = array();
            $headers[] = "Content-Type: application/json";
            $headers[] = "Authorization: Bearer " . $_SESSION['jwt'];
            //
            $parameters = array();
            $parameters['populate'] = '*';
            if($idiugu != '') $parameters['filters']['id_invoice_iugu'] = $idiugu;
            if($idassinatura != '') $parameters['filters']['id'] = $idassinatura;
            //
            $url = API . "/subscriptions?" . http_build_query($parameters);
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

        public function geraListaAssinatura($dados){
            $html = file_get_contents("_Planos/_HTML/componentes/assinaturaLista.html");
            //
            $html = str_replace("##valorAssinatura##", $this->util->formataMoeda($dados->attributes->value_in_cents / 100), $html);
			$html = str_replace("##duracaoAssinatura##", $dados->attributes->expires_in_month, $html);
			$html = str_replace("##duracaoVencimento##", $this->util->convertData($dados->attributes->date_expire), $html);
			$html = str_replace("##statusAssinatura##", $dados->attributes->status, $html);
            //
            $btnPagar = '';
            if($dados->attributes->id_invoice_iugu != '' && $dados->attributes->status == 'Pendente'){
                $btnPagar = file_get_contents("_Planos/_HTML/componentes/btnPagarAssinatura.html");
                if($dados->attributes->idsubscription->data == ''){
                    $btnCancelar = file_get_contents("_Planos/_HTML/componentes/btnCancelarAssinatura.html");
                }
            }
            
			$html = str_replace("##btnPagar##",  $btnPagar, $html);
			$html = str_replace("##btnCancelar##",  $btnCancelar, $html);
			$html = str_replace("##idiugu##",  $dados->attributes->id_invoice_iugu, $html);
			$html = str_replace("##idassinatura##",  $dados->id, $html);
            //
            $html = str_replace("##id##", $dados->id, $html);
            //
            return $html;
        }

	}


?>
