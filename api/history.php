<?php

$table = 'tbl_posting_history';

// get the HTTP method, path and body of the request
$method = $_SERVER['REQUEST_METHOD'];
$request = explode('/', trim($_SERVER['REQUEST_URI'],'/'));
$input = json_decode(file_get_contents('php://input'),true);
$pop = array_pop($request);
$key = is_numeric($pop) ? $pop+0 : 0;

include 'connection.php';

// build the SET part of the SQL command
$set = '';
if($method != 'GET' && $method != 'DELETE') {
    $columns = preg_replace('/[^a-z0-9_]+/i','',array_keys($input));
    $values = array_map(function ($value) use ($link) {
        if ($value===null) return null;
        return mysqli_real_escape_string($link,(string)$value);
    },array_values($input));

    for ($i = 0; $i < count($columns); $i++) {
        $set .= ($i > 0 ? ',' : '') . '`' . $columns[$i] . '`=';
        $set .= ($values[$i] === null ? 'NULL' : '"' . $values[$i] . '"');
    }
}
else if($method == 'GET' && $key == 0)
{
    $method = 'SEARCH';
    $begin_date = $_GET["begin_date"];
    $end_date = $_GET["end_date"];
}

// create SQL based on HTTP method
switch ($method) {
    case 'GET':
        $sql = "select * from `$table`".($key?" WHERE id=$key":''); break;
    case 'SEARCH':
        $sql = "SELECT h.id, h.posting_id, h.action, h.action_date, u.username as username,
                h.old_money_signal,
                h.old_due_date, 
                h.old_description, 
                pt.description as type, 
                c.name as costumer, 
                h.old_receipt ".
               "FROM tbl_posting_history as h ".
               "LEFT JOIN tbl_users as u on h.action_user = u.id ".
               "LEFT JOIN tbl_posting_types as pt on h.old_type = pt.id ".
               "LEFT JOIN tbl_costumers as c on h.old_costumer = c.id ".
               "WHERE action_date >= '$begin_date 00:00:00' and action_date <= '$end_date 23:59:59'";
        break;
    case 'PUT':
        $sql = "update `$table` set $set where id=$key"; break;
    case 'POST':
        $sql = "insert into `$table` set $set"; break;
    case 'DELETE':
        $sql = "delete from `$table` where id=$key"; break;
}

// excecute SQL statement
$result = mysqli_query($link,$sql);

// die if SQL statement failed
if (!$result) {
    http_response_code(404);
    die(mysqli_error());
}

// print results, insert id or affected row count
if ($method == 'GET' || $method == 'SEARCH') {
    if (!$key) echo '[';
    for ($i=0;$i<mysqli_num_rows($result);$i++) {
        echo ($i>0?',':'').json_encode(mysqli_fetch_object($result));
    }
    if (!$key) echo ']';
} elseif ($method == 'POST') {
    echo mysqli_insert_id($link);
}

// close mysql connection
mysqli_close($link);