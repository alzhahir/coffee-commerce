<?php
session_start();
$ROOTPATH = $_SERVER["DOCUMENT_ROOT"] . '/..';
include($ROOTPATH . '/internal/admincontrol.php');
include($ROOTPATH . '/internal/htmlhead.php');
include($ROOTPATH . '/internal/adminheader.php');
$shortName = "admin";
$shortName = strtok($_SESSION["name"], " ");
?>
<div class="px-3">
    <p class="h3 fw-black">ADMIN DASHBOARD</p>
    <div>
        <p id="wlc" class="fw-medium fs-5">WELCOME!</p>
    </div>
    <div class="mt-3">
        <p class="fs-5">The admin dashboard provides a more granular controls for administrators. Admins can edit product information, user account, as well as switch to the staff dashboard for more relevant functionalities. Use the quick actions below to quickly start.</p>
        <p class="fw-black fs-5">QUICK ACTIONS</p>
        <div class="row ps-3">
            <div class="d-flex col col-sm-2 col-xs-2 ps-0">
                <a class="d-flex w-100 text-reset text-decoration-none" href="/admin/products/index.php">
                    <div class="p-2 w-100 border rounded-4" style="background-color:#a6a6a650;border-color:#a6a6a6A0!important;">
                        <p class="fw-bold text-center">EDIT PRODUCT INFO</p>
                        <span class="d-flex justify-content-center mx-auto material-symbols-outlined" style="font-size:64px;">
                            edit_square
                        </span>
                    </div>
                </a>
            </div>
            <div class="d-flex col col-sm-2 col-xs-2 ps-0">
                <a class="d-flex w-100 text-reset text-decoration-none" href="/admin/users/index.php">
                    <div class="p-2 w-100 border rounded-4" style="background-color:#a6a6a650;border-color:#a6a6a6A0!important;">
                        <p class="fw-bold text-center">EDIT USER ACCOUNT</p>
                        <span class="d-flex justify-content-center mx-auto material-symbols-outlined" style="font-size:64px;">
                            manage_accounts
                        </span>
                    </div>
                </a>
            </div>
            <div class="d-flex col col-sm-2 col-xs-2 ps-0">
                <a class="d-flex w-100 text-reset text-decoration-none" href="/staff/orders/index.php">
                    <div class="p-2 w-100 border rounded-4" style="background-color:#a6a6a650;border-color:#a6a6a6A0!important;">
                        <p class="fw-bold text-center">VIEW LATEST ORDERS</p>
                        <span class="d-flex justify-content-center mx-auto material-symbols-outlined" style="font-size:64px;">
                            order_approve
                        </span>
                    </div>
                </a>
            </div>
            <?php
                if($_SESSION['utype'] == 'admin'){
                    ?>
                    <div class="d-flex col col-sm-2 col-xs-2 ps-0">
                        <a class="d-flex w-100 text-reset text-decoration-none" href="/staff/index.php">
                            <div class="p-2 w-100 border rounded-4" style="background-color:#a6a6a650;border-color:#a6a6a6A0!important;">
                                <p class="fw-bold text-center">SWITCH DASHBOARD</p>
                                <span class="d-flex justify-content-center mx-auto material-symbols-outlined" style="font-size:64px;">
                                    switch_account
                                </span>
                            </div>
                        </a>
                    </div>
                    <?php
                }
            ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    var d = new Date(); // for now
    hn = d.getHours(); // => 9
    d.getMinutes(); // =>  30
    d.getSeconds(); // => 51

    if(hn < 12){
        
        //morn
        txt = "Good Morning, <?php echo ucfirst($shortName)?>!"
    } else if (hn >= 12 && hn < 15){
        //
        txt = "Good Afternoon, <?php echo ucfirst($shortName)?>!"
    } else if (hn > 15){
        txt = "Good Evening, <?php echo ucfirst($shortName)?>!"
    }

    wlc.innerText=txt
</script>
<?php
include($ROOTPATH . '/internal/footer.php');
?>