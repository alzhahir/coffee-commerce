<?php
    $SERVERROOT = $_SERVER["DOCUMENT_ROOT"];
    $PROJECTROOT = $_SERVER["DOCUMENT_ROOT"] . '/..';
    ob_start();
    $included = true;
    include $SERVERROOT . "/api/get/categories.php";
    $included = false;
    $catData = $outputCatArr;
    $iteration = 0;
?>

<?php
    foreach($catData as $currCat){
        switch($currCat[2]){
            case null:
                $prodImgUrl = "https://openclipart.org/image/800px/194077";
                break;
            case !null:
                $prodImgUrl = $currCat[2];
                break;
            default:
                $prodImgUrl = "https://openclipart.org/image/800px/194077";
                break;
        }
        ?>
        <div class="col w-100 align-items-center justify-content-center align-middle text-center <?php if(str_contains($_SERVER["REQUEST_URI"], "shop.php")){echo "pb-3";} ?>" style="display:inline-block;min-width:170px!important;max-width:200px!important;">
            <div class="flex-row bd-placeholder-img bd-placeholder-img-lg rounded-5">
                <img src='<?php echo $prodImgUrl ?>' class="ratio ratio-1x1 img-fluid rounded-5"></img>
            </div>
            <!--svg class="flex-row bd-placeholder-img bd-placeholder-img-lg rounded-5" width="200" height="200" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: First slide" preserveAspectRatio="xMidYMid slice" focusable="false">
                <title>Placeholder</title>
                <rect width="100%" height="100%" fill="#777"></rect>
                <text x="50%" y="50%" fill="#555" dy=".3em">First slide</text>
            </svg-->
            <div id="prodNameLabel" title="<?php echo($currCat[1])?>" class="user-select-none flex-row fw-bold fs-5 pt-2" style="text-overflow:ellipsis;overflow:hidden;white-space:nowrap;"><?php echo($currCat[1])?></div>
            <button id="prodShoppingBtn" data-value="<?php echo($currCat[0]); ?>" onclick="window.location.href = '/shop.php?category='+this.dataset.value" class="w-100 btn btn-primary ahvbutton flex-row fw-normal rounded-pill fs-5 align-middle text-center border-0 px-1 py-2 prodShoppingBtn">
                <span class="material-symbols-outlined align-middle text-center px-0">
                    restaurant_menu
                </span>
                Browse
            </button>
        </div>
    <?php
    $iteration++;
    }
?>