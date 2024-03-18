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

            $('.btnPayNow').on('click', function(){
                $('btn').prop('disabled', true);
                $('#disableInputModal').modal('show');
                order_send_method = $('input[name="paymentmethod"]:checked').val();
                $.post("/api/user/post/orders.php", {
                    paymethod: order_send_method,
                    items: t_items,
                    total: gl_total,
                })
                .done(function(res){
                    if(order_send_method == 0){
                        window.location.href = '/customer/order.php?order=success'
                    }
                    if(!(typeof res.data == undefined || res.data == null)){
                        window.location.href = res.data
                    } else {
                        window.location.href = '/customer/order.php?order=fail&error='+res.status
                    }
                })
                .fail(function(res){
                    window.location.href = '/customer/order.php?order=fail'
                })
            })
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
                <h5 class="col fw-bold">TOTAL: </h5>
                <span class="col text-end fw-bold fs-5 pe-1">RM</span>
                <span class="col col-md-1 text-end fw-bold fs-5 ps-1" id="totalSum">0.00</span>
            </div>
        </div>
        <hr>
        <div>
            <span class="fw-black fs-4">PAYMENT METHOD</span>
            <div class="form-check py-2">
                <input class="form-check-input" type="radio" name="paymentmethod" id="cashpayment" value="0" checked>
                <label class="form-check-label" for="cashpayment">
                    <span class="material-symbols-outlined align-middle text-center px-0">
                        payments
                    </span> 
                    In-store payment (Cash, DuitNow QR)
                </label>
            </div>
            <div class="form-check py-2">
                <input class="form-check-input" type="radio" name="paymentmethod" id="cardpayment" value="1">
                <label class="form-check-label" for="cardpayment">
                    <span class="material-symbols-outlined align-middle text-center px-0">
                        credit_card
                    </span>
                    Stripe (Credit/Debit Card)
                </label>
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
            <button class="my-4 me-2 float-end btn btn-lg btn-success rounded-pill btnPayNow">
                <span class="material-symbols-outlined align-middle text-center px-0">
                    payments
                </span>    
                Pay
            </button>
        </div>
    </div>
</div>
<div class="modal fade" id="disableInputModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="disableInputLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-3 fw-black" id="disableInputLabel">PROCESSING ORDER</h1>
            </div>
            <div class="modal-body">
                <div class="row d-flex justify-content-center">
                    <svg id="loadSpinner" class="spinnerCustom" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                        <circle class="pathCustom" fill="none" stroke-width="8" stroke-linecap="square" cx="50" cy="50" r="30"></circle>
                    </svg>
                </div>
                <div class="row d-flex justify-content-center align-middle pt-2">
                    <span class="fw-medium fs-5 align-middle text-center">Please wait while we process the order. Do not close, refresh, or press the back button.</span>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include('../../internal/footer.php');
?>