function deslogarConta(){
    postFormulario('../_BD/conecta_login.php', {operacao: 'Sair'});
}


function toFloat(string){
    var valor = '';
    //
    string = string.replace(".", "");
    string = string.replace(".", "");
    string = string.replace(".", "");
    string = string.replace(",", ".");
    //
    if(string != 0 && $.isNumeric(string)){
        valor = parseFloat(string);
        return valor;
    }else{
        return 0;
    }
}

function direciona(link){
    $(location).attr('href', link);
}

function postFormulario(path, params, method, target) {
    //
    // Função que simula o post de um formulário sem a necessidade de criar um formulário
    //
    method = method || "post"; // Set method to post by default if not specified.
    target = target || "_self"; // Set target to _self by default if not specified.
  
    // The rest of this code assumes you are not using a library.
    // It can be made less wordy if you use one.
    var form = document.createElement("form");
    form.setAttribute("method", method);
    form.setAttribute("action", path);
    form.setAttribute("target", target);
  
    for(var key in params) {
        if(params.hasOwnProperty(key)) {
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", key);
            hiddenField.setAttribute("value", params[key]);
  
            form.appendChild(hiddenField);
         }
    }
  
    document.body.appendChild(form);
    form.submit();
  }