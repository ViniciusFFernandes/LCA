function contratarPlano(idplano){
    $("#btnAssinatura_" + idplano).html("<img src='../img/carregando.gif' width='30px'>ASSINANDO");
    $(".btnAssinaturas").attr("disabled", true);
    //
    $.post("../_Planos/planos_grava.php",
    {operacao: "contratarPlano",
    idplano: idplano},
    function(data){
        $("#btnAssinatura_" + idplano).html("ASSINAR");
        $(".btnAssinaturas").attr("disabled", false);
        //
        window.open(data.secure_url, "pagamentoDeAssinatura", "height=800,width=1000");
        //
    }, "json");
}