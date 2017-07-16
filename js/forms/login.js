function cleanFormData() {
    $('#username').val('');
    $('#password').val('');
    $('#error-message').fadeOut();
}

function enterButtonBehaviour(){
    $('#btn-enter').on('click', function() {
        $('#error-message').fadeOut();

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