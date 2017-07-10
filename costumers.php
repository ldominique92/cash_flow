<?php
include 'header.php';
?>
<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Clientes e Fornecedores
        </h1>
        <ol class="breadcrumb">
            <li>
                <i class="fa fa-industry"></i>  <a href="index.html">Clientes e Fornecedores</a>
            </li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <form class="form-horizontal" action="<?php echo ($site_url); ?>API/costumers.php" method="POST">
            <fieldset>
                <legend id="form_legend">Novo</legend>
                <div class="alert alert-success" id="success-message" style="display: none;">
                    Salvo com sucesso
                </div>
                <div class="form-group">
                    <label class="col-md-1 control-label" for="name">Nome</label>
                    <div class="col-md-3">
                        <input id="name" name="name" type="text" placeholder="" class="form-control input-md" required="">
                    </div>
                    <label class="col-md-1 control-label" for="person_type">Pessoa</label>
                    <div class="col-md-2">
                        <label class="radio-inline" for="person_type_F">
                            <input type="radio" name="person_type" id="person_type_F" value="F" checked="checked">
                            Física
                        </label>
                        <label class="radio-inline" for="person_type_J">
                            <input type="radio" name="person_type" id="person_type_J" value="J">
                            Jurídica
                        </label>
                    </div>
                    <label class="col-md-1 control-label" for="cnpj" id="label_cpf">CPF</label>
                    <div class="col-md-3">
                        <input id="cnpj" name="cnpj" type="text" placeholder="" class="form-control input-md" required="">
                    </div>
                </div>
                <!-- Button (Double) -->
                <div class="form-group">
                    <label class="col-md-1 control-label" for="save"></label>
                    <div class="col-md-8">
                        <button id="btn_save" name="save" class="btn btn-default">Salvar</button>
                        <button id="btn_clear" name="clear" class="btn btn-danger">Limpar</button>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <table class="table" id="costumers-list">
            <thead>
            <tr>
                <th>#</th>
                <th>Nome</th>
                <th>Pessoa</th>
                <th>CPF/CNPJ</th>
                <th></th>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>
<script src="<?php echo ($site_url); ?>js/plugins/jquery-mask.js"></script>
<script src="<?php echo ($site_url); ?>js/forms/functions.js"></script>
<script src="<?php echo ($site_url); ?>js/forms/costumers.js"></script>
<?php
include 'footer.php';
?>
            
