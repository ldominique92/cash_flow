function cleanFormData() {
    $('#description').val('');
    $("#money_signal_in").prop("checked", true);
    $('#money_value').val('');
    $('#type').val('');
    $('#costumer').val('');
    $('#due_date').val('');
    $('#receipt').val('');

    $('#success-message').fadeOut();
}

function loadTypes(selected) {
    var form_action = $('form').attr('action').replace('postings', 'posting_types');

    $.ajax({
        url: form_action,
        type: 'GET',
        success: function (result) {
            var postingTypes = '';
            var list = JSON.parse(result);

            $.each(list, function (index, postingType) {
                postingTypes +=
                    '<option value="' +
                    postingType.id +
                    '">' +
                    postingType.description + '</option>';
            });

            $('#type').append(postingTypes);
            $('#type').val(selected);
        }
    });
}

function loadCostumers(selected) {
    var form_action = $('form').attr('action').replace('postings', 'costumers');

    $.ajax({
        url: form_action,
        type: 'GET',
        success: function (result) {
            var costumers = '';
            var list = JSON.parse(result);

            $.each(list, function (index, costumer) {
                costumers +=
                    '<option value="' +
                    costumer.id +
                    '">' +
                    costumer.name + '</option>';
            });

            $('#costumer').append(costumers);
            $('#costumer').val(selected);
        }
    });
}

function saveButtonBehaviour(){
    $('#btn_save').on('click', function() {
        $('#success-message').fadeOut();

        var id = getParameterByName("id", window.location.href);
        var form = $('form');
        form.validate(
            {
                lang: 'pt',
                rules: {
                    description: {
                        required: true,
                        maxlength: 100
                    },
                    money_signal: {
                        required: true,
                        maxlength: 1
                    },
                    money_value: {
                        required: true,
                        number: true
                    },
                    type: {
                        required: true
                    }
                    ,
                    costumer: {
                        required: true
                    },
                    due_date: {
                        required: true,
                        brazilianDate: true
                    }
                }
            }
        );

        if(form.valid()) {
            var form_data = getFormData(form);
            var form_action = form.attr('action');
            var form_method = form.attr('method');

            form_data.due_date = dateFormat(form_data.due_date);
            form_data.created_date = getCurrentDateForDatabase();

            $.ajax({
                url: form_action + (form_method == "PUT" ? '/' + id : ''),
                data: JSON.stringify(form_data),
                type: form_method,
                success: function () {
                    cleanFormData();
                    $('#success-message').fadeIn();
                }
            });
        }
        else
        {
            return false;
        }
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

function loadEntry() {
    var id = getParameterByName("id", window.location.href);
    var form_action = $('form').attr('action') + '/' + id;

    if(id) {
        $.ajax({
            url: form_action,
            type: 'GET',
            success: function (result) {
                var entry = JSON.parse(result);

                $('#description').val(entry.description);
                $('#type').val(entry.type);
                $('#costumer').val(entry.costumer);
                $('#due_date').val(dateFormatToJS(entry.due_date));
                $('#receipt').val(entry.receipt);
                $('#money_value').val(entry.money_value);

                if(entry.money_signal == '-') {
                    $("#money_signal_out").prop("checked", true);
                }
                else {
                    $("#money_signal_in").prop("checked", true);
                }

                loadTypes(entry.type);
                loadCostumers(entry.costumer);
            }
        });

        $('form').attr('method', 'PUT');
    }
    else {
        loadTypes('');
        loadCostumers('');
    }
}

$(document).ready(function () {
    loadEntry();

    $('#due_date').mask('00/00/0000');
    $('#money_value').mask("#0.00", {reverse: true});

    saveButtonBehaviour();
    clearButtonBehaviour();

    $.validator.addMethod(
        "brazilianDate",
        function(value, element) {
            // put your own logic here, this is just a (crappy) example
            return value.match(/^\d\d?\/\d\d?\/\d\d\d\d$/);
        },
        "Por favor informe uma data no formato dd/mm/yyyy."
    );
});