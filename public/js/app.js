$(document).ready(function(){
    $("#cpf").inputmask("999.999.999-99");
    $.validate({
        modules : 'brazil'
    });
});