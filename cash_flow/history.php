<?php
include '../header.php';
?>
<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Histórico do Fluxo de Caixa
        </h1>
        <ol class="breadcrumb">
            <li>
                <i class="fa fa-table"></i>  <a href="index.html">Fluxo de Caixa</a>
            </li>
            <li class="active">
                Histórico
            </li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <form class="form-horizontal" action="<?php echo ($site_url); ?>API/history.php" method="GET">
            <fieldset>
                <legend id="form_legend">Pesquisar</legend>
                <div class="alert alert-danger" id="error-message" style="display: none;">
                    Não há histórico de alterações para a busca realizada
                </div>
                <div class="form-group">
                    <label class="col-md-1 control-label" for="begin_date">De</label>
                    <div class="col-md-2">
                        <input id="begin_date" name="begin_date" type="text" placeholder="" class="form-control input-md" required="">
                    </div>
                    <label class="col-md-1 control-label" for="end_date">Até</label>
                    <div class="col-md-2">
                        <input id="end_date" name="end_date" type="text" placeholder="" class="form-control input-md" required="">
                    </div>
                    <!--<label class="col-md-1 control-label" for="user">Usuário</label>
                    <div class="col-md-2">
                        <select id="user" name="user" class="form-control">
                            <option value="">(Selecione)</option>
                        </select>
                    </div>-->
                    <div class="col-md-1">
                        <button id="btn_search" name="save" class="btn btn-default">Buscar</button>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <table class="table table-bordered" id="postings-list">
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Ação</th>
                    <th>Usuário</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>
<script src="<?php echo ($site_url); ?>js/plugins/jquery-mask.js"></script>
<script src="<?php echo ($site_url); ?>js/forms/functions.js"></script>
<script src="<?php echo ($site_url); ?>js/forms/history.js"></script>
<?php
include '../footer.php';
?>
            
