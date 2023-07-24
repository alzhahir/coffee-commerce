<?php
    $SERVERROOT = $_SERVER["DOCUMENT_ROOT"];
    $PROJECTROOT = $_SERVER["DOCUMENT_ROOT"] . '/..';
    ob_start();
    $included = true;
    include_once $SERVERROOT . "/api/get/products.php";
    $included = false;
    $prodData = $outputProdArr;
    $iteration = 0;
?>

<?php
    foreach($prodData as $currProd){
        $outputPills = "";
        switch($currProd[5]){
            case 1:
                $outputPills = '
                <span class="user-select-none fs-6 align-items-center justify-content-center align-middle text-center badge rounded-pill bg-secondary">
                    HOT
                    <span class="visually-hidden">Temperature Hot</span>
                </span>';
                break;
            case 2:
                $outputPills = '
                <span class="user-select-none fs-6 align-items-center justify-content-center align-middle text-center badge rounded-pill bg-secondary">
                    COLD
                    <span class="visually-hidden">Temperature Cold</span>
                </span>';
                break;
            case 3:
                $outputPills = '
                <span class="user-select-none fs-6 align-items-center justify-content-center align-middle text-center badge rounded-pill bg-secondary">
                    HOT
                    <span class="visually-hidden">Temperature Hot</span>
                </span>
                <span class="user-select-none fs-6 align-items-center justify-content-center align-middle text-center badge rounded-pill bg-secondary">
                    COLD
                    <span class="visually-hidden">Temperature Cold</span>
                </span>';
                break;
            default:
                $outputPills = "";
                break;
        }
        switch($currProd[2]){
            case null:
                $prodImgUrl = "https://openclipart.org/image/800px/194077";
                break;
            case !null:
                $prodImgUrl = $currProd[2];
                break;
            default:
                $prodImgUrl = "https://openclipart.org/image/800px/194077";
                break;
        }
        ?>
        <div class="col align-items-center justify-content-center align-middle text-center <?php if(str_contains($_SERVER["REQUEST_URI"], "shop.php")){echo "pb-3";} ?>" style="display:inline-block;min-width:200px!important;max-width:230px!important;">
            <div class="flex-row bd-placeholder-img bd-placeholder-img-lg rounded-5">
                <img src='<?php echo $prodImgUrl ?>' class="img-fluid img-fluid-mobile rounded-5"></img>
            </div>
            <!--svg class="flex-row bd-placeholder-img bd-placeholder-img-lg rounded-5" width="200" height="200" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: First slide" preserveAspectRatio="xMidYMid slice" focusable="false">
                <title>Placeholder</title>
                <rect width="100%" height="100%" fill="#777"></rect>
                <text x="50%" y="50%" fill="#555" dy=".3em">First slide</text>
            </svg-->
            <div id="prodNameLabel" title="<?php echo($currProd[1])?>" class="user-select-none flex-row fw-bold fs-5 pt-2" style="text-overflow:ellipsis;overflow:hidden;white-space:nowrap;"><?php echo($currProd[1])?></div>
            <?php echo($outputPills) ?>
            <div id="prodPriceLabel" class="user-select-none flex-row fw-normal fs-5 pb-2"><?php echo("RM " . $currProd[3])?></div>
        <?php
            if($currProd[4] > 0){
        ?>
            <button id="prodShoppingBtn" data-temp="<?php echo($currProd[5]) ?>" data-value="<?php echo($currProd[0]); ?>" onclick="openProductModal(this.dataset.value, this.dataset.temp)" class="w-100 btn btn-primary ahvbutton flex-row fw-normal rounded-pill fs-5 align-middle text-center border-0 px-4 py-2 prodShoppingBtn">
                <span class="material-symbols-outlined align-middle text-center px-0">
                    add_shopping_cart
                </span>
                Add to Cart
            </button>
        <?php
            } else {
        ?>
            <button data-value="0" class="w-100 btn btn-primary ahvbutton flex-row fw-normal rounded-pill fs-5 align-middle text-center border-0 px-4 py-2" disabled>
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
    if($iteration == 0){
        echo "No products in this category was found.";
    }
?>