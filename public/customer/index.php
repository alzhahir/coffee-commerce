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
        d.getMinutes(); // => 30
        d.getSeconds(); // => 51

        if(hn < 12){
            //morn
            wlc.innerText = "GOOD MORNING, <?php echo strtoupper($shortName)?>!"
        } else if (hn >= 12 && hn < 15){
            //
            wlc.innerText = "GOOD AFTERNOON, <?php echo strtoupper($shortName)?>!"
        } else if (hn > 15){
            wlc.innerText = "GOOD EVENING, <?php echo strtoupper($shortName)?>!"
        }
    })
</script>
<div class="px-3">
    <div>
        <h3 id="wlc" id="custPage" class="fw-black mb-2">YOUR ACCOUNT</h3>
        <?php 
            $_SESSION["backPage"] = $_SERVER["PHP_SELF"];
            //check if $_GET isset
            if(isset($_GET["error"])){
                if($_GET["error"] == "true"){
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
                } else if($_GET["error"] == "false"){
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
    </div>
    <ul class="nav nav-pills" id="custTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="rounded-pill nav-link ahvpill active" role="tab" id="maintab" data-bs-toggle="pill" aria-controls="mainp" aria-current="page" href="#mainp">Home</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="rounded-pill nav-link ahvpill" role="tab" id="ordertab" data-bs-toggle="pill" aria-controls="orderp" href="#orderp">Orders</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="rounded-pill nav-link ahvpill" role="tab" id="prefstab" data-bs-toggle="pill" aria-controls="prefsp" href="#prefsp">Preferences</a>
        </li>
    </ul>
    <!-- Tabs content -->
    <div class="tab-content pt-2" id="custTabContent">
        <div class="tab-pane fade show active" id="mainp" role="tabpanel" aria-labelledby="maintab">
            <div class='pb-5'>
                <p class="fw-black fs-4 mt-2">HOME</p>
                <span class="fs-5">Here, you can view your orders and purchase history. Start by selecting the tabs above, or choose the options below.</span>
                <div class="mt-3">
                    <span class="fw-black fs-5">QUICK ACTIONS</span>
                    <div class="row ps-3">
                        <div class="d-flex col col-sm-2 col-xs-2 ps-0">
                            <a class="d-flex w-100 text-reset text-decoration-none" href="/shop.php">
                                <div class="p-2 w-100 border rounded-4" style="background-color:#FA3F3F50;border-color:#FA3F3FA0!important;">
                                    <p class="fw-bold text-center">BROWSE PRODUCTS</p>
                                    <span class="d-flex justify-content-center mx-auto material-symbols-outlined" style="font-size:64px;">
                                        storefront
                                    </span>
                                </div>
                            </a>
                        </div>
                        <div class="d-flex col col-sm-2 col-xs-2 ps-0">
                            <a class="d-flex w-100 text-reset text-decoration-none" href="/cart.php">
                                <div class="p-2 w-100 border rounded-4" style="background-color:#FA3F3F50;border-color:#FA3F3FA0!important;">
                                    <p class="fw-bold text-center">VIEW YOUR CART</p>
                                    <span class="d-flex justify-content-center mx-auto material-symbols-outlined" style="font-size:64px;">
                                        shopping_cart
                                    </span>
                                </div>
                            </a>
                        </div>
                        <div class="d-flex col col-sm-2 col-xs-2 ps-0">
                            <a class="d-flex w-100 text-reset text-decoration-none" onclick='function a (){$("[href=\"#orderp\"]").tab("show");} a()' href="javascript:void(0)">
                                <div class="p-2 w-100 border rounded-4" style="background-color:#FA3F3F50;border-color:#FA3F3FA0!important;">
                                    <p class="fw-bold text-center">VIEW YOUR ORDERS</p>
                                    <span class="d-flex justify-content-center mx-auto material-symbols-outlined" style="font-size:64px;">
                                        order_play
                                    </span>
                                </div>
                            </a>
                        </div>
                        <div class="d-flex col col-sm-2 col-xs-2 ps-0">
                            <a class="d-flex w-100 text-reset text-decoration-none" onclick='function a (){$("[href=\"#prefsp\"]").tab("show");} a()' href="javascript:void(0)">
                                <div class="p-2 w-100 border rounded-4" style="background-color:#FA3F3F50;border-color:#FA3F3FA0!important;">
                                    <p class="fw-bold text-center">EDIT PROFILE</p>
                                    <span class="d-flex justify-content-center mx-auto material-symbols-outlined" style="font-size:64px;">
                                        settings_account_box
                                    </span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="orderp" role="tabpanel" aria-labelledby="ordertab">
            <div class='pb-4'>
                <span class="fw-black fs-4">ORDERS</span>
                <div class="mx-3 px-4 py-4 bg-white rounded-4 shadow">
                    <div class="row justify-content-start mb-3">
                        <div class="col-sm-4 col-md-3 form-floating">
                            <input id="minDate" class="form-control" name="minDate" type="text" placeholder="Start Date" required/>
                            <label class="ps-4" for="mindate">
                                <span class="material-symbols-outlined align-middle text-center pb-1">
                                    date_range
                                </span>
                                Start Date
                            </label>
                        </div>
                        <div class="col-sm-auto my-3 px-0 position-relative">
                            <span class="d-none d-sm-block material-symbols-outlined align-middle text-center position-absolute top-50 start-50 translate-middle">
                            navigate_next
                            </span>
                            <span class="d-block d-sm-none material-symbols-outlined align-middle text-center position-absolute top-50 start-50 translate-middle">
                            expand_more
                            </span>
                        </div>
                        <div class="col-sm-4 col-md-3 form-floating">
                            <input id="maxDate" class="form-control" name="maxDate" type="text" placeholder="End Date" required/>
                            <label class="ps-4" for="maxDate">
                                <span class='align-middle text-center px-0'>
                                    <span class="material-symbols-outlined align-middle text-center pb-1">
                                        calendar_month
                                    </span>
                                    End Date
                                </span>
                            </label>
                        </div>
                    </div>
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
            <p class="fw-black fs-4 mt-2">PREFERENCES</p>
            <span class="fs-5">Here, you can edit some of your information. Some information such as gender and date of birth cannot be edited.</span>
            <form id="editUsrForm" action="/api/user/update/user.php" method="post">
                <div class="form-floating mb-3">
                    <input id="edUsrName" class="form-control" name="name" type="text" value="<?php echo $_SESSION["name"] ?>" placeholder="User Name" required/>
                    <label for="name">User Name</label>
                </div>
                <div class="form-floating mb-3">
                    <input id="edUsrEmail" class="form-control" name="email" type="text" value="<?php echo $_SESSION["email"] ?>" placeholder="User Email" required/>
                    <label for="email">User Email</label>
                </div>
                <div class="form-floating mb-3">
                    <input id="edUsrPhone" class="form-control" name="phone" type="text" value="<?php echo $_SESSION["tel"] ?>" placeholder="User Phone" required/>
                    <label for="phone">User Phone</label>
                </div>
                <button class="btn btn-primary ahvbutton" form="editUsrForm" type="submit">Save changes</button>
            </form>
        </div>
    </div>
    <!-- Tabs content -->
</div>

<!-- MODAL FOR VIEWING ORDER DETAILS -->
<div class="modal fade" id="viewOrd" tabindex="-1" aria-labelledby="viewOrder" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-fullscreen-md-down modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fw-black" id="viewOrder">VIEW ORDER</h3>
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
                    <div id="custReceipt">
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
                                    <th>Item Temperature</th>
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
            </div>
            <div class="modal-footer">
                <button id="printBtn" type="button" class="me-auto btn btn-outline-secondary border-0 rounded-pill" onclick="printContent()" style="display:none;">Print</button>
                <button type="button" class="btn btn-outline-danger border-0 rounded-pill closeViewItm" data-bs-dismiss="modal">Close</button>
                <div id='ordPayNow'></div>
            </div>
        </div>
    </div>
</div>

<?php
include('../../internal/footer.php');
?>