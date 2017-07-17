<?php
session_start();

if(isset($_SESSION["user_id"]))
{
    $online_users = ['Larissa', 'Tati', 'Maysa'];
}
else
{
    header('Location: login.php');
}

$site_url = "http://localhost/fluxo_de_caixa/";
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
    <link href="<?php echo ($site_url); ?>css/plugins/datepicker/bootstrap-datepicker.css" rel="stylesheet" type="text/css">
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
        <ul class="nav navbar-right top-nav">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-weixin"></i> Usuários Online <b class="caret"></b></a>
                <ul class="dropdown-menu message-dropdown">
                    <?php
                    foreach($online_users as $online_user): ?>
                        <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    <div class="media-body">
                                        <h5 class="media-heading"><strong><?php echo ($online_user); ?></strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i> Ativo às 12:00h</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo ($_SESSION["user_name"]); ?> <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="administration.php"><i class="fa fa-fw fa-gear"></i> Configurações</a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="logout.php"><i class="fa fa-fw fa-power-off"></i> Sair</a>
                    </li>
                </ul>
            </li>
        </ul>
        <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav side-nav">
                <li class="active">
                    <a href="<?php echo ($site_url); ?>index.php"><i class="fa fa-fw fa-home "></i> Home</a>
                </li>
                <li>
                    <a href="javascript:;" data-toggle="collapse" data-target="#fluxo"><i class="fa fa-fw fa-table"></i> Fluxo de Caixa<i class="fa fa-fw fa-caret-down"></i></a>
                    <ul id="fluxo" class="collapse">
                        <li>
                            <a href="<?php echo ($site_url); ?>cash_flow/entry.php"> Lançamento</a>
                        </li>
                        <li>
                            <a href="<?php echo ($site_url); ?>cash_flow/date_search.php"> Relatório</a>
                        </li>
                        <li>
                            <a href="<?php echo ($site_url); ?>cash_flow/history.php"> Histórico</a>
                        </li>
                    </ul>
                </li>
                <?php
                if($_SESSION["user_role"] == 1)
                {?>
                    <li>
                        <a href="<?php echo ($site_url); ?>users.php"><i class="fa fa-fw fa-users"></i> Usuários</a>
                    </li>
                    <li>
                        <a href="<?php echo ($site_url); ?>costumers.php"><i class="fa fa-fw fa-industry"></i> Clientes e Fornecedores</a>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </nav>

    <div id="page-wrapper">

        <div class="container-fluid">