<?php 
	include 'header.php';
?>

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
				<h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Area Chart</h3>
			</div>
			
		</div>
	</div>
</div>
<!-- /.row -->
<?php 
	include 'footer.php';
?>
            
