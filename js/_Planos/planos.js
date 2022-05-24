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
        if(data.erro){
            if(data.erroTipo == 1){
                swal({
                    title: "Erro ao gerar fatura",
                    text: "Você já possui uma fatura pedente, caso tenha pago aguarde para que seja compensado",
                    icon: "error",
                    buttons: {
                        cancel: "Fechar",
                        defeat: {
                            text: "Acessar Perfil",
                            className: 'btnVermelho'
                        }
                    },
                }).then((value) => {
                    if(value){
                        window.location.assign("../perfil/");
                    }
                });
            }
        }else{
            swal({
                title: "Fatura gerada",
                text: "Clique eu pagar agora ou acesse seu perfil na aba assinaturas para efetuar o pagamento",
                icon: "success",
                buttons: {
                    cancel: "Pagar Depois",
                    defeat: {
                        text: "Pagar Agora",
                        className: 'btnVermelho'
                    }
                },
              }).then((value) => {
                if(value){
                    window.open(data.secure_url, "pagamentoDeAssinatura", "height=800,width=1000");
                }
              });
        }
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
            defeat: {
                text: "Logar",
                className: 'btnVermelho'
            }
        },
      }).then((value) => {
        if(value){
            window.location.assign("../?redirect=" + urlCripto);
        }else{
            window.location.assign("../cadastrar?redirect=" + urlCripto);
        }
      });
    
}