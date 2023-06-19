<?php
session_start();
$pageTitle = "Ahvelo Coffee - Account Home";
include('../../internal/custcontrol.php');
include('../../internal/htmlhead.php');
include('../../internal/header.php');
$shortName = strtok($_SESSION["name"], " ");
?>
<script>
    $(document).ready(function(){
        custOrder();
        var d = new Date(); // for now
        hn = d.getHours(); // => 9
        d.getMinutes(); // =>  30
        d.getSeconds(); // => 51
        txt = 'YOUR ACCOUNT'

        if(hn < 12){
            //morn
            txt = "GOOD MORNING, <?php echo strtoupper($shortName)?>!"
        } else if (hn >= 12 && hn < 15){
            //
            txt = "GOOD AFTERNOON, <?php echo strtoupper($shortName)?>!"
        } else if (hn > 15){
            txt = "GOOD EVENING, <?php echo strtoupper($shortName)?>!"
        }

        wlc.innerText=txt
    })
</script>
<div class="px-3">
    <div>
        <h3 id="wlc" id="custPage" class="fw-black mb-2">YOUR ACCOUNT</h3>
    </div>
    <ul class="nav nav-pills" id="custTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="rounded-pill nav-link active" role="tab" id="maintab" data-bs-toggle="pill" aria-controls="mainp" aria-current="page" href="#mainp">Home</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="rounded-pill nav-link" role="tab" id="ordertab" data-bs-toggle="pill" aria-controls="orderp" href="#orderp">Orders</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="rounded-pill nav-link" role="tab" id="prefstab" data-bs-toggle="pill" aria-controls="prefsp" href="#prefsp">Preferences</a>
        </li>
    </ul>
    <!-- Tabs content -->
    <div class="tab-content pt-2" id="custTabContent">
        <div class="tab-pane fade show active" id="mainp" role="tabpanel" aria-labelledby="maintab">
            <div>
                <p class="fw-black fs-4 mt-2">HOME</p>
                <span class="fs-5">Here, you can view your orders and purchase history. Start by selecting the tabs above.</span>
            </div>
        </div>
        <div class="tab-pane fade" id="orderp" role="tabpanel" aria-labelledby="ordertab">
            <div class='pb-4'>
                <span class="fw-black fs-4">ORDERS</span>
                <div class="mx-3 px-4 py-4 bg-white rounded-4 shadow">
                    <table id="ordTable" class="table table-bordered table-hover dt-responsive">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Order Date</th>
                                <th>Order Time</th>
                                <th>Order Status</th>
                                <th>Order Total</th>
                                <th>Payment Method</th>
                                <th>Pay Now</th>
                                <th>View Details</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="prefsp" role="tabpanel" aria-labelledby="prefstab">
            Tab 3 content
        </div>
    </div>
    <!-- Tabs content -->
</div>

<!-- MODAL FOR VIEWING ORDER DETAILS -->
<div class="modal fade" id="viewOrd" tabindex="-1" aria-labelledby="viewOrder" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-fullscreen-md-down modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fw-black" id="viewOrder">VIEW DETAILS</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="col pb-3">
                    <p>You can use this table to view order details.</p>
                    <?php 
                        $_SESSION["backPage"] = $_SERVER["PHP_SELF"];
                        //check if $_GET isset
                        if(isset($_GET["prodstat"])){
                            if($_GET["prodstat"] == "error"){
                                //err
                                echo "<div class=\"alert alert-danger\">";
                                if(isset($_SESSION["userErrMsg"])){
                                    //get err msg
                                    $errMsg = $_SESSION["userErrMsg"];
                                    $errCode = $_SESSION["userErrCode"];
                                    echo "<h5 class=\"my-0 fw-semibold\" style=\"text-align: justify; text-justify: inter-word;\">$errMsg</h5>";
                                    echo "<p class=\"my-0 fst-italic fw-light\">Error code: $errCode</p>";
                                }
                                echo "</div>";
                            } else if($_GET["prodstat"] == "success"){
                                //noerr
                                echo "<div class=\"alert alert-success\">";
                                if(isset($_SESSION["userErrMsg"])){
                                    //get err msg
                                    $errMsg = $_SESSION["userErrMsg"];
                                    $errCode = $_SESSION["userErrCode"];
                                    echo "<h5 class=\"my-0 fw-semibold\" style=\"text-align: justify; text-justify: inter-word;\">$errMsg</h5>";
                                }
                                echo "</div>";
                            } else {
                                //echo "Test lol";
                            }
                        }
                    ?>
                    <div class="row d-flex justify-content-end">
                        <h5 class="col fw-bold">Order Date: </h5>
                        <span class="col text-end fw-bold fs-5 ps-1" id="ordDate"></span>
                    </div>
                    <div class="row d-flex justify-content-end">
                        <h5 class="col fw-bold">Order Time: </h5>
                        <span class="col text-end fw-bold fs-5 ps-1" id="ordTime"></span>
                    </div>
                    <table id="ordDetTable" class="table table-bordered table-hover dt-responsive">
                        <thead>
                            <tr>
                                <th>Item ID</th>
                                <th>Item Name</th>
                                <th>Item Quantity</th>
                                <th>Item Unit Price</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                    </table>
                    <div class="row d-flex justify-content-end">
                        <h5 class="col fw-bold">Status: </h5>
                        <span class="col text-end fw-bold fs-5 ps-1" id="ordStat"></span>
                    </div>
                    <div class="row d-flex justify-content-end">
                        <h5 class="col fw-bold">Payment Method: </h5>
                        <span class="col text-end fw-bold fs-5 ps-1" id="ordPMethod"></span>
                    </div>
                    <div class="row d-flex justify-content-end">
                        <h5 class="col fw-bold">Total: </h5>
                        <span class="col text-end fw-bold fs-5 ps-1" id="ordTot"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div id='ordPayNow'></div>
                <button type="button" class="btn btn-outline-danger border-0 rounded-pill closeViewItm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php
include('../../internal/footer.php');
?>