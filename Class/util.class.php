<?php

class Util{

	public function nulo($string){
		if ($string == "") {
          	return NULL;
        }else{
			return $string;
        }
	}

	public function sgr($string, $retornaNull = false){
		if ($string != "") {
			$string = str_replace("'", "''", $string);
          	return "'" . $string . "'";
        }else{
			if($retornaNull){
				return "NULL";
			}
          	return "''";
        }
	}
	
	public function pgr($string){
		if ($string != "") {
          	return "(" . $string . ")";
        }else{
          	return "NULL";
        }
	}

	public function igr($num){
		if ($num != "") {
         	return intval($num);
        }else{
          	return "0";
        }
	}

	public function vgr($num){
		if ($num != "") {
			if (strpos($num, ",")) {
				if (strpos($num, ".")) {
					$num = str_ireplace(".", "", $num);
				}
			}
			$num = str_replace(",", ".", $num);
			return $num;
        }else{
          	return "0";
        }
	}

	public function dgr($string, $incluiHora = ""){
		if ($string != "") {
					$string = explode(" ", $string);
					$data = explode("/", $string[0]);
					$dataFormatada = $data[2] . "-" . $data[1] . "-" . $data[0];
					if (!empty($incluiHora)) {
							$dataFormatada .= " " . $incluiHora;
					}elseif (!empty($string[1])) {
							$dataFormatada .= " " . $string[1];				
					}else{
						$dataFormatada .= " 00:00:00";		
					}

				return "'" . $dataFormatada . "'";
		}else{
			return "0";
		}
	}

	public function convertData($string){
		if ($string != "") {
					$string = explode(" ", $string);
					$data = explode("-", $string[0]);
					$dataFormatada = $data[2] . "/" . $data[1] . "/" . $data[0];
					if (!empty($string[1])) {
						$dataFormatada .= " " . $string[1];
					}
				}else {
					return "";
				}
				return $dataFormatada;
	}

	public function convertDataAPI($string, $retornaHora = true){
		if ($string != "") {
					$string = explode("T", $string);
					$data = explode("-", $string[0]);
					$dataFormatada = $data[2] . "/" . $data[1] . "/" . $data[0];
					if (!empty($string[1]) && $retornaHora) {
						$dataFormatada .= " " . substr($string[1], 0, 5);
					}
				}else {
					return "";
				}
				return $dataFormatada;
	}

	public function formataMoeda($valor = 0, $casas = 2, $retornaBranco = false) {
		if($valor <= 0) return "";
		//
		return number_format($valor, $casas, ',', '.');
	}
	
	public function formataNumero($valor = 0, $casas = 2) {
		return (number_format($valor, $casas, ',', ''));
	}

	public function mesExtenso($mes){
		switch ($mes) {
			case '1':
				return 'Janeiro';
				break;
			case '2':
				return 'Fevereiro';
				break;
			case '3':
				return 'Mar??o';
				break;
			case '4':
				return 'Abril';
				break;
			case '5':
				return 'Maio';
				break;
			case '6':
				return 'Junho';
				break;
			case '7':
				return 'Julho';
				break;
			case '8':
				return 'Agosto';
				break;
			case '9':
				return 'Setembro';
				break;
			case '10':
				return 'Outubro';
				break;
			case '11':
				return 'Novembro';
				break;
			case '12':
				return 'Dezembro';
				break;
			default:
				return '';
				break;
		}
	}

	public function retornaDiasUteisMes($mes, $ano, $feriados = ''){
		$inicioMes = $ano . '-' . str_pad($mes, 2, "0", STR_PAD_LEFT) . '-01';
		$fimMes = date("Y-m-t", strtotime($inicioMes));
		//
		$tsInicio = strtotime($inicioMes);
    	$tsFim = strtotime($fimMes);
		//
		$quantidadeDias = 0;
		while ($tsInicio <= $tsFim) {
			// Verifica se o dia ?? igual a s??bado ou domingo, caso seja continua o loop
			$diaIgualFinalSemana = (date('D', $tsInicio) === 'Sat' || date('D', $tsInicio) === 'Sun');
			// Verifica se ?? feriado, caso seja continua o loop
			if(!empty($feriados)){
			    $diaIgualFeriado = (count($feriados) && in_array(date('Y-m-d', $tsInicio), $feriados));
			}
	
			$tsInicio += 86400; // 86400 quantidade de segundos em um dia
	
			if ($diaIgualFinalSemana || $diaIgualFeriado) {
				continue;
			}
	
			$quantidadeDias++;
		}
		//
		return $quantidadeDias;
	}

	public function valorPorExtenso($valor = 0, $bolExibirMoeda = true, $bolPalavraFeminina = false) {
		$singular = null;
        $plural = null;
 
        if ( $bolExibirMoeda )
        {
            $singular = array("centavo", "real", "mil", "milh??o", "bilh??o", "trilh??o", "quatrilh??o");
            $plural = array("centavos", "reais", "mil", "milh??es", "bilh??es", "trilh??es","quatrilh??es");
        }
        else
        {
            $singular = array("", "", "mil", "milh??o", "bilh??o", "trilh??o", "quatrilh??o");
            $plural = array("", "", "mil", "milh??es", "bilh??es", "trilh??es","quatrilh??es");
        }
 
        $c = array("", "cem", "duzentos", "trezentos", "quatrocentos","quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
        $d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta","sessenta", "setenta", "oitenta", "noventa");
        $d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze","dezesseis", "dezessete", "dezoito", "dezenove");
        $u = array("", "um", "dois", "tr??s", "quatro", "cinco", "seis","sete", "oito", "nove");
 
 
        if ( $bolPalavraFeminina )
        {
        
            if ($valor == 1) 
            {
                $u = array("", "uma", "duas", "tr??s", "quatro", "cinco", "seis","sete", "oito", "nove");
            }
            else 
            {
                $u = array("", "um", "duas", "tr??s", "quatro", "cinco", "seis","sete", "oito", "nove");
            }
            
            
            $c = array("", "cem", "duzentas", "trezentas", "quatrocentas","quinhentas", "seiscentas", "setecentas", "oitocentas", "novecentas");
            
            
        }
 
 
        $z = 0;
 
        $valor = number_format( $valor, 2, ".", "." );
        $inteiro = explode( ".", $valor );
 
        for ( $i = 0; $i < count( $inteiro ); $i++ ) 
        {
            for ( $ii = mb_strlen( $inteiro[$i] ); $ii < 3; $ii++ ) 
            {
                $inteiro[$i] = "0" . $inteiro[$i];
            }
        }
 
        // $fim identifica onde que deve se dar jun????o de centenas por "e" ou por "," ;)
        $rt = null;
        $fim = count( $inteiro ) - ($inteiro[count( $inteiro ) - 1] > 0 ? 1 : 2);
        for ( $i = 0; $i < count( $inteiro ); $i++ )
        {
            $valor = $inteiro[$i];
            $rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
            $rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
            $ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";
 
            $r = $rc . (($rc && ($rd || $ru)) ? " e " : "") . $rd . (($rd && $ru) ? " e " : "") . $ru;
            $t = count( $inteiro ) - 1 - $i;
            $r .= $r ? " " . ($valor > 1 ? $plural[$t] : $singular[$t]) : "";
            if ( $valor == "000")
                $z++;
            elseif ( $z > 0 )
                $z--;
                
            if ( ($t == 1) && ($z > 0) && ($inteiro[0] > 0) )
                $r .= ( ($z > 1) ? " de " : "") . $plural[$t];
                
            if ( $r )
                $rt = $rt . ((($i > 0) && ($i <= $fim) && ($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r;
        }
 
        $rt = mb_substr( $rt, 1 );
 
        return($rt ? trim( $rt ) : "zero");
 
	}

	public function uploadFile($arquivo, $pasta, $tipos, $nome = null){
		if(isset($arquivo)){
			$infos = explode(".", $arquivo["name"]);
	 
			if(!$nome){
				for($i = 0; $i < count($infos) - 1; $i++){
					$novoNome = $arquivo["name"] . $infos[$i];
				}
			}
			else{
				$novoNome = $nome;
			}
	 
			$tipoArquivo = $infos[count($infos) - 1];
	 
			$tipoPermitido = false;
			foreach($tipos as $tipo){
				if(strtolower($tipoArquivo) == strtolower($tipo)){
					$tipoPermitido = true;
				}
			}
			if(!$tipoPermitido){
				$retorno["erro"] = "Tipo n??o permitido";
			}
			else{
				if(!is_dir($pasta)){
					mkdir($pasta, 0777, true);
				}
				if(move_uploaded_file($arquivo['tmp_name'], $pasta . $novoNome . "." . $tipoArquivo)){
					$retorno["caminho"] = $pasta . $novoNome . "." . $tipoArquivo;
					$retorno["nomeArquivo"] = $novoNome . "." . $tipoArquivo;
				}
				else{
					$retorno["erro"] = "Erro ao fazer upload";
				}
			}
		}
		else{
			$retorno["erro"] = "Arquivo nao setado";
		}
		return $retorno;
	}
}
?>
