<?php
session_start();
include('../internal/custcontrol.php');
include('../internal/htmlhead.php');
include('../internal/header.php');
?>
<div class="px-3 ">
    <h3 class="fw-black">YOUR CART</h3>
    <?php //include('../internal/notimp.php') ?>
    <script type="text/javascript">
        $(document).ready( function () {
            createCartTable();
        });
    </script>
    <div class="mx-5 px-4 py-4 bg-white rounded-4 shadow">
        <table id="cartTable" class="table table-bordered table-hover dt-responsive">
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<?php
include('../internal/footer.php');
?>