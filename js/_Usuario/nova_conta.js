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
  if($("#nome").val() == ''){
      alert('Nome não informado!');
      $("#nome").focus();
      return;
  }
  //
  if($("#email").val() == ''){
      alert('E-mail não informado!');
      $("#email").focus();
      return;
  }
  //
  if($("#cpf").val() == ''){
    alert('Cpf não informado!');
    $("#cpf").focus();
    return;
  }
  //
  if($("#rua").val() == ''){
    alert('Endereço não informado!');
    $("#rua").focus();
    return;
  }
  //
  if($("#numero").val() == ''){
    alert('Endereço não informado!');
    $("#numero").focus();
    return;
  }
  //
  if($("#cidade").val() == ''){
    alert('Endereço não informado!');
    $("#cidade").focus();
    return;
  }
  //
  if($("#bairro").val() == ''){
    alert('Endereço não informado!');
    $("#bairro").focus();
    return;
  }
  //
  if($("#cep").val() == ''){
    alert('Endereço não informado!');
    $("#cep").focus();
    return;
  }
  //
  if($("#senha").val() == ''){
      alert('Senha não informada!');
      $("#senha").focus();
      return;
  }
  //
  if($("#senha").val() != $("#senha2").val()){
      alert('As senhas não conferem!');
      $("#senha2").focus();
      return;
  }
  //
  $("#formNovoUsuario").submit();
}