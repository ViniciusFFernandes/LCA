<?php
    require_once("../_BD/conecta_login.php");
    require_once("plano.class.php");
    //
    $plano = new plano();
    //
    if($_POST['operacao'] == 'contratarPlano'){
        $dadosPlano = $plano->buscarPlano($_POST['idplano']);
        $dadosUser = $usuarios->buscarUsuario();
        //
        //
        $dadosFatura = $plano->gerarAssinatura($dadosPlano->data->attributes, $dadosUser->id, $dadosUser->attributes, $dadosUser->attributes->users_permissions_user->data->attributes->email);
        //
        echo json_encode($dadosFatura);
    }
?>