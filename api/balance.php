<?php
include 'connection.php';

$date = $_GET["date"];
$type = $_GET["type"];

if($type == "initial")
{
    $day = substr($date, 8, 2);
    $month = substr($date, 5, 2);
    $year = substr($date, 0, 4);

    if($month == 1 && $day == 1)
    {
        $day = 31;
        $month = 12;
        $year--;
    }
    else if (($month == 2 || $month == 4 || $month == 6 || $month == 8 || $month == 9 || $month == 11) && ($day == 1)) {
        $day = 31;
        $month--;
    }
    else if ($month == 3 && $day == 1) {
        $day = $year%4 == 0 ? 29 : 28;
        $month--;
    }
    else if (($month == 5 || $month == 7 || $month == 10 || $month == 12) && ($day == 1)) {
        $day = 30;
        $month--;
    }
    else {
        $day--;
    }

    $date = "$year-$month-$day";
}

$sql = "select * from `tbl_balance` WHERE date = '$date'";
// excecute SQL statement
$result = mysqli_query($link,$sql);

// die if SQL statement failed
if (!$result) {
    http_response_code(404);
    die(mysqli_error());
}

if($row = mysqli_fetch_object($result)) {
    echo (json_encode($row));
}
else {
    echo (json_encode(json_decode("{ \"value\" : \"0\" }")));
}

// close mysql connection
mysqli_close($link);