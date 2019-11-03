<?php foreach ($subs as $sub) {
    ?>
    <li>
        <a href="<?php echo BASE_URL . "categories/enter/" . $sub['Id']; ?>">
            <?php
            for ($q = 0; $q < $level; $q++)
                echo "-- ";
            echo $sub['name'];
            ?>
        </a>
    </li>
    <?php
    if (count($sub['subs'])) {
        $this->loadView("menuSubcategory", [
            "subs" => $sub['subs'],
            "level" => $level + 1
        ]);
    }
    ?>
    <?php
}
?>