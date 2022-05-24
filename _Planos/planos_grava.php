<?php
    require_once("../_BD/conecta_login.php");
    require_once("plano.class.php");
    //
    $plano = new plano();
    //
    if($_POST['operacao'] == 'contratarPlano'){
        //
        $dadosUser = $usuarios->buscarUsuario();
        //
        $plano = new plano();
        $assinatura = $plano->buscarUltimaAssinatura($dadosUser->id);
        if($assinatura->attributes->status == 'Pendente' || $assinatura->attributes->status == 'Em Análise' || $assinatura->attributes->status == 'Paga Parcial'){
            $retorno['erro'] = true;
            $retorno['erroTipo'] = 1;
            //
            echo json_encode($retorno);
            exit;
        }
        //
        $dadosPlano = $plano->buscarPlano($_POST['idplano']);
        //
        $dadosFatura = $plano->gerarAssinatura($dadosPlano->data->attributes, $dadosUser->id, $dadosUser->attributes, $dadosUser->attributes->users_permissions_user->data->attributes->email);
        //
        echo json_encode($dadosFatura);
        exit;
    }
?>