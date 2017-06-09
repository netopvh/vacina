$(document).ready(function(){
    $("#cpf").inputmask("999.999.999-99");
    $.validate({
        modules : 'brazil'
    });

    var dependente = $('#dependente');
    var desconto = $('#desconto');

    //Define valores iniciais
    if (dependente.val() === 'S'){
        desconto.show();
    }else{
        desconto.hide();
    }
    $(dependente).on('change', function (e) {
        if (dependente.val() === 'S'){
            desconto.show();
        }else{
            desconto.hide();
            $('#sim').prop('checked', false);
            $('#nao').prop('checked', false);
        }
    });
    $('#aderir').submit(function(e) {
        var currentForm = this;
        e.preventDefault();
        bootbox.confirm({
            message: "Colaborador, deseja realmente aderir á campanha de vacinação?",
            buttons: {
                confirm: {
                    label: 'Confirmar',
                    className: 'btn-success'
                },
                cancel: {
                    label: 'Cancelar',
                    className: 'btn-danger'
                }
            },
            callback: function (result) {
                if (result) {
                    currentForm.submit();
                }
            }
        });
    });
});