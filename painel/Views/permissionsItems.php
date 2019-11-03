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
            <h3 class="box-title">Itens de Permissões</h3>
            <div class="box-tools">
                <a href="<?php echo BASE_URL . "permissions/itemsAdd" ?>" class="btn btn-success">Adicionar</a>
            </div>
        </div>
        <div class="box-body">
            <table class="table">
                <tr>
                    <th>Nome do item de permissão</th>
                    <th>Slug</th>
                    <th width="130">Ações</th>
                </tr>
                <?php foreach ($list as $l) {
                    ?>
                    <tr>
                        <td><?php echo $l['name']; ?></td>
                        <td><?php echo $l['slug']; ?></td>
                        <td>
                            <div class="btn-group">
                                <a href="<?php echo BASE_URL . "permissions/itemsEdit/" . $l['Id']; ?>" class="btn btn-xs btn-primary">Editar</a>
                                <a href="<?php echo BASE_URL . "permissions/itemsDel/" . $l['Id']; ?>" class="btn btn-xs btn-danger">Excluir</a>
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
