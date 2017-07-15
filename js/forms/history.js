function loadUsers() {
    var form_action = $('form').attr('action').replace('history', 'users');

    $.ajax({
        url: form_action,
        type: 'GET',
        success: function (result) {
            var users = '';
            var list = JSON.parse(result);

            $.each(list, function (index, user) {
                users +=
                    '<option value="' +
                    user.id +
                    '">' +
                    user.username + '</option>';
            });

            $('#user').append(users);
        }
    });
}

function resetForm() {
    var date = getCurrentDateForJS();

    $('#begin_date').val(date);
    $('#end_date').val(date);

    $('#begin_date').mask('00/00/0000');
    $('#end_date').mask('00/00/0000');

    searchHistory();

    $('#error-message').fadeOut();
}

function searchHistory() {
    var form_action = $('form').attr('action');

    var begin_date = dateFormat($('#begin_date').val());
    var end_date = dateFormat($('#end_date').val());

    $.ajax({
        url: form_action + '?begin_date=' + begin_date + '&end_date=' + end_date,
        type: 'GET',
        success: function (result) {
            var html_code = '';
            var list = JSON.parse(result);

            if(list.length > 0) {
                $.each(list, function (index, posting) {
                    html_code +=
                        '<tr class="' + (posting.action == 'A' ?  'bg-success' : (posting.action == 'U' ? 'bg-warning' : 'bg-danger')) + '">' +
                        '<td>' + dateFormatToJS(posting.action_date) + '</td>' +
                        '<td>' + (posting.action == 'A' ?  'ADICIONOU' : (posting.action == 'U' ? 'ALTEROU' : 'DELETOU')) + '</td>' +
                        '<td>' + posting.username + '</td>' +
                        '<td>' +
                        (posting.receipt == null ? '' : '<a href="../files/receipt/' + posting.receipt + '"><i class="fa fa-download"></i></a>') +
                        '&nbsp;<a href="entry.php?id=' + posting.id + '"><i class="fa fa-pencil-square-o"></i></a>' +
                        '&nbsp;<a href="#" class="delete-posting" data-id="' + posting.id + '"><i class="fa fa-trash-o"></i></a>' +
                        '</td>' +
                        '</tr>'
                });

                $('#postings-list tbody').html(html_code);
                deleteButtonBehaviour();
            }
            else
            {
                $('#error-message').fadeIn();
            }
        }
    });
}

function searchButtonBehaviour(){
    $('#btn_search').on('click', function() {
        searchHistory();
        return false;
    });
}

$(document).ready(function () {
    resetForm();
    searchButtonBehaviour();
    loadUsers();
});