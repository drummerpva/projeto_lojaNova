<?php foreach ($items as $l) {
    ?>
    <tr>
        <td><?php
            for ($q = 0; $q < $level; $q++)
                echo "--";
            echo $l['name'];
            ?>
        </td>
        <td>
            <div class="btn-group">
                <a href="<?php echo BASE_URL . "categories/edit/" . $l['Id']; ?>" class="btn btn-xs btn-primary">Editar</a>
                <a href="<?php echo BASE_URL . "categories/del/" . $l['Id']; ?>" class="btn btn-xs btn-danger">Excluir</a>
            </div>
        </td>
    </tr>
    <?php
    if (count($l['subs']) > 0) {
        $this->loadView('categoriesItem', [
            'items' => $l['subs'],
            'level' => $level + 1
        ]);
    }
}
?>