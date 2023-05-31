<?php
    session_start();
    $PROJECTROOT = $_SERVER["DOCUMENT_ROOT"] . '/..';
    if(str_contains($_SERVER["REQUEST_URI"], "payment.php")){
        ?>
        <div style="display:table;">
            <span class="material-symbols-outlined" style="display:table-cell;vertical-align:middle;">
                warning
            </span>
            <span class="ps-2" style="font-size:18px;display:table-cell;vertical-align:middle;">Cart cannot be modified while on the payment page.</span>
        </div>
        <?php
        return;
    }
    $included = true;
    include($PROJECTROOT . '/public/api/user/get/cart.php');
    include($PROJECTROOT . '/public/api/get/products.php');
    $included = false;
    //outputProdArr are products, outputCartArr is cart
    if(!$noCart){
?>
<div id="miniCartObj">
    <div id="cartlabel" class="d-flex flex-row">
        <div class="col fw-bold">
            ITEM
        </div>
        <div class="col fw-bold text-end">
            QUANTITY
        </div>
    </div>
    <hr class="my-2">
    <?php
    //print_r($outputProdArr);
        foreach($outputCartArr[0][2] as $currCart){
    ?>
    <div id="itmrow" class="d-flex flex-row">
    <?php
        foreach($outputProdArr as $currProd){
            if($currProd[0] == $currCart[0]){
                ?>
                <div class="col fw-medium">
                    <?php echo($currProd[1]); ?>
                </div>
                <div class="col fw-medium text-end qtycol" style="float:right;">
                    <div style="display:inline-block;">
                        <button data-value="<?php echo($currProd[0]); ?>" class="btn btn-danger rounded-circle align-middle text-center border-0 px-0 qtybtnminus" style="width:36px;height:36px;" disabled>
                            <span class="material-symbols-outlined align-middle text-center px-0">
                                remove
                            </span>
                        </button>
                    </div>
                    <input id="itmMcart" data-id="<?php echo($currProd[0]); ?>" type="text" value="<?php echo($currCart[1]); ?>" min="0" max="99" class="form-control ms-auto qtynum" style="width:50px;display:inline-block;" disabled>
                    <div style="display:inline-block;">
                        <button data-value="<?php echo($currProd[0]); ?>" class="btn btn-success rounded-circle align-middle text-center border-0 px-0 qtybtnplus" style="width:36px;height:36px;">
                            <span class="material-symbols-outlined align-middle text-center px-0">
                                add
                            </span>
                        </button>
                    </div>
                </div>
                <?php
            }
        }
    ?>
    </div>
    <?php
        }
    ?>
    <hr class="my-2">
    <div class="">
        <button class="float-end btn btn-primary ahvbutton align-middle text-center border-0 px-2 tocartbtn">
            <span class="material-symbols-outlined align-middle text-center px-0">
                shopping_cart_checkout
            </span>
            To Your Cart
        </button>
    </div>
</div>
<?php
 } else {
    ?>
    <div style="display:table;">
        <span class="material-symbols-outlined" style="display:table-cell;vertical-align:middle;">
            remove_shopping_cart
        </span>
        <span class="ps-2" style="font-size:18px;display:table-cell;vertical-align:middle;">Your Cart is empty!</span>
    </div>
    <?php
}
    $included = false;
?>