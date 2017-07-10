function cleanFormData() {
    var form_action = $('form').attr('action');
    var end = form_action.indexOf('.php') + 4;
    form_action = form_action.substr(0, end);

    $('#name').val('');
    $('#cnpj').val('');
    $("#person_type_F").prop("checked", true);
    applyPFChanges();

    $('form').attr('action', form_action);
    $('form').attr('method', 'POST');
    $('#form_legend').text('Novo');

    $('#success-message').fadeOut();
}

function applyPFChanges() {
    $('#cnpj').mask('000.000.000-00', {reverse: true});
    $('#label_cpf').text('CPF');
}

function applyPJChanges() {
    $('#cnpj').mask('00.000.000/0000-00', {reverse: true});
    $('#label_cpf').text('CNPJ');
}

function editButtonBehaviour() {
    $('.edit-costumer').on('click', function () {
        var id = $(this).data('id');
        var form_action = $('form').attr('action') + '/' + id;

        $.ajax({
            url: form_action,
            type: 'GET',
            success: function (result) {
                var costumer = JSON.parse(result);

                $('form').attr('action', form_action);
                $('form').attr('method', 'PUT');
                $('#form_legend').text('Alterar Dados');

                $('#name').val(costumer.name);
                $('#cnpj').val(costumer.cnpj);

                $("#person_type_" + costumer.person_type).prop("checked", true);
            }
        });

        return false;
    });
}

function deleteButtonBehaviour() {
    $('.delete-costumer').on('click', function () {
        var id = $(this).data('id');
        var form_action = $('form').attr('action') + '/' + id;

        $.ajax({
            url: form_action,
            type: 'DELETE',
            success: function () {
                loadCostumers();
            }
        });

        return false;
    });
}

function loadCostumers() {
    var form_action = $('form').attr('action');

    $.ajax({
        url: form_action,
        type: 'GET',
        success: function (result) {
            var costumers = '';
            var list = JSON.parse(result);

            $.each(list, function (index, costumer) {
                costumers +=
                    '<tr>' +
                    '<th scope="row">' + (index + 1) + '</th>' +
                    '<td>' + costumer.name + '</td>' +
                    '<td>' + costumer.person_type + '</td>' +
                    '<td>' + costumer.cnpj + '</td>' +
                    '<td>' +
                    '<a href="#" class="edit-costumer" data-id="' + costumer.id + '"><i class="fa fa-pencil-square-o"></i></a>' +
                    '&nbsp;<a href="#" class="delete-costumer" data-id="' + costumer.id + '"><i class="fa fa-trash-o"></i></a>' +
                    '</td>' +
                    '</tr>'
            });

            $('#costumers-list tbody').html(costumers);
            editButtonBehaviour();
            deleteButtonBehaviour();
        }
    });
}

function radioBehaviour () {
    $('input[type=radio][name=person_type]').change(function() {
        if (this.value == 'F') {
            applyPFChanges();
        }
        else if (this.value == 'J') {
            applyPJChanges();
        }
    });
}

function saveButtonBehaviour(){
    $('#btn_save').on('click', function() {
        $('#success-message').fadeOut();
        var form_data = JSON.stringify(getFormData($('form')));
        var form_action = $('form').attr('action');
        var form_method = $('form').attr('method');

        $.ajax({
            url: form_action,
            data: form_data,
            type: form_method,
            success: function () {
                cleanFormData();
                $('#success-message').fadeIn();

                loadCostumers();
            }
        });

        return false;
    });
}

function clearButtonBehaviour() {
    $('#btn_clear').on('click', function() {
        cleanFormData();
        return false;
    });

    $('input').on('focus', function () {
        $('#success-message').fadeOut();
    });
}

$(document).ready(function () {
    applyPFChanges();
    radioBehaviour();
    saveButtonBehaviour();
    clearButtonBehaviour();
    loadCostumers();
});