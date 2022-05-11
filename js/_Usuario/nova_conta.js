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