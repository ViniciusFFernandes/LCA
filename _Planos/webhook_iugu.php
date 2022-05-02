<?php
    require_once("../_BD/conecta.php");
    require_once("usuarios.class.php");
    require_once("plano.class.php");
    //
    $status = array();
    $status['pending'] = 'Pendente';
    $status['paid'] = 'Paga';
    $status['canceled'] = 'Cancelada';
    $status['in_analysis'] = 'Em Análise';
    $status['draft'] = 'Rascunho';
    $status['partially_paid'] = 'Paga Parcial';
    $status['refunded'] = 'Reembolsada';
    $status['expired'] = 'Expirada';
    $status['in_protest'] = 'Em Protesto';
    $status['chargeback'] = 'Contestada';
    //
    // 
    if($_REQUEST['event'] == 'invoice.status_changed'){
        if($_REQUEST['data']['id'] != ''){
            $plano = new plano();
            $dadosAssinatura = $plano->buscarAssinatura($_REQUEST['data']['id']);
            $plano->atualizaAssinatura($dadosAssinatura->id, $_REQUEST['data']['id'], $status[$_REQUEST['data']['status']]);
        }
    }
?>