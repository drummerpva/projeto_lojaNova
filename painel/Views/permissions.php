<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Permissões
        <small>Gerencie as permissões dos usuários</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
    </ol>
</section>

<!-- Main content -->
<section class="content container-fluid">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Grupos de Permissões</h3>
            <div class="box-tools">
                <a href="<?php echo BASE_URL . "permissions/items" ?>" class="btn btn-primary">Itens de Permissão</a>
                <a href="<?php echo BASE_URL . "permissions/add" ?>" class="btn btn-success">Adicionar</a>
            </div>
        </div>
        <div class="box-body">
            <table class="table">
                <tr>
                    <th>Grupo de permissão</th>
                    <th width="150">Qtd. de ativos</th>
                    <th width="130">Ações</th>
                </tr>
                <?php foreach ($list as $l) {
                    ?>
                    <tr>
                        <td><?php echo $l['name']; ?></td>
                        <td><?php echo $l['totalUsers']; ?></td>
                        <td>
                            <div class="btn-group">
                                <a href="<?php echo BASE_URL . "permissions/edit/" . $l['Id']; ?>" class="btn btn-xs btn-primary">Editar</a>
                                <a href="<?php echo BASE_URL . "permissions/del/" . $l['Id']; ?>" class="btn btn-xs btn-danger <?php echo ($l['totalUsers']) ? "disabled" : ""; ?>">Excluir</a>
                            </div>
                        </td>
                    </tr>
                    <?php
                }
                ?>                
            </table>
        </div>
    </div>


</section>
<!-- /.content -->
