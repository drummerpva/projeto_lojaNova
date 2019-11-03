<?php foreach ($subs as $sub) {
    ?>
    <option <?php echo ($category == $sub['Id'])?"selected":"";?> value="<?php echo $sub['Id']; ?>">
        <?php
        for ($q = 0; $q < $level; $q++)
            echo "-- ";
        echo $sub['name'];
        ?>
    </option>
    <?php
    if (count($sub['subs'])) {
        $this->loadView("menuSubcategorySelect", [
            "subs" => $sub['subs'],
            "level" => $level + 1,
            "category" => $category ?? ""
        ]);
    }
    ?>
    <?php
}
?>