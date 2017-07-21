<?php
session_start();

if(isset($_SESSION["user_id"])) {
    $table = 'tbl_posting_history';
    $set = '';

    include 'header.php';

    if($method != 'GET' && $method != 'DELETE') {
        $set = getColumnsSet($input, $link);
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
            $sql = $basic_get; break;
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
            $sql = $basic_put; break;
        case 'POST':
            $sql = $basic_insert; break;
        case 'DELETE':
            $sql = $basic_delete; break;
    }

    $result = executeQuery($link,$sql);

// print results, insert id or affected row count
    if ($method == 'GET' || $method == 'SEARCH') {
        printJson($result, $key);
    } elseif ($method == 'POST') {
        echo mysqli_insert_id($link);
    }

// close mysql connection
    mysqli_close($link);
}
else {
    http_response_code(403);
}