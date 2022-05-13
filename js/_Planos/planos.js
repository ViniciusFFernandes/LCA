function contratarPlano(idplano){
    //
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

function logarCriaConta(urlCripto){
    swal({
        title: "Você não está logado",
        text: "Crie uma conta ou entre com sua conta",
        icon: "error",
        buttons: {
            cancel: "Nova Conta",
            defeat: "Logar",
        },
      }).then((value) => {
        if(value){
            window.location.assign("../?redirect=" + urlCripto);
        }else{
            window.location.assign("../cadastrar?redirect=" + urlCripto);
        }
      });
    
}