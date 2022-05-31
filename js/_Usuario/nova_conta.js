$(document).ready(function(){
    $("#cpf").mask("999.999.999-AA", 
      {translation: {
        '9': {
          pattern: /[0-9]/,
          optional: false
        }
      }
    });
    $("#cep").mask("99999-999", 
    {translation: {
      '9': {
        pattern: /[0-9]/,
        optional: false
      }
    }
  });
})

function inserirUsuario(){
  desabilitaHabilitaBtn('Desabilitar');
  //
  if($("#nome").val() == ''){
    swal({
      title: "Campo Obrigatório",
      text: "O nome não pode ficar em branco",
      icon: "error",
      buttons: {
          defeat: "Ok",
      },
    }).then((value) => {
      $("#nome").focus();
    });
    desabilitaHabilitaBtn('Habilitar');
    return;
  }
  //
  var nomeSplit = $("#nome").val().split(" ");
  if(nomeSplit.length < 2){
    swal({
      title: "Campo Obrigatório",
      text: "Informe o nome completo",
      icon: "error",
      buttons: {
          defeat: "Ok",
      },
    }).then((value) => {
      $("#nome").focus();
    });
    desabilitaHabilitaBtn('Habilitar');
    return;
  }
  //
  if($("#email").val() == ''){
    swal({
      title: "Campo Obrigatório",
      text: "O email não pode ficar em branco",
      icon: "error",
      buttons: {
          defeat: "Ok",
      },
    }).then((value) => {
      $("#email").focus();
    });
    desabilitaHabilitaBtn('Habilitar');
    return;
  }
  //
  if($("#cpf").val() == ''){
    swal({
      title: "Campo Obrigatório",
      text: "O CPF não pode ficar em branco",
      icon: "error",
      buttons: {
          defeat: "Ok",
      },
    }).then((value) => {
      $("#cpf").focus();
    });
    desabilitaHabilitaBtn('Habilitar');
    return;
  }
  //
  // if($("#rua").val() == ''){
  //   swal({
  //     title: "Campo Obrigatório",
  //     text: "Informe o endereço completo",
  //     icon: "error",
  //     buttons: {
  //         defeat: {
  //           text: "Ok",
  //           className: 'btnVermelho'
  //         }
  //     },
  //   }).then((value) => {
  //     $("#rua").focus();
  //   });
  //   desabilitaHabilitaBtn('Habilitar');
  //   return;
  // }
  //
  // if($("#numero").val() == ''){
  //   swal({
  //     title: "Campo Obrigatório",
  //     text: "Informe o endereço completo",
  //     icon: "error",
  //     buttons: {
  //         defeat: {
  //           text: "Ok",
  //           className: 'btnVermelho'
  //         }
  //     },
  //   }).then((value) => {
  //     $("#numero").focus();
  //   });
  //   desabilitaHabilitaBtn('Habilitar');
  //   return;
  // }
  //
  if($("#cidade").val() == ''){
    swal({
      title: "Campo Obrigatório",
      text: "Informe o endereço completo",
      icon: "error",
      buttons: {
          defeat: {
            text: "Ok",
            className: 'btnVermelho'
          }
      },
    }).then((value) => {
      $("#cidade").focus();
    });
    desabilitaHabilitaBtn('Habilitar');
    return;
  }
  if($("#estado").val() == ''){
    swal({
      title: "Campo Obrigatório",
      text: "Informe o estado",
      icon: "error",
      buttons: {
          defeat: {
            text: "Ok",
            className: 'btnVermelho'
          }
      },
    }).then((value) => {
      $("#estado").focus();
    });
    desabilitaHabilitaBtn('Habilitar');
    return;
  }
  //
  // if($("#bairro").val() == ''){
  //   swal({
  //     title: "Campo Obrigatório",
  //     text: "Informe o endereço completo",
  //     icon: "error",
  //     buttons: {
  //         defeat: {
  //           text: "Ok",
  //           className: 'btnVermelho'
  //         }
  //     },
  //   }).then((value) => {
  //     $("#bairro").focus();
  //   });
  //   desabilitaHabilitaBtn('Habilitar');
  //   return;
  // }
  //
  // if($("#cep").val() == ''){
  //   swal({
  //     title: "Campo Obrigatório",
  //     text: "Informe o endereço completo",
  //     icon: "error",
  //     buttons: {
  //         defeat: {
  //           text: "Ok",
  //           className: 'btnVermelho'
  //         }
  //     },
  //   }).then((value) => {
  //     $("#cep").focus();
  //   });
  //   desabilitaHabilitaBtn('Habilitar');
  //   return;
  // }
  //
  if($("#senha").val() == ''){
    swal({
      title: "Campo Obrigatório",
      text: "A senha não pode ficar em branco",
      icon: "error",
      buttons: {
          defeat: {
            text: "Ok",
            className: 'btnVermelho'
          }
      },
    }).then((value) => {
      $("#senha").focus();
    });
    desabilitaHabilitaBtn('Habilitar');
    return;
  }
  //
  if($("#senha").val() != $("#senha2").val()){
    swal({
      title: "Não Confere",
      text: "As duas senhas informadas não conferem",
      icon: "error",
      buttons: {
          defeat: {
            text: "Ok",
            className: 'btnVermelho'
          }
      },
    }).then((value) => {
      $("#senha2").focus();
    });
    desabilitaHabilitaBtn('Habilitar');
    return;
  }
  //
  // $("#formNovoUsuario").submit();
  $.post("_BD/conecta_login.php", 
        {operacao: 'novaConta',
          redirect: $("#redirect").val(),
          nome: $("#nome").val(),
          email: $("#email").val(),
          cpf: $("#cpf").val(),
          rua: $("#rua").val(),
          numero: $("#numero").val(),
          cidade: $("#cidade").val(),
          bairro: $("#bairro").val(),
          estado: $("#estado").val(),
          cep: $("#cep").val(),
          senha: $("#senha").val(),
          senha2: $("#senha2").val()},
        function(data){
          desabilitaHabilitaBtn('Habilitar');
          if(data.erro == 1){
            swal({
              title: "Atenção",
              text: "Ocorreu um erro ao criar sua conta!\n\nTente novamente mais tarde ou entre em contato com um administrador.",
              icon: "error",
              buttons: {
                  defeat: {
                    text: "Ok",
                    className: 'btnVermelho'
                  }
              },
            });
          }else{
            if(data.tipo == 1){
              direciona(data.url);
            }else{
              swal({
                title: "Conta Criada",
                text: "Você será direcionado para fazer o login",
                icon: "success",
                buttons: {
                    defeat: {
                      text: "Ok",
                      className: 'btnVermelho'
                    }
                },
              }).then((value) => {
                $("#btnLogar").click();
              });
            }
            
          }
        }, "json");
}

function desabilitaHabilitaBtn(desabilitaHabilita){
  if(desabilitaHabilita == 'Desabilitar'){
    $("#btnCriaConta").html("<img src='img/carregando.gif' width='30px'>CRIANDO CONTA");
    $("#btnCriaConta").attr("disabled", true);
  }else{
    $("#btnCriaConta").html("CRIAR CONTA");
    $("#btnCriaConta").attr("disabled", false);
  }
}