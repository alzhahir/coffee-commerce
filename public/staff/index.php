<?php
session_start();
include('../../internal/staffcontrol.php');
include('../../internal/htmlhead.php');
include('../../internal/staffheader.php');
$shortName = "admin";
$shortName = strtok($_SESSION["name"], " ");
?>
<div class="px-3">
    <p class="h3 fw-black">STAFF DASHBOARD</p>
    <div>
        <p id="wlc" class="fw-medium fs-5">WELCOME!</p>
    </div>
    <div class="mt-3">
        <p class="fs-5">The staff dashboard provides an easy way for the staff to view latest orders, edit product stock, as well as update customer order status. At a Glance provides a summary of total revenue and orders. Use the quick actions below to start.</p>
        <p class="fw-black fs-5">QUICK ACTIONS</p>
        <div class="row ps-3 pb-3">
            <div class="d-flex col col-sm-2 col-xs-2 ps-0">
                <a class="d-flex w-100 text-reset text-decoration-none" href="/staff/products/index.php">
                    <div class="p-2 w-100 border rounded-4" style="background-color:#54a2fc50;border-color:#54a2fcA0!important;">
                        <p class="fw-bold text-center">EDIT PRODUCT STOCK</p>
                        <span class="d-flex justify-content-center mx-auto material-symbols-outlined" style="font-size:64px;">
                            inventory
                        </span>
                    </div>
                </a>
            </div>
            <div class="d-flex col col-sm-2 col-xs-2 ps-0">
                <a class="d-flex w-100 text-reset text-decoration-none" href="/staff/orders/index.php">
                    <div class="p-2 w-100 border rounded-4" style="background-color:#54a2fc50;border-color:#54a2fcA0!important;">
                        <p class="fw-bold text-center">VIEW LATEST ORDERS</p>
                        <span class="d-flex justify-content-center mx-auto material-symbols-outlined" style="font-size:64px;">
                            order_play
                        </span>
                    </div>
                </a>
            </div>
            <?php
                if($_SESSION['utype'] == 'admin'){
                    ?>
                    <div class="d-flex col col-sm-2 col-xs-2 ps-0">
                        <a class="d-flex w-100 text-reset text-decoration-none" href="/admin/index.php">
                            <div class="p-2 w-100 border rounded-4" style="background-color:#54a2fc50;border-color:#54a2fcA0!important;">
                                <p class="fw-bold text-center">SWITCH TO ADMIN</p>
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
        <p class="fw-black fs-5">AT A GLANCE</p>
        <div class="row ps-3 pb-3">
            <div class="d-flex col col-sm-2 col-xs-2 ps-0 pb-2">
                <div class="d-flex w-100 text-reset text-decoration-none">
                    <div class="p-2 w-100 border rounded-4" style="background-color:#a454fc50;border-color:#9254fca0!important;">
                        <p class="fw-bold text-center">TOTAL REVENUE</p>
                        <p id='totRev' class="fw-bold text-center placeholder-wave"><span class="placeholder w-25 me-1"></span><span class="placeholder w-50"></span></p>
                        <span class="d-flex justify-content-center mx-auto material-symbols-outlined" style="font-size:48px;">
                            paid
                        </span>
                    </div>
                </div>
            </div>
            <div class="d-flex col col-sm-2 col-xs-2 ps-0 pb-2">
                <div class="d-flex w-100 text-reset text-decoration-none">
                    <div class="p-2 w-100 border rounded-4" style="background-color:#54fc6d50;border-color:#5afc54a0!important;">
                        <p class="fw-bold text-center">TOTAL ORDERS</p>
                        <p class="fw-bold text-center"><span id='totOrd' class="placeholder-wave"><span class="placeholder w-25"></span></span></p>
                        <span class="d-flex justify-content-center mx-auto material-symbols-outlined" style="font-size:48px;">
                            emoji_food_beverage
                        </span>
                    </div>
                </div>
            </div>
            <div class="d-flex col col-sm-2 col-xs-2 ps-0 pb-2">
                <div class="d-flex w-100 text-reset text-decoration-none">
                    <div class="p-2 w-100 border rounded-4" style="background-color:#fc545450;border-color:#fc5454a0!important;">
                        <p class="fw-bold text-center">MONTHLY REVENUE</p>
                        <p id='mthRev' class="fw-bold text-center placeholder-wave"><span class="placeholder w-25 me-1"></span><span class="placeholder w-50"></span></p>
                        <span class="d-flex justify-content-center mx-auto material-symbols-outlined" style="font-size:48px;">
                            currency_exchange
                        </span>
                    </div>
                </div>
            </div>
            <div class="d-flex col col-sm-2 col-xs-2 ps-0 pb-2">
                <div class="d-flex w-100 text-reset text-decoration-none">
                    <div class="p-2 w-100 border rounded-4" style="background-color:#54f6fc50;border-color:#54e3fca0!important;">
                        <p class="fw-bold text-center">MONTHLY ORDERS</p>
                        <p class="fw-bold text-center"><span id='mthOrd' class="placeholder-wave"><span class="placeholder w-25"></span></span></p>
                        <span class="d-flex justify-content-center mx-auto material-symbols-outlined" style="font-size:48px;">
                            local_cafe
                        </span>
                    </div>
                </div>
            </div>
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
    $(document).ready(function(){
        $.get('/api/staff/get/orders.php', function(data){
            totRev.innerHTML = 'RM '+data['total_revenue'];
            totOrd.innerHTML = data['total_orders'];
            mthRev.innerHTML = 'RM '+data['current_month']['revenue'];
            mthOrd.innerHTML = data['current_month']['orders'];
        })
    })
</script>
<?php
include('../../internal/footer.php');
?>