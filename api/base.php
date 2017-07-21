<?php
$set = '';
include "header.php";

// create SQL based on HTTP method
switch ($method) {
    case 'GET':
        $sql = $basic_get; break;
    case 'PUT':
        $sql = $basic_put; break;
    case 'POST':
        $sql = $basic_insert; break;
    case 'DELETE':
        $sql = $basic_delete; break;
}

printQueryResult($link, $sql, $method, $key);

// close mysql connection
mysqli_close($link);