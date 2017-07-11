function resetForm() {
    var date = getCurrentDateForJS();

    $('#due_date_begin').val(date);
    $('#due_date_end').val(date);

    searchPostings();

    $('#error-message').fadeOut();
}

function deleteButtonBehaviour() {
    $('.delete-posting').on('click', function () {
        var id = $(this).data('id');
        var form_action = $('form').attr('action') + '/' + id;

        $.ajax({
            url: form_action,
            type: 'DELETE',
            success: function () {
                searchPostings();
            }
        });

        return false;
    });
}

function searchPostings() {
    var form_action = $('form').attr('action');

    var due_date_begin = dateFormat($('#due_date_begin').val());
    var due_date_end = dateFormat($('#due_date_end').val());

    $.ajax({
        url: form_action + '?due_date_begin=' + due_date_begin + '&due_date_end=' + due_date_end,
        type: 'GET',
        success: function (result) {
            var postings = '';
            var list = JSON.parse(result);

            if(list.length > 0) {
                $.each(list, function (index, posting) {
                    postings +=
                        '<tr class="' + (posting.money_signal == '+' ?  'bg-success' : 'bg-danger') + '">' +
                        '<td>' + dateFormatToJS(posting.due_date) + '</td>' +
                        '<td>' + posting.description + '</td>' +
                        '<td>' + posting.money_value + '</td>' +
                        '<td>' + posting.type + '</td>' +
                        '<td>' + posting.costumer + '</td>' +
                        '<td>' +
                        (posting.receipt == null ? '' : '<a href="../files/receipt/' + posting.receipt + '"><i class="fa fa-download"></i></a>') +
                        '&nbsp;<a href="entry.php?id=' + posting.id + '"><i class="fa fa-pencil-square-o"></i></a>' +
                        '&nbsp;<a href="#" class="delete-posting" data-id="' + posting.id + '"><i class="fa fa-trash-o"></i></a>' +
                        '</td>' +
                        '</tr>'
                });

                $('#postings-list tbody').html(postings);
                deleteButtonBehaviour();
            }
            else
            {
                $('#error-message').fadeIn();
                $('#postings-list tbody').html('');
            }
        }
    });
}

function loadBalance() {
    var form_action = $('form').attr('action').replace('postings', 'balance');
    var initial_day = dateFormat($('#due_date_begin').val());

    $.ajax({
        url: form_action + '?date=' + initial_day + '&type=initial',
        type: 'GET',
        success: function (result) {
            $('#initial_balance').text(formatMoney(JSON.parse(result).value));
        }
    });

    var final_day = dateFormat($('#due_date_end').val());
    $.ajax({
        url: form_action + '?date=' + final_day + '&type=final',
        type: 'GET',
        success: function (result) {
            $('#final_balance').text(formatMoney(JSON.parse(result).value));
        }
    });
}

function searchButtonBehaviour(){
    $('#btn_search').on('click', function() {
        searchPostings();
        return false;
    });
}

$(document).ready(function () {
    resetForm();
    searchButtonBehaviour();
    loadBalance();
});