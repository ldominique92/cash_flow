<?php
session_start();

if(isset($_SESSION["user_id"])) {
    $user = $_SESSION["user_id"];

    $table = 'tbl_postings';

    date_default_timezone_set("America/Sao_Paulo");
    $action_date = date("Y-m-d h:i:s");
    $action_user = $user;

// get the HTTP method, path and body of the request
    $method = $_SERVER['REQUEST_METHOD'];
    $request = explode('/', trim($_SERVER['REQUEST_URI'],'/'));
    $input = json_decode(file_get_contents('php://input'),true);
    $pop = array_pop($request);
    $key = is_numeric($pop) ? $pop+0 : 0;

    $set = [];
    include 'header.php';

// build the SET part of the SQL command
    if($method != 'GET' && $method != 'DELETE') {
        $columns = preg_replace('/[^a-z0-9_]+/i','',array_keys($input));
        $values = array_map(function ($value) use ($link) {
            if ($value===null) return null;
            return mysqli_real_escape_string($link,(string)$value);
        },array_values($input));

        for ($i = 0; $i < count($columns); $i++) {
            $set[$columns[$i]] = $values[$i];
        }

        $set["created_by"] = $user;
    }
    else if($method == 'GET' && $key == 0)
    {
        $method = 'SEARCH';
        $due_date_begin = $_GET["due_date_begin"];
        $due_date_end = $_GET["due_date_end"];
    }

// recover data to history
    if ($method == 'PUT'|| $method == 'DELETE') {
        $sql = "select * from `$table`".($key?" WHERE id=$key":'');
        $old_result = mysqli_query($link,$sql);

        $row = mysqli_fetch_object($old_result);
    }

// create SQL based on HTTP method
    switch ($method) {
        case 'GET':
            $sql = "select * from `$table`".($key?" WHERE id=$key":''); break;
        case 'SEARCH':
            $sql = "SELECT p.id, p.money_signal, p.due_date, p.description, pt.description as type, c.name as costumer, ".
                "p.receipt, p.money_value ".
                "FROM tbl_postings as p ".
                "INNER JOIN tbl_posting_types as pt on p.type = pt.id ".
                "INNER JOIN tbl_costumers as c on p.costumer = c.id ".
                "WHERE due_date >= '$due_date_begin' and due_date <= '$due_date_end'";
            break;
        case 'PUT':
            $sql = "update `$table` set ".
                   "description = '".$set["description"]."', type = ".$set["type"].
                   ", money_signal = '".$set["money_signal"]."', money_value=".$set["money_value"].
                   ", costumer = ".$set["costumer"].", due_date = '".$set["due_date"].
                   "' where id=$key";

                    break;
        case 'POST':
            $sql = "insert into $table".
                   "(description,type,money_signal,money_value,created_date,created_by,costumer,due_date,receipt) ".
                   " VALUES ('".$set["description"]."', ".$set["type"].", '".$set["money_signal"]."', ".
                   $set["money_value"].", '".$set["created_date"]."', ".$set["created_by"].", ".$set["costumer"].
                   ", '".$set["due_date"]."', '".$set["receipt"]."')"; break;
        case 'DELETE':
            $sql = "delete from `$table` where id=$key"; break;
    }

    // excecute SQL statement
    $result = mysqli_query($link,$sql);

// die if SQL statement failed
    if (!$result) {
        http_response_code(500);
        die(mysqli_error());
    }

// history
    $insert_id = 0;
    if ($method == 'POST') {
        $insert_id = mysqli_insert_id($link);

        $sql = "INSERT INTO tbl_posting_history(posting_id, `action`, action_date, action_user)
                VALUES(".$insert_id.", 'A', '".$action_date."', ".$action_user.")";

        $history = mysqli_query($link,$sql);
        if (!$history) {
            http_response_code(500);
            die(mysqli_error());
        }
    }
    else if($method == "PUT" || $method == "DELETE") {

        $action = "D";
        if ($method == 'PUT') {
            $action = "U";
        }

        $sql = "INSERT INTO tbl_posting_history(posting_id, `action`, action_date, action_user, 
                old_money_signal, old_due_date, old_description, old_type, old_costumer, old_receipt)
                VALUES(".$row->id.",
                       '".$action."',
                       '".$action_date."', 
                        ".$action_user.", 
                       '".$row->money_signal."',
                       '".$row->due_date."',
                       '".$row->description."',
                        ".$row->type.",
                        ".$row->costumer.",
                       '".$row->receipt."')";

        $history = mysqli_query($link,$sql);
        if (!$history) {
            http_response_code(500);
            die(mysqli_error());
        }
    }

// balance
    if($method == 'PUT' || $method == 'POST' || $method == 'DELETE'){
        if ($method == 'POST') {
            $sql = "SELECT * FROM tbl_postings WHERE id =" . $insert_id;
            echo ($sql);
            $r_posting = mysqli_query($link, $sql);
            if (!$r_posting) {
                http_response_code(500);
                die(mysqli_error());
            }

            $posting = mysqli_fetch_object($r_posting);
            $value = $posting->money_value;
            $signal = $posting->money_signal;
            $due_date = $posting->due_date;

            if ($signal == "-") {
                $value *= -1;
            }
        }
        else if($method == "PUT") {
            $sql = "SELECT * FROM tbl_postings WHERE id =" . $key;
            $r_posting = mysqli_query($link, $sql);
            if (!$r_posting) {
                http_response_code(500);
                die(mysqli_error());
            }

            $posting = mysqli_fetch_object($r_posting);
            $value = $posting->money_value;
            $signal = $posting->money_signal;
            $due_date = $posting->due_date;

            if ($signal == "-") {
                $value *= -1;
            }

            if($due_date == $row->due_date){

                if($row->money_signal == "-"){
                    $value += $row->money_value;
                }
                else {
                    $value -= $row->money_value;
                }
            }
            else
            {
                $sql = "SELECT * FROM tbl_balance WHERE date ='".$due_date."'";
                $r_balance = mysqli_query($link,$sql);
                if (!$r_balance) {
                    http_response_code(500);
                    die(mysqli_error());
                }

                $r_balance = mysqli_fetch_object($r_balance);
                if(mysqli_num_rows($r_balance) > 0)
                {
                    $balance = mysqli_fetch_object($r_balance);
                    $value = $balance->value + $value;

                    $sql = "UPDATE tbl_balance SET value=$value WHERE date ='".$due_date."'";
                    $r_balance = mysqli_query($link,$sql);
                    if (!$r_balance) {
                        http_response_code(500);
                        die(mysqli_error());
                    }
                }
            }
        }
        else if ($method == "DELETE") {
            $value = $row->money_value;
            $due_date = $row->due_date;

            if ($row->money_signal == "+") {
                $value *= -1;
            }
        }

        $sql = "SELECT * FROM tbl_balance WHERE date ='".$due_date."'";
        $r_balance = mysqli_query($link,$sql);
        if (!$r_balance) {
            http_response_code(500);
            die(mysqli_error());
        }

        if(mysqli_num_rows($r_balance) == 0)
        {
            // Get last balance
            $sql = "select * from `tbl_balance` WHERE date < '$due_date' ORDER BY date DESC";
            $r_balance = mysqli_query($link,$sql);
            if (!$r_balance) {
                http_response_code(500);
                die(mysqli_error());
            }

            $balance = mysqli_fetch_object($r_balance);
            $value = $balance->value + $value;

            $sql = "INSERT INTO tbl_balance(date, value) VALUES ('".$due_date."', $value)";
            $r_balance = mysqli_query($link,$sql);
            if (!$r_balance) {
                http_response_code(500);
                die(mysqli_error());
            }
        }
        else
        {
            $balance = mysqli_fetch_object($r_balance);
            $value = $balance->value + $value;

            $sql = "UPDATE tbl_balance SET value=$value WHERE date ='".$due_date."'";
            $r_balance = mysqli_query($link,$sql);
            if (!$r_balance) {
                http_response_code(500);
                die(mysqli_error());
            }
        }
    }

// print results, insert id or affected row count
    if ($method == 'GET' || $method == 'SEARCH') {
        if (!$key) echo '[';
        for ($i=0;$i<mysqli_num_rows($result);$i++) {
            echo ($i>0?',':'').json_encode(mysqli_fetch_object($result));
        }
        if (!$key) echo ']';
    } elseif ($method == 'POST') {
        echo $insert_id;
    }

// close mysql connection
    mysqli_close($link);
}
else {
    http_response_code(403);
}