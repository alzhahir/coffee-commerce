<?php
$SERVERROOT = $_SERVER["DOCUMENT_ROOT"];
$PROJECTROOT = $_SERVER["DOCUMENT_ROOT"] . '/..';
$pageTitle = "Ahvelo Coffee - Shop";
session_start();
include($PROJECTROOT . '/internal/htmlhead.php');
include($PROJECTROOT . '/internal/header.php');
$categoryGet = 0;
if(isset($_GET['category'])){
    $categoryGet = $_GET['category'];
}
$included = true;
include $SERVERROOT . "/api/get/categories.php";
$included = false;
?>
<div class="px-3 pb-3">
    <div class="px-2 h-100">
        <div class="fw-black row px-2 h2">SHOP</div>
        <div class="mb-3 mx-0 px-0 fs-5">Order now! You may also filter the items based on the categories listed below.</div>
        <div class="mb-3">
            <?php
                if(!isset($_GET['category'])){
            ?>
            <a class="btn btn-primary ahvbutton" href="/shop.php">All Products</a>
            <?php
                } else {
                    ?>
                    <a class="btn btn-outline-secondary rounded-pill" href="/shop.php">All Products</a>
                    <?php
                }
                foreach($catArr as $currCat){
                    if($categoryGet == $currCat[0]){
                        ?>
                        <a class="btn btn-primary ahvbutton" href="/shop.php?category=<?php echo $currCat[0] ?>"><?php echo $currCat[1] ?></a>
                        <?php
                    } else {
                        ?>
                        <a class="btn btn-outline-secondary rounded-pill" href="/shop.php?category=<?php echo $currCat[0] ?>"><?php echo $currCat[1] ?></a>
                        <?php
                    }
                }
            ?>
        </div>
        <div id="prodcat" class="d-flex justify-content-center row row-cols-auto align-items-start">
            <?php
                include($PROJECTROOT . '/internal/productgalleryobject.php');
            ?>
        </div>
    </div>
</div>
<?php
include($PROJECTROOT . '/internal/footer.php');
?>