function cleanFormData() {
    $('#username').val('');
    $('#password').val('');
    $('#new_password').val('');
}

function enterButtonBehaviour(){
    $('#btn-enter').on('click', function() {

        var form = $('form');
        form.validate(
            {
                lang: 'pt',
                rules: {
                    username: {
                        required: true
                    },
                    password: {
                        required: true
                    },
                    new_password: {
                        required: true
                    },
                    repeat_password: {
                        required: true,
                        equalTo: password
                    }
                }
            }
        );

        return form.valid();
    });
}

$(document).ready(function () {
    enterButtonBehaviour();
    cleanFormData();
});