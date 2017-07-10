<?php
include 'header.php';
?>
<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Usuários
        </h1>
        <ol class="breadcrumb">
            <li>
                <i class="fa fa-users"></i>  <a href="index.html">Usuários</a>
            </li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <form class="form-horizontal" action="<?php echo ($site_url); ?>API/users.php" method="POST">
            <fieldset>
                <legend id="form_legend">Novo</legend>
                <div class="alert alert-success" id="success-message" style="display: none;">
                    Salvo com sucesso
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label" for="username">Login</label>
                    <div class="col-md-2">
                        <input id="username" name="username" type="text" class="form-control input-md" required="">
                    </div>
                    <label class="col-md-2 control-label" for="id_role">Permissões</label>
                    <div class="col-md-2">
                        <select id="id_role" name="id_role" class="form-control">
                            <option value="">(Selecione)</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label" for="first_name">Primeiro Nome</label>
                    <div class="col-md-2">
                        <input id="first_name" name="first_name" type="text" class="form-control input-md" required="">
                    </div>
                    <label class="col-md-2 control-label" for="full_name">Nome Completo</label>
                    <div class="col-md-2">
                        <input id="full_name" name="full_name" type="text" class="form-control input-md" required="">
                    </div>
                </div>
                <!-- Button (Double) -->
                <div class="form-group">
                    <label class="col-md-6 control-label" for="save"></label>
                    <div class="col-md-2">
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
                <th>Login</th>
                <th>Nome</th>
                <th>Nome Completo</th>
                <th>Permissões</th>
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
<script src="<?php echo ($site_url); ?>js/forms/users.js"></script>
<?php
include 'footer.php';
?>
            
