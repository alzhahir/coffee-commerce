<?php
session_start();
include('../../internal/custcontrol.php');
include('../../internal/htmlhead.php');
include('../../internal/header.php');
$shortName = strtok($_SESSION["name"], " ");
?>
<div class="px-3">
    <?php //include('../internal/notimp.php') ?>
    <script type="text/javascript">
        //order_items = order_items['data']
        //$(document).ready( function () {
        //    createCheckoutTable();
        //});
        $(document).ready(function(){
            try{
                order_items = JSON.parse(sessionStorage.getItem('cartitems'))
                console.log(order_items.data)
                for(let i = 0; i < order_items.data.length; i++){
                    $('#finalOrderTable').append('<tr class="py-2"><th scope="row" class="py-2 px-2">'+(i+1)+'</th><td hidden class="py-2 px-2">'+order_items.data[i][0]+'</td><td class="py-2 px-2">'+order_items.data[i][1]+'</td><td class="py-2 px-2">'+order_items.data[i][2]+'</td><td class="py-2 px-2">'+order_items.data[i][3]+'</td><td class="py-2 px-2">'+order_items.data[i][4]+'</td>')
                }
                subTotal.innerText = order_items.subtotal
                taxTotal.innerText = order_items.tax
                totalSum.innerText = order_items.total
            }catch(err){
                if(err instanceof SyntaxError /*typeof order_items === 'undefined'*/){
                    showItemRequiredModal()
                }
                if(err instanceof TypeError /*typeof order_items === 'undefined'*/){
                    showItemRequiredModal()
                }
            }
        })
    </script>
    <div class="mx-2 px-4 py-4 bg-white rounded-4 shadow">
        <h3 class="fw-black">YOUR ORDER</h3>
        <span class="">Please confirm your order</span>
        <table id="finalOrderTable" class="table me-5">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col" hidden>Product ID</th>
                    <th scope="col">Product Name</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Unit Price (RM)</th>
                    <th scope="col">Subtotal (RM)</th>
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
        <hr>
        <div>
            <span class="fw-black fs-4">PAYMENT METHOD</span>
            <div class="form-check py-2">
                <input class="form-check-input" type="radio" name="paymentmethod" id="cashpayment" checked>
                <label class="form-check-label" for="cashpayment">
                    <span class="material-symbols-outlined align-middle text-center px-0">
                        payments
                    </span> 
                    Cash in Store
                </label>
            </div>
            <div class="form-check py-2">
                <input class="form-check-input" type="radio" name="paymentmethod" id="cardpayment" disabled>
                <label class="form-check-label" for="cardpayment">
                    <span class="material-symbols-outlined align-middle text-center px-0">
                        credit_card
                    </span> 
                    Stripe
                </label>
            </div>
        </div>
    </div>
    <div class="row d-flex">
        <div class="col justify-content-start">
            <button class="my-4 ms-2 float-start btn btn-lg btn-outline-danger rounded-pill backCheckoutBtn">
                <span class="material-symbols-outlined align-middle text-center px-0">
                    arrow_back
                </span>    
                Back
            </button>
        </div>
        <div class="col justify-content-end">
            <button class="my-4 me-2 float-end btn btn-lg btn-success rounded-pill">
                <span class="material-symbols-outlined align-middle text-center px-0">
                    payments
                </span>    
                Pay
            </button>
        </div>
    </div>
</div>
<?php
include('../../internal/footer.php');
?>