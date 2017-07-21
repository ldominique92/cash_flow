<?php
session_start();

if(isset($_SESSION["user_id"])) {
    $table = 'tbl_users';
    $set = [];

    $password = base64_encode("123456");

    include 'header.php';

    if($method != 'GET' && $method != 'DELETE') {
        $set = getColumnsSetAsArray($link);
    }

// create SQL based on HTTP method
    switch ($method) {
        case 'GET':
            $sql = "SELECT u.id, u.username, u.first_name, u.full_name, r.name as role, u.id_role ".
                "FROM tbl_users as u ".
                "INNER JOIN tbl_roles as r on r.id = u.id_role".($key?" WHERE u.id=$key":'');
            break;
        case 'PUT':
            $sql = "UPDATE tbl_users SET first_name = '".$set["first_name"].
                "', full_name = '".$set["full_name"].
                "', id_role = ".$set["id_role"].
                " WHERE id=$key";
            echo ($sql);
            break;
        case 'POST':
            $sql = "INSERT INTO tbl_users(username, first_name, full_name, id_role, password, change_password) ".
                "VALUES ('".$set["username"].
                "', '".$set["first_name"].
                "', '".$set["full_name"].
                "', ".$set["id_role"].", '$password', 1)";

            break;
        case 'DELETE':
            $sql = $basic_delete; break;
    }

// excecute SQL statement
    printQueryResult($link, $sql, $method, $key);

// close mysql connection
    mysqli_close($link);
}
else {
    http_response_code(403);
}