<?php
session_start();
if (!isset($_SESSION["emp_id"])){
    $_SESSION["userErrCode"] = "EMP_ID_NOT_SET";
    $_SESSION["userErrMsg"] = "The session has expired or is invalid. Please login again. Do contact the administrator if you believe that this should not happen.";
    header("refresh:0;url=/signup.php?error=true");
    die();
}
if (!isset($_SESSION["utype"])){
    $_SESSION["userErrCode"] = "UTYPE_NOT_SET";
    $_SESSION["userErrMsg"] = "Invalid user configuration. Please login again. Do contact the administrator if you believe that this should not happen.";
    header("refresh:0;url=/signup.php?error=true");
    die();
}
if (isset($_SESSION["utype"]) && ($_SESSION["utype"] != "staff" && $_SESSION["utype"] != "admin") ){
    include('../../internal/htmlhead.php');
    include('../../internal/header.php');
?>
    <div class="px-3 my-auto">
        <div style="margin:auto; text-align:center; width:50%;">
            <span class="material-symbols-outlined" style="margin:auto;display:inline-block;font-size:96px;">
                warning
            </span>
            <p class="h3 fw-medium user-select-none">Your account does not have the required privilege to access this page.</p>
        </div>
    </div>
<?php
    include('../../internal/footer.php');
    die();
}
include('../../internal/htmlhead.php');
include('../../internal/staffheader.php');
$shortName = "admin";
$shortName = strtok($_SESSION["name"], " ");
?>
<div class="px-3">
    <p class="h3 fw-black">STAFF DASHBOARD</p>
    <div>
        <p id="wlc" class="fw-medium">WELCOME!</p>
    </div>
</div>
<script type="text/javascript">
    var d = new Date(); // for now
    hn = d.getHours(); // => 9
    d.getMinutes(); // =>  30
    d.getSeconds(); // => 51

    if(hn < 12){
        
        //morn
        txt = "Good morning, <?php echo ucfirst($shortName)?>!"
    } else if (hn >= 12 && hn < 15){
        //
        txt = "Good afternoon, <?php echo ucfirst($shortName)?>!"
    } else if (hn > 15){
        txt = "Good evening, <?php echo ucfirst($shortName)?>!"
    }

    wlc.innerText=txt
</script>
<?php
include('../../internal/footer.php');
?>