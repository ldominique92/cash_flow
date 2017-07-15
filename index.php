<?php
include 'header.php';
?>
<link href="<?php echo ($site_url); ?>css/plugins/datepicker/datepicker.less" rel="stylesheet/less">
<script src="<?php echo ($site_url); ?>js/plugins/datepicker/bootstrap-datepicker.js"></script>
<link href="<?php echo ($site_url); ?>css/plugins/jquery-timeliner.css" rel="stylesheet">
<script src="<?php echo ($site_url); ?>js/plugins/jquery-timeliner.js"></script>
<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Bem vindo!
        </h1>
        <ol class="breadcrumb">
            <li class="active">
                <i class="fa fa-home"></i> Home
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->

<?php
$link = mysqli_connect('localhost', 'root', '', 'db_cash_flow');
mysqli_set_charset($link,'utf8');

date_default_timezone_set("America/Sao_Paulo");
$date = date("Y-m-d");

$sql = "select * from `tbl_balance` WHERE date >= '$date' && value < 0 ORDER BY date";

// excecute SQL statement
$result = mysqli_query($link,$sql);

// die if SQL statement failed
if (!$result) {
    http_response_code(404);
    die(mysqli_error());
}

if($row = mysqli_fetch_object($result)) {

    $date = $row->date;

    $day = substr($date, 8, 2);
    $month = substr($date, 5, 2);
    $year = substr($date, 0, 4);

    $date = "$day/$month/$year";

    ?>

    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <i class="fa fa-exclamation-triangle"></i>
                <strong>Atenção! </strong>
                O caixa ficará negativo em <?php echo($date); ?>!
            </div>
        </div>
    </div>
    <!-- /.row -->
    <?php
}
?>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-money fa-fw"></i> Próximos lançamentos</h3>
            </div>
            <div class="panel-body tumeliner-container">
                <div id="timeliner">
                    <ul class="columns">
                        <?php
                        $date = date("Y-m-d");

                        $sql = "SELECT p.description, t.description as type, p.money_signal, p.money_value, p.due_date, c.name as costumer ".
                            "FROM tbl_postings p ".
                            "INNER JOIN tbl_costumers c ON c.id = p.costumer ".
                            "INNER JOIN tbl_posting_types t ON t.id = p.type ".
                            " WHERE p.due_date >= '$date' ORDER BY p.due_date LIMIT 10".
                            "";
                        //echo($sql);

                        // excecute SQL statement
                        $result = mysqli_query($link,$sql);

                        // die if SQL statement failed
                        if (!$result) {
                            http_response_code(404);
                            die(mysqli_error());
                        }

                        while($row = mysqli_fetch_object($result)) {
                            $due_date = $row->due_date;

                            $day = substr($due_date, 8, 2);
                            $month = substr($due_date, 5, 2);
                            $year = substr($due_date, 0, 4);

                            $due_date = "$day/$month/$year";
                            ?>
                            <li>
                                <?php
                                if($row->money_signal == "+") {
                                ?>
                                <div class="timeliner_element green">
                                    <?php }
                                    else {
                                    ?>
                                    <div class="timeliner_element bricky">
                                        <?php
                                        }
                                        ?>
                                        <div class="timeliner_title">
                                    <span class="timeliner_label">
                                        <?php echo($row->description); ?>
                                    </span>
                                            <span class="timeliner_date">
                                        <?php echo($due_date); ?>
                                    </span>
                                        </div>
                                        <div class="content">
                                            <?php
                                            echo ("R$ ".$row->money_signal.$row->money_value." ");
                                            if($row->money_signal == "+") {
                                                echo("recebido de");
                                            }
                                            else {
                                                echo("pago a");
                                            }
                                            echo(" ".$row->costumer." como ".$row->type);
                                            ?>
                                        </div>
                                    </div>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo ($site_url); ?>js/next-postings.js"></script>
<!-- /.row -->
<?php
include 'footer.php';
?>
            
