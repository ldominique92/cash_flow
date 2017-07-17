function getFormData($form){
    var unindexed_array = $form.serializeArray();
    var indexed_array = {};

    $.map(unindexed_array, function(n, i){
        indexed_array[n['name']] = n['value'];
    });

    return indexed_array;
}

function dateFormat(originalDate) {
    var day = originalDate.substr(0, 2);
    var month = originalDate.substr(3, 2);
    var year = originalDate.substr(6, 4);

    return year + '-' + month + '-' + day;
}

function dateFormatToJS(originalDate) {
    var day = originalDate.substr(8, 2);
    var month = originalDate.substr(5, 2);
    var year = originalDate.substr(0, 4);

    return day + '/' + month + '/' + year;
}

function getCurrentDateForDatabase() {
    var date = new Date();

    var day = date.getDate().toString();
    var month = (date.getMonth() + 1).toString();
    var year = date.getFullYear();

    var hours = date.getHours().toString();
    var minutes = date.getMinutes().toString();
    var seconds = date.getSeconds().toString();

    return year +
        '-' +
        (month.length == 2 ? month : '0' + month) +
        '-' +
        (day.length == 2 ? day : '0' + day) +
        ' ' +
        (hours.length == 2 ? hours : '0' + hours) +
        ':' +
        (minutes.length == 2 ? minutes : '0' + minutes) +
        ':' +
        (seconds.length == 2 ? seconds : '0' + seconds);
}

function getCurrentDateForJS() {
    var date = new Date();

    var day = date.getDate().toString();
    var month = (date.getMonth() + 1).toString();
    var year = date.getFullYear();

    return (day.length == 2 ? day : '0' + day) + '/' + (month.length == 2 ? month : '0' + month) + '/' + year;
}

function formatMoney(number) {
    return number.toFixed(2);
}

function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}