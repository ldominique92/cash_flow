<?php
session_start();

if(isset($_SESSION["user_id"])) {
    $table = 'tbl_users';
    $password = base64_encode("123456");

// get the HTTP method, path and body of the request
    $method = $_SERVER['REQUEST_METHOD'];
    $request = explode('/', trim($_SERVER['REQUEST_URI'],'/'));
    $input = json_decode(file_get_contents('php://input'),true);
    $pop = array_pop($request);
    $key = is_numeric($pop) ? $pop+0 : 0;

    include 'connection.php';

// build the SET part of the SQL command
    $set = [];
    if($method != 'GET' && $method != 'DELETE') {
        $columns = preg_replace('/[^a-z0-9_]+/i','',array_keys($input));
        $values = array_map(function ($value) use ($link) {
            if ($value===null) return null;
            return mysqli_real_escape_string($link,(string)$value);
        },array_values($input));

        for ($i = 0; $i < count($columns); $i++) {
            $set[$columns[$i]] = $values[$i];
        }
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
    if ($method == 'GET') {
        if (!$key) echo '[';
        for ($i=0;$i<mysqli_num_rows($result);$i++) {
            echo ($i>0?',':'').json_encode(mysqli_fetch_object($result));
        }
        if (!$key) echo ']';
    } elseif ($method == 'POST') {
        echo mysqli_insert_id($link);
    } else {
        echo mysqli_affected_rows($link);
    }

// close mysql connection
    mysqli_close($link);
}
else {
    http_response_code(403);
}