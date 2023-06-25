<?php
session_start();
$pageTitle = "Ahvelo Coffee - Checkout";
include('../../internal/custcontrol.php');
include('../../internal/htmlhead.php');
include('../../internal/header.php');
$shortName = strtok($_SESSION["name"], " ");
?>
<div class="px-3 ">
    <?php //include('../internal/notimp.php') ?>
    <script type="text/javascript">
        $(document).ready( function () {
            createCheckoutTable();
        });
    </script>
    <div class="mx-2 px-4 py-4 bg-white rounded-4 shadow">
        <h3 class="fw-black">CHECKOUT</h3>
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
            <div class="row d-flex justify-content-end">
                <h5 class="col fw-bold">TAX (6%): </h5>
                <span class="col text-end fw-bold fs-5 pe-1">RM</span>
                <span class="col col-md-1 text-end fw-bold fs-5 ps-1" id="taxTotal">0.00</span>
            </div>
            <div class="row d-flex justify-content-end">
                <h3 class="col fw-black">TOTAL: </h3>
                <span class="col text-end fw-bold fs-3 pe-1">RM</span>
                <span class="col col-md-1 text-end fw-bold fs-3 ps-1" id="totalSum">0.00</span>
            </div>
        </div>
    </div>
    <div class="row d-flex">
        <div class="col justify-content-start">
            <button class="my-4 ms-2 float-start btn btn-lg btn-outline-danger rounded-pill backCartBtn">
                <span class="material-symbols-outlined align-middle text-center px-0">
                    shopping_cart
                </span>    
                Your Cart
            </button>
        </div>
        <div class="col justify-content-end">
            <button class="my-4 me-2 float-end btn btn-lg btn-success rounded-pill continueCheckoutBtn">
                <span class="material-symbols-outlined align-middle text-center px-0">
                    arrow_forward
                </span>    
                Continue
            </button>
        </div>
    </div>
</div>
<?php
include('../../internal/footer.php');
?>