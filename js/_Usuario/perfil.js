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

function editarPerfil(){
  $("#nome").attr("readonly", false);
  $("#apelido").attr("readonly", false);
  // $("#email").attr("readonly", false); //não permite alteração
  $("#cpf").attr("readonly", false);
  $("#rg").attr("readonly", false);
  $("#rua").attr("readonly", false);
  $("#numero").attr("readonly", false);
  $("#cidade").attr("readonly", false);
  $("#estado").attr("readonly", false);
  $("#bairro").attr("readonly", false);
  $("#cep").attr("readonly", false);
  //
  $("#nome").focus();
  //
  $("#btnEditarPerfil").hide();
  $("#btnSalvarPerfil").show();
}

function salvarPerfil(){
  $("#nome").attr("readonly", true);
  $("#apelido").attr("readonly", true);
  // $("#email").attr("readonly", true); //não permite alteração
  $("#cpf").attr("readonly", true);
  $("#rg").attr("readonly", true);
  $("#rua").attr("readonly", true);
  $("#numero").attr("readonly", true);
  $("#cidade").attr("readonly", true);
  $("#estado").attr("readonly", true);
  $("#bairro").attr("readonly", true);
  $("#cep").attr("readonly", true);
  //
  $.post("../_Usuario/perfil_grava.php", {
    operacao: 'alterarUsuario',
    idcliente: $("#idcliente").val(),
    idcliente_iugu: $("#idcliente_iugu").val(),
    nome: $("#nome").val(),
    apelido: $("#apelido").val(),
    cpf: $("#cpf").val(),
    rg: $("#rg").val(),
    rua: $("#rua").val(),
    numero: $("#numero").val(),
    cidade: $("#cidade").val(),
    estado: $("#estado").val(),
    bairro: $("#bairro").val(),
    cep: $("#cep").val()
  }, function(data){
    // console.log(data);
  }, "json");
  //
  $("#btnEditarPerfil").show();
  $("#btnSalvarPerfil").hide();
  //
}

function pagarAssinatura(idfatura){
  $("#btnAssinatura_" + idfatura).html("<img src='../img/carregando.gif' width='30px'>");
  $(".btnPagarAssinatura").attr("disabled", true);
  //
  $.post("../_Usuario/perfil_grava.php",
  {operacao: "pagarAssinatura",
  idfatura: idfatura},
  function(data){
      $("#btnAssinatura_" + idfatura).html("PAGAR");
      $(".btnPagarAssinatura").attr("disabled", false);
      //
      window.open(data.secure_url, "pagamentoDeAssinatura", "height=800,width=1000");
      //
  }, "json");
}