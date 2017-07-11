<?php
include '../header.php';
?>
<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Relatório de Fluxo de Caixa
        </h1>
        <ol class="breadcrumb">
            <li>
                <i class="fa fa-table"></i>  <a href="index.html">Fluxo de Caixa</a>
            </li>
            <li class="active">
                Relatório
            </li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <form class="form-horizontal" action="<?php echo ($site_url); ?>API/postings.php" method="GET">
            <fieldset>
                <legend id="form_legend">Buscar Datas</legend>
                <div class="alert alert-danger" id="error-message" style="display: none;">
                    Não há lançamentos para esse dia
                </div>
                <div class="form-group">
                    <label class="col-md-1 control-label" for="due_date_begin">De</label>
                    <div class="col-md-2">
                        <input id="due_date_begin" name="due_date_begin" type="text" placeholder="" class="form-control input-md" required="">
                    </div>
                    <label class="col-md-1 control-label" for="due_date_end">Até</label>
                    <div class="col-md-2">
                        <input id="due_date_end" name="due_date_end" type="text" placeholder="" class="form-control input-md" required="">
                    </div>
                    <div class="col-md-4">
                        <button id="btn_search" name="save" class="btn btn-default">Buscar</button>
                        <a href="entry.php" id="btn_new" name="new" class="btn btn-default">Novo Lançamento</a>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>
<div class="row">
    <h4 class="balance col-lg-12">Saldo Inicial R$ <span id="initial_balance" name="initial_balance" type="text"></span></h4>
</div>
<div class="row">
    <div class="col-lg-12">
        <table class="table table-bordered" id="postings-list">
            <thead>
            <tr>
                <th>Data</th>
                <th>Descrição</th>
                <th>Valor</th>
                <th>Tipo</th>
                <th>Cliente/Fornecedor</th>
                <th></th>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>
<div class="row">
    <h4 class="balance col-lg-12">Saldo Final R$ <span id="final_balance" name="final_balance" type="text"></span></h4>
</div>
<script src="<?php echo ($site_url); ?>js/plugins/jquery-mask.js"></script>
<script src="<?php echo ($site_url); ?>js/forms/functions.js"></script>
<script src="<?php echo ($site_url); ?>js/forms/date_search.js"></script>
<?php
include '../footer.php';
?>
            
