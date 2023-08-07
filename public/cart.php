<?php
session_start();
$pageTitle = "Ahvelo Coffee - Your Cart";
include('../internal/custcontrol.php');
include('../internal/htmlhead.php');
include('../internal/header.php');
?>
<div class="px-3 ">
    <?php //include('../internal/notimp.php') ?>
    <script type="text/javascript">
        $(document).ready( function () {
            createCartTable();
        });
    </script>
    <div class="mx-2 px-4 py-4 bg-white rounded-4 shadow">
        <h3 class="fw-black">YOUR CART</h3>
        <table id="cartTable" class="table table-bordered table-hover dt-responsive">
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Temperature</th>
                    <th>Quantity</th>
                    <th>Unit Price (RM)</th>
                    <th>Subtotal (RM)</th>
                </tr>
            </thead>
        </table>
        <div>
            <div class="row d-flex justify-content-end">
                <h5 class="col fw-bold">SUBTOTAL: </h5>
                <span class="col text-end fw-bold fs-5 pe-1">RM</span>
                <span class="col col-md-1 text-end fw-bold fs-5 ps-1" id="subTotal">0.00</span>
            </div>
        </div>
    </div>
    <div>
        <button class="my-4 ms-2 float-start btn btn-lg btn-outline-success rounded-pill gotoShopBtn">
            <span class="material-symbols-outlined align-middle text-center px-0">
                add_shopping_cart
            </span>    
            Shop More
        </button>
        <button class="my-4 me-2 float-end btn btn-lg btn-success rounded-pill checkoutBtn">
            <span class="material-symbols-outlined align-middle text-center px-0">
                shopping_cart_checkout
            </span>    
            Checkout
        </button>
    </div>
</div>
<?php
include('../internal/footer.php');
?>