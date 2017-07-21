<?php
function getColumns($input) {
    return preg_replace('/[^a-z0-9_]+/i','',array_keys($input));
}

function getValues($input, $link) {
    return array_map(function ($value) use ($link) {
        if ($value===null) return null;
        return mysqli_real_escape_string($link,(string)$value);
    },array_values($input));
}

function getColumnsSet($link) {
    $input = json_decode(file_get_contents('php://input'),true);
    $set = '';
    $columns = getColumns($input);
    $values = getValues($input, $link);

    for ($i = 0; $i < count($columns); $i++) {
        $set .= ($i > 0 ? ',' : '') . '`' . $columns[$i] . '`=';
        $set .= ($values[$i] === null ? 'NULL' : '"' . $values[$i] . '"');
    }

    return $set;
}

function getColumnsSetAsArray($link) {
    $input = json_decode(file_get_contents('php://input'),true);
    $set = [];

    $columns = getColumns($input);
    $values = getValues($input, $link);

    for ($i = 0; $i < count($columns); $i++) {
        $set[$columns[$i]] = $values[$i];
    }

    return $set;
}

function getKey() {
    $request = explode('/', trim($_SERVER['REQUEST_URI'],'/'));
    $pop = array_pop($request);
    return is_numeric($pop) ? $pop+0 : 0;
}

function executeQuery($link,$sql) {
    // echo($sql);

    // excecute SQL statement
    $result = mysqli_query($link,$sql);

    // die if SQL statement failed
    if (!$result) {
        http_response_code(500);
        die(mysqli_error($link));
    }

    return $result;
}

function printQueryResult($link, $sql, $method, $key) {
    $result = executeQuery($link, $sql);

// print results, insert id or affected row count
    if ($method == 'GET') {
        printJson($result, $key);
    } elseif ($method == 'POST') {
        echo mysqli_insert_id($link);
    } else {
        echo mysqli_affected_rows($link);
    }
}

function printJson($result, $key) {
    if (!$key) echo '[';
    for ($i=0;$i<mysqli_num_rows($result);$i++) {
        echo ($i>0?',':'').json_encode(mysqli_fetch_object($result));
    }
    if (!$key) echo ']';
}