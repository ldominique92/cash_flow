<?php
session_start();

$show_message = false;

if(isset($_SESSION["user_id"]))
{
    header('Location: index.php');
}

$site_url = "http://localhost/fluxo_de_caixa/";

if(isset($_POST["username"])) {

    $link = mysqli_connect('localhost', 'root', '', 'db_cash_flow');
    mysqli_set_charset($link,'utf8');

    $password = base64_encode($_POST["password"]);

    $sql = "SELECT id, username, first_name, full_name, id_role, change_password FROM tbl_users " .
        "WHERE username = '" . $_POST["username"] . "' AND password = '" . $password . "'";

    // excecute SQL statement
    $result = mysqli_query($link, $sql);

    // die if SQL statement failed
    if (!$result) {
        die(mysqli_error());
    }

    if($row = mysqli_fetch_object($result)) {

        session_start();
        $_SESSION["logged_user"] = $row->username;
        $_SESSION["user_name"] = $row->first_name;
        $_SESSION["user_id"] = $row->id;
        $_SESSION["user_role"] = $row->id_role;

        $change_password = $row->change_password;

        // close mysql connection
        mysqli_close($link);

        if($change_password) {
            header('Location: change_password.php');
        }
        else {
            header('Location: index.php');
        }
    }
    else {
        $show_message = true;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Caminhos de Arauc&aacute;ria - Fluxo de Caixa</title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo ($site_url); ?>css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo ($site_url); ?>css/sb-admin.css" rel="stylesheet">
    <link href="<?php echo ($site_url); ?>css/cash-flow.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="<?php echo ($site_url); ?>css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php echo ($site_url); ?>font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Cabin|Lato|Montserrat|Muli" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- jQuery -->
    <script src="<?php echo ($site_url); ?>js/jquery.js"></script>
</head>
<body>
<div id="wrapper">
    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Menu</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">Caminhos de Arauc&aacute;ria - Fluxo de Caixa</a>
        </div>
        <!-- Top Menu Items -->
        <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
        </div>
        <!-- /.navbar-collapse -->
    </nav>

    <div id="page-wrapper">

        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Entrar
                    </h1>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <form class="form-horizontal" method="POST">
                        <div class="alert alert-danger" id="error-message" style="display: <?php echo($show_message ? "block;" : "none"); ?>;">
                            Login e senha incorretos
                        </div>
                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="username">Login</label>
                            <div class="col-md-4">
                                <input id="username" name="username" type="text" class="form-control input-md" required="">
                            </div>
                        </div>
                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="password">Senha</label>
                            <div class="col-md-4">
                                <input id="password" name="password" type="password" class="form-control input-md" required="">
                            </div>
                        </div>
                        <!-- Button (Double) -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="btn-enter"></label>
                            <div class="col-md-8">
                                <button id="btn-enter" name="btn-enter" class="btn btn-default">Entrar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<!-- Bootstrap Core JavaScript -->
<script src="<?php echo ($site_url); ?>js/bootstrap.min.js"></script>

<!-- Morris Charts JavaScript -->
<script src="<?php echo ($site_url); ?>js/plugins/morris/raphael.min.js"></script>
<script src="<?php echo ($site_url); ?>js/plugins/morris/morris.min.js"></script>
<script src="<?php echo ($site_url); ?>js/plugins/morris/morris-data.js"></script>

<script src="<?php echo ($site_url); ?>js/plugins/jquery.validate.js"></script>
<script src="<?php echo ($site_url); ?>js/forms/login.js"></script>

</body>

</html>


