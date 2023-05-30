<?php
session_start();
include('../../internal/custcontrol.php');
include('../../internal/htmlhead.php');
include('../../internal/header.php');
$shortName = strtok($_SESSION["name"], " ");
?>
<div class="px-3 ">
    <h3 class="fw-black">CHECKOUT</h3>
    <?php //include('../internal/notimp.php') ?>
    <script type="text/javascript">
        $(document).ready( function () {
            var checkoutTable = $('#cartTable').DataTable({
                                autoWidth: false,
                                ajax: {
                                    url: '/api/user/get/cart.php',
                                    dataSrc: 'data',
                                },
                                responsive: true,
                                columnDefs: [
                                    {
                                        targets: 0,
                                        visible: false,
                                    },
                                ],
                                //dom: 'Bfrtip',
                                buttons: [
                                    'print'
                                ],
                                language: {
                                    emptyTable: "Your Cart is empty"
                                },
                            });
            $("#cartTable tbody").on('click', 'button', function() {
                var data = checkoutTable.row($(this).parents('tr')).data();
            })
            new $.fn.dataTable.FixedHeader( checkoutTable );
            $('#cartTable').on('draw.dt', function(){
                checkoutTable.rows().every(function(){
                    curRow = this.columns(4).data()
                })
                total = 0.00
                curRow.each(function(index){
                    for(let i = 0; i < index.length; i++){
                        total = total + parseFloat(index[i])
                    }
                })
                subTotal.innerText = total.toFixed(2);
                tax = total*0.06
                taxTotal.innerText = tax.toFixed(2);
                finalTotal = total + tax
                totalSum.innerText = finalTotal.toFixed(2);
            })
        });
    </script>
    <div class="mx-2 px-4 py-4 bg-white rounded-4 shadow">
        <table id="cartTable" class="table table-bordered table-hover dt-responsive">
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Unit Price (RM)</th>
                    <th>Subtotal (RM)</th>
                </tr>
            </thead>
        </table>
        <div class="container">
            <div class="row d-flex justify-content-end">
                <h5 class="col fw-bold">SUBTOTAL: </h5>
                <span class="col col-md-auto text-end fw-bold fs-5 pe-1">RM</span>
                <span class="col col-md-auto text-end fw-bold fs-5 ps-1" id="subTotal">0.00</span>
            </div>
            <div class="row d-flex justify-content-end">
                <h5 class="col fw-bold">TAX (6%): </h5>
                <span class="col col-md-auto text-end fw-bold fs-5 pe-1">RM</span>
                <span class="col col-md-auto text-end fw-bold fs-5 ps-1" id="taxTotal">0.00</span>
            </div>
            <div class="row d-flex justify-content-end">
                <h3 class="col fw-black">TOTAL: </h3>
                <span class="col col-sm-auto text-end fw-bold fs-3 pe-1">RM</span>
                <span class="col col-sm-auto text-end fw-bold fs-3 ps-1" id="totalSum">0.00</span>
            </div>
        </div>
    </div>
    <div>
        <button class="my-4 me-2 float-end btn btn-lg btn-success rounded-pill continueCheckoutBtn">
            <span class="material-symbols-outlined align-middle text-center px-0">
                shopping_cart_checkout
            </span>    
            Checkout
        </button>
    </div>
</div>
<?php
include('../../internal/footer.php');
?>