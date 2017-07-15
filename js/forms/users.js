function loadRoles(selected) {
    var form_action = $('form').attr('action').replace('users', 'roles');

    $.ajax({
        url: form_action,
        type: 'GET',
        success: function (result) {
            var roles = '';
            var list = JSON.parse(result);

            $.each(list, function (index, costumer) {
                roles +=
                    '<option value="' +
                    costumer.id +
                    '">' +
                    costumer.name + '</option>';
            });

            $('#id_role').append(roles);
            $('#id_role').val(selected);
        }
    });
}

function loadUsers() {
    var form_action = $('form').attr('action');

    $.ajax({
        url: form_action,
        type: 'GET',
        success: function (result) {
            var users = '';
            var list = JSON.parse(result);

            $.each(list, function (index, user) {
                users +=
                    '<tr>' +
                    '<th scope="row">' + (index + 1) + '</th>' +
                    '<td>' + user.username + '</td>' +
                    '<td>' + user.first_name + '</td>' +
                    '<td>' + user.full_name + '</td>' +
                    '<td>' + user.role + '</td>' +
                    '<td>' +
                    '<a href="#" class="edit-user" data-id="' + user.id + '"><i class="fa fa-pencil-square-o"></i></a>' +
                    '&nbsp;<a href="#" class="delete-user" data-id="' + user.id + '"><i class="fa fa-trash-o"></i></a>' +
                    '</td>' +
                    '</tr>'
            });

            $('#costumers-list tbody').html(users);
            editButtonBehaviour();
            deleteButtonBehaviour();
        }
    });
}

function cleanFormData() {
    var form_action = $('form').attr('action');
    var end = form_action.indexOf('.php') + 4;
    form_action = form_action.substr(0, end);

    $('#username').val('');
    $('#id_role').val('');
    $("#first_name").val('');
    $("#full_name").val('');

    $('form').attr('action', form_action);
    $('form').attr('method', 'POST');
    $('#form_legend').text('Novo');

    $('#success-message').fadeOut();
}

function editButtonBehaviour() {
    $('.edit-user').on('click', function () {
        var id = $(this).data('id');
        var form_action = $('form').attr('action') + '/' + id;

        $.ajax({
            url: form_action,
            type: 'GET',
            success: function (result) {
                var user = JSON.parse(result);

                $('form').attr('action', form_action);
                $('form').attr('method', 'PUT');
                $('#form_legend').text('Alterar Dados');

                $('#username').val(user.username);
                $('#id_role').val(user.id_role);
                $("#first_name").val(user.first_name);
                $("#full_name").val(user.full_name);
            }
        });

        return false;
    });
}

function deleteButtonBehaviour() {
    $('.delete-user').on('click', function () {
        var id = $(this).data('id');
        var form_action = $('form').attr('action') + '/' + id;

        $.ajax({
            url: form_action,
            type: 'DELETE',
            success: function () {
                loadUsers();
            }
        });

        return false;
    });
}

function saveButtonBehaviour(){
    $('#btn_save').on('click', function() {
        $('#success-message').fadeOut();

        var form = $('form');
        form.validate(
            {
                lang: 'pt',
                rules: {
                    username: {
                        required: true,
                        maxlength: 15
                    },
                    id_role: {
                        required: true
                    },
                    first_name: {
                        required: true,
                        maxlength: 15
                    },
                    full_name: {
                        required: true,
                        maxlength: 50
                    }
                }
            }
        );

        if(form.valid()) {
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

                    loadUsers();
                }
            });
        }
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
    saveButtonBehaviour();
    clearButtonBehaviour();
    loadRoles('');
    loadUsers();
});