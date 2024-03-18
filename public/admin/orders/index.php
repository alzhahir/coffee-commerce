<?php
session_start();
$ROOTPATH = $_SERVER["DOCUMENT_ROOT"] . '/..';
include($ROOTPATH . '/internal/admincontrol.php');
include($ROOTPATH . '/internal/htmlhead.php');
include($ROOTPATH . '/internal/adminheader.php');
?>
<div class="px-3">
    <p class="h3 fw-black">ORDERS</p>
</div>
<div class="px-3 my-auto">
    <div style="margin:auto; text-align:center; width:50%;">
        <span class="material-symbols-outlined" style="margin:auto;display:inline-block;font-size:96px;">
            transfer_within_a_station
        </span>
        <p class="h3 fw-medium user-select-none">Please switch to the staff dashboard to view orders.</p>
        <a href="/staff/orders/index.php" class="rounded-pill btn btn-outline-danger">GO TO ORDERS</a>
    </div>
</div>
<?php
include($ROOTPATH . '/internal/footer.php');
?>