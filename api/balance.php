<?php
session_start();

if (isset($_SESSION["user_id"])) {
    include 'header.php';

    $date = $_GET["date"];
    $type = $_GET["type"];

    if ($type == "initial") {
        $day = substr($date, 8, 2);
        $month = substr($date, 5, 2);
        $year = substr($date, 0, 4);

        $smaller_months = array(2, 4, 6, 8, 9, 11);
        $bigger_months = array(5, 7, 10, 12);

        if ($month == 1 && $day == 1) {
            $day = 31;
            $month = 12;
            $year--;
        } else if (in_array($month, $smaller_months) && $day == 1) {
            $day = 31;
            $month--;
        } else if ($month == 3 && $day == 1) {
            $day = $year % 4 == 0 ? 29 : 28;
            $month--;
        } else if (in_array($month, $bigger_months) && $day == 1) {
            $day = 30;
            $month--;
        } else {
            $day--;
        }

        $date = "$year-$month-$day";
    }

    $sql = "select * from `tbl_balance` WHERE date <= '$date' ORDER BY date DESC";

    $result = executeQuery($link, $sql);

    if ($row = mysqli_fetch_object($result)) {
        echo(json_encode($row));
    } else {
        echo(json_encode(json_decode("{ \"value\" : \"0\" }")));
    }

// close mysql connection
    mysqli_close($link);
} else {
    http_response_code(403);
}