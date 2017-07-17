<?php
session_start();

if(isset($_SESSION["user_id"])) {
    $table = 'tbl_costumers';

    include 'base.php';
}
else {
    http_response_code(403);
}