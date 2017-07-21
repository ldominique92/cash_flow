<?php
include '../header.php';
?>
<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Novo Lançamento
        </h1>
        <ol class="breadcrumb">
            <li>
                <i class="fa fa-table"></i>  <a href="index.html">Fluxo de Caixa</a>
            </li>
            <li class="active">
                Novo Lançamento
            </li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        <form class="form-horizontal" action="<?php echo ($site_url); ?>API/postings.php" method="POST">
            <div class="alert alert-success" id="success-message" style="display: none;">
                Adicionado com sucesso
            </div>
            <div class="alert alert-warning" id="error-message" style="display: none;">
            </div>
            <!-- Text input-->
            <div class="form-group">
                <label class="col-md-4 control-label" for="description">Descrição</label>
                <div class="col-md-6">
                    <input id="description" name="description" type="text" placeholder="" class="form-control input-md" required="">
                </div>
            </div>
            <!-- Multiple Radios (inline) -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="money_signal">Entrada ou saída</label>
                <div class="col-md-4">
                    <label class="radio-inline" for="in">
                        <input type="radio" name="money_signal" id="money_signal_in" value="+" checked="checked">
                        Entrada
                    </label>
                    <label class="radio-inline" for="radios-1">
                        <input type="radio" name="money_signal" id="money_signal_out" value="-">
                        Saída
                    </label>
                </div>
            </div>
            <!-- Text input-->
            <div class="form-group">
                <label class="col-md-4 control-label" for="money_value">Valor R$</label>
                <div class="col-md-6">
                    <input id="money_value" name="money_value" type="text" placeholder="" class="form-control input-md" required="">
                </div>
            </div>

            <!-- Select Basic -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="type">Tipo</label>
                <div class="col-md-6">
                    <select id="type" name="type" class="form-control">
                        <option value="">(Selecione)</option>
                    </select>
                </div>
            </div>

            <!-- Select Basic -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="costumer">Cliente/Fornecedor</label>
                <div class="col-md-6">
                    <select id="costumer" name="costumer" class="form-control">
                        <option value="">(Selecione)</option>
                    </select>
                </div>
            </div>

            <!-- Text input-->
            <div class="form-group">
                <label class="col-md-4 control-label" for="due_date">Data prevista</label>
                <div class="col-md-6">
                    <input id="due_date" name="due_date" type="text" placeholder="" class="form-control input-md" required="">
                </div>
            </div>
            <!-- File Button -->
            <div class="form-group" style="display: none;">
                <label class="col-md-4 control-label" for="receipt">Anexar comprovante</label>
                <div class="col-md-6">
                    <input id="receipt" name="receipt" class="input-file" type="file">
                </div>
            </div>

            <!-- Button (Double) -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="btn_save"></label>
                <div class="col-md-8">
                    <a href="date_search.php" id="btn_save" name="btn_save" class="btn btn-default">Salvar</a>
                    <button id="btn_clear" name="btn_clear" class="btn btn-danger">Limpar</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php
include '../form_plugins.php';
?>
<script src="<?php echo ($site_url); ?>js/forms/new_entry.js"></script>
<?php
include '../footer.php';
?>
            
