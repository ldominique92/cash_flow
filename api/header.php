<?php
// connect to the mysql database
$link = mysqli_connect('localhost', 'root', '', 'db_cash_flow');
mysqli_set_charset($link,'utf8');

include 'utils.php';

// get the HTTP method, path and body of the request
$method = $_SERVER['REQUEST_METHOD'];
$key = getKey();

if(isset($table)) {
    $basic_get = "select * from `$table`" . ($key ? " WHERE id=$key" : '');
    $basic_delete = "delete from `$table` where id=$key";

    if (is_string($set)) {
        if($method != 'GET' && $method != 'DELETE') {
            $set = getColumnsSet($link);
        }
        
        $basic_put = "update `$table` set $set where id=$key";
        $basic_insert = "insert into `$table` set $set";
    }
}