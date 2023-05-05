<?php
    $SERVERROOT = $_SERVER["DOCUMENT_ROOT"];
    $PROJECTROOT = $_SERVER["DOCUMENT_ROOT"] . '/..';
    ob_start();
    $included = true;
    include $SERVERROOT . "/api/get/products.php";
    $included = false;
    $prodData = $outputProdArr;
    $iteration = 0;
?>

<?php
    foreach($prodData as $currProd){
        ?>
        <div class="col w-100 align-items-center justify-content-center align-middle text-center" style="display:inline-block;width:224px!important;">
            <svg class="flex-row bd-placeholder-img bd-placeholder-img-lg rounded-5" width="200" height="200" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: First slide" preserveAspectRatio="xMidYMid slice" focusable="false">
                <title>Placeholder</title>
                <rect width="100%" height="100%" fill="#777"></rect>
                <text x="50%" y="50%" fill="#555" dy=".3em">First slide</text>
            </svg>
            <div id="prodNameLabel" title="<?php echo($currProd[1])?>" class="user-select-none flex-row fw-bold fs-4 pt-2" style="text-overflow:ellipsis;overflow:hidden;white-space:nowrap;"><?php echo($currProd[1])?></div>
            <div id="prodPriceLabel" class="user-select-none flex-row fw-normal fs-4 pb-2"><?php echo("RM" . $currProd[3])?></div>
        <?php
            if($currProd[4] > 0){
        ?>
            <button id="prodShoppingBtn" data-value="<?php echo($currProd[0]); ?>" class="btn btn-primary ahvbutton flex-row fw-normal rounded-pill fs-4 align-middle text-center border-0 px-4 py-2">
                <span class="material-symbols-outlined align-middle text-center px-0">
                    add_shopping_cart
                </span>
                Add to Cart
            </button>
        <?php
            } else {
        ?>
            <button data-value="0" class="btn btn-primary ahvbutton flex-row fw-normal rounded-pill fs-4 align-middle text-center border-0 px-4 py-2" disabled>
                <span class="material-symbols-outlined align-middle text-center px-0">
                    add_shopping_cart
                </span>
                Out of Stock
            </button>
        <?php
            }
        ?>
        </div>
    <?php
    $iteration++;
    }
?>