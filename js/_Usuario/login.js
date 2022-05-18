$(document).ready(function(){
    $("#usuario").mask("999.999.999-AA", 
      {translation: {
        '9': {
          pattern: /[0-9]/,
          optional: false
        }
      }
    });
})

function logar(){
  desabilitaHabilitaBtn('Desabilitar');
  //
  $.post("_BD/conecta_login.php", 
        {operacao: 'logar',
          redirect: $("#redirect").val(),
          usuario: $("#usuario").val(),
          senha: $("#senha").val()},
        function(data){
          desabilitaHabilitaBtn('Habilitar');
          if(data.erro == 1){
            $("#usuario").val('');
            $("#senha").val('');
            swal({
              title: "Atenção",
              text: "CPF ou Senha não confere",
              icon: "error",
              buttons: {
                  defeat: "Ok",
              },
            }).then((value) => {
              $("#usuario").focus();
            });
          }else{
            direciona(data.url);
          }
        }, "json");
}

function desabilitaHabilitaBtn(desabilitaHabilita){
  if(desabilitaHabilita == 'Desabilitar'){
    $("#btnLogar").html("<img src='img/carregando.gif' width='30px'>ENTRANDO");
    $("#btnLogar").attr("disabled", true);
  }else{
    $("#btnLogar").html("ENTRAR");
    $("#btnLogar").attr("disabled", false);
  }
}