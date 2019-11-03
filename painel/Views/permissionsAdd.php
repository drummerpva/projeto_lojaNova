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
    <form method="POST" action="<?php echo BASE_URL . "permissions/addAction"; ?>">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Novo Grupo de Permissão</h3>
                <div class="box-tools">
                    <input type="submit" class="btn btn-success" value="Salvar"/>
                </div>
            </div>
            <div class="box-body">
                <div class="form-group <?php echo ($error) ? "has-error":"";?>">
                    <label for="gName">Nome do Grupo</label>
                    <input type="text" name="name" id="gName" require class="form-control"/>
                </div>
                <hr/>
                <?php foreach ($permissionItems as $p) {
                    ?>
                <div class="form-group">
                    <input id="item<?php echo $p['Id'];?>" type="checkbox" name="items[]" value="<?php echo $p['Id'];?>"/>
                    <label for="item<?php echo $p['Id'];?>" ><?php echo $p['name'];?></label>
                </div>
                    
                    <?php
                }
                ?>
            </div>
        </div>
    </form>

</section>
<!-- /.content -->
