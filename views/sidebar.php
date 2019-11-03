<aside>
    <h1><?php $this->lang->get('FILTER'); ?></h1>
    <div class="filterarea">
        <form method="GET">
            <input type="hidden" name="s" value="<?php echo $viewData['searchTerm'] ?? ""; ?>"/>
            <input type="hidden" name="category" value="<?php echo $viewData['category'] ?? ""; ?>"/>

            <div class="filterBox">
                <div class="filterTitle"><?php $this->lang->get("BRANDS"); ?></div>
                <div class="filterContent">
                    <?php foreach ($viewData['filters']["brands"] as $brandItem) {
                        ?>
                        <div class="filterItem">
                            <input type="checkbox" <?php echo (!empty($viewData['filterSelected']['brand']) && in_array($brandItem['Id'], $viewData['filterSelected']['brand'])) ? "checked" : ""; ?> id="filterBrand<?php echo $brandItem['Id']; ?>" name="filter[brand][]" value="<?php echo $brandItem['Id']; ?>"/>
                            <label for="filterBrand<?php echo $brandItem['Id']; ?>">
                                <?php echo $brandItem['name']; ?>
                            </label>
                            <span style="float:right;">(<?php echo $brandItem['count']; ?>)</span>
                        </div> 
                        <?php
                    }
                    ?>
                </div>
            </div>
            <div class="filterBox">
                <div class="filterTitle"><?php $this->lang->get("PRICE"); ?></div>
                <div class="filterContent">
                    <input type="hidden" id="slider0" name="filter[slider0]" value="<?php echo $viewData['filters']['slider0']; ?>"/>    
                    <input type="hidden" id="slider1" name="filter[slider1]" value="<?php echo $viewData['filters']['slider1']; ?>"  />    
                    <input type="text" id="amount" readonly style="border:0; color:#f6931f; font-weight:bold;"> 
                    <div id="slider-range"></div>
                </div>
            </div>
            <div class="filterBox">
                <div class="filterTitle"><?php $this->lang->get("RATING"); ?></div>
                <div class="filterContent">
                    <div class="filterItem">
                        <input type="checkbox" <?php echo (!empty($viewData['filterSelected']['star']) && in_array("0", $viewData['filterSelected']['star'])) ? "checked" : ""; ?> id="filterStar0" name="filter[star][]" value="0"/>
                        <label for="filterStar0">
                            (<?php $this->lang->get("NOSTAR"); ?>)
                        </label>
                        <span style="float:right;">(<?php echo $viewData['filters']['stars']["0"]; ?>)</span>
                    </div>
                    <div class="filterItem">
                        <input type="checkbox" <?php echo (!empty($viewData['filterSelected']['star']) && in_array("1", $viewData['filterSelected']['star'])) ? "checked" : ""; ?> id="filterStar1" name="filter[star][]" value="1"/>
                        <label for="filterStar1">
                            <img src="<?php echo BASE_URL . "assets/images/star.png"; ?>" height="13"/>
                        </label>
                        <span style="float:right;">(<?php echo $viewData['filters']['stars']["1"]; ?>)</span>
                    </div>
                    <div class="filterItem">
                        <input type="checkbox" <?php echo (!empty($viewData['filterSelected']['star']) && in_array("2", $viewData['filterSelected']['star'])) ? "checked" : ""; ?> id="filterStar2" name="filter[star][]" value="2"/>
                        <label for="filterStar2">
                            <img src="<?php echo BASE_URL . "assets/images/star.png"; ?>" height="13"/>
                            <img src="<?php echo BASE_URL . "assets/images/star.png"; ?>" height="13"/>
                        </label>
                        <span style="float:right;">(<?php echo $viewData['filters']['stars']["2"]; ?>)</span>
                    </div>
                    <div class="filterItem">
                        <input type="checkbox" <?php echo (!empty($viewData['filterSelected']['star']) && in_array("3", $viewData['filterSelected']['star'])) ? "checked" : ""; ?> id="filterStar3" name="filter[star][]" value="3"/>
                        <label for="filterStar3">
                            <img src="<?php echo BASE_URL . "assets/images/star.png"; ?>" height="13"/>
                            <img src="<?php echo BASE_URL . "assets/images/star.png"; ?>" height="13"/>
                            <img src="<?php echo BASE_URL . "assets/images/star.png"; ?>" height="13"/>
                        </label>
                        <span style="float:right;">(<?php echo $viewData['filters']['stars']["3"]; ?>)</span>
                    </div>
                    <div class="filterItem">
                        <input type="checkbox" <?php echo (!empty($viewData['filterSelected']['star']) && in_array("4", $viewData['filterSelected']['star'])) ? "checked" : ""; ?> id="filterStar4" name="filter[star][]" value="4"/>
                        <label for="filterStar4">
                            <img src="<?php echo BASE_URL . "assets/images/star.png"; ?>" height="13"/>
                            <img src="<?php echo BASE_URL . "assets/images/star.png"; ?>" height="13"/>
                            <img src="<?php echo BASE_URL . "assets/images/star.png"; ?>" height="13"/>
                            <img src="<?php echo BASE_URL . "assets/images/star.png"; ?>" height="13"/>
                        </label>
                        <span style="float:right;">(<?php echo $viewData['filters']['stars']["4"]; ?>)</span>
                    </div>
                    <div class="filterItem">
                        <input type="checkbox" <?php echo (!empty($viewData['filterSelected']['star']) && in_array("5", $viewData['filterSelected']['star'])) ? "checked" : ""; ?> id="filterStar5" name="filter[star][]" value="5"/>
                        <label for="filterStar5">
                            <img src="<?php echo BASE_URL . "assets/images/star.png"; ?>" height="13"/>
                            <img src="<?php echo BASE_URL . "assets/images/star.png"; ?>" height="13"/>
                            <img src="<?php echo BASE_URL . "assets/images/star.png"; ?>" height="13"/>
                            <img src="<?php echo BASE_URL . "assets/images/star.png"; ?>" height="13"/>
                            <img src="<?php echo BASE_URL . "assets/images/star.png"; ?>" height="13"/>
                        </label>
                        <span style="float:right;">(<?php echo $viewData['filters']['stars']["5"]; ?>)</span>
                    </div>
                </div>
            </div>
            <div class="filterBox">
                <div class="filterTitle"><?php $this->lang->get("SALE"); ?></div>
                <div class="filterContent">
                    <div class="filterItem">
                        <input type="checkbox" <?php echo (!empty($viewData['filterSelected']['sale']) && $viewData['filterSelected']['sale'] == "on") ? "checked" : ""; ?> id="filterSale" name="filter[sale]"/>
                        <label for="filterSale">
                            Em Promoção
                        </label>
                        <span style="float:right;">(<?php echo $viewData['filters']['sale']; ?>)</span>
                    </div>
                </div>
            </div>
            <div class="filterBox">
                <div class="filterTitle"><?php $this->lang->get("OPTIONS"); ?></div>
                <div class="filterContent">
                    <?php foreach ($viewData['filters']['options'] as $opt) {
                        ?>
                        <b><?php echo $opt['name']; ?></b><br/>
                        <?php foreach ($opt['options'] as $op) {
                            ?>
                            <div class="filterItem">
                                <input type="checkbox" <?php echo (!empty($viewData['filterSelected']['options']) && in_array($op['value'], $viewData['filterSelected']['options'])) ? "checked" : ""; ?> id="filterOptions<?php echo $op['value']; ?>" name="filter[options][]" value="<?php echo $op['value']; ?>"/>
                                <label for="filterOptions<?php echo $op['value']; ?>">
                                    <?php echo $op['value']; ?>
                                </label>
                                <span style="float:right;">(<?php echo $op['count']; ?>)</span>
                            </div>

                            <?php
                        }
                        ?>
                        <br/>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </form>
    </div>

    <div class="widget">
        <h1><?php $this->lang->get('FEATUREDPRODUCTS'); ?></h1>
        <div class="widget_body">
            <?php $this->loadView('widget_item', ["list" => $viewData['widget_featured1']]); ?>
        </div>
    </div>
</aside>