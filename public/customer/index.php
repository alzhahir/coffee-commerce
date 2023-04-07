<?php
session_start();
include('../../internal/htmlhead.php');
include('../../internal/header.php');
if (!isset($_SESSION["cust_id"])){
    $_SESSION["userErrCode"] = "CUST_ID_NOT_SET";
    $_SESSION["userErrMsg"] = "The session has expired or is invalid. Please login again. Do contact the administrator if you believe that this should not happen.";
    header("refresh:0;url=/signup.php?error=true");
    die();
}
$shortName = strtok($_SESSION["name"], " ");
?>
<div class="px-3">
    <div>
        <h3 id="wlc" class="fw-black">WELCOME!</h3>
    </div>
</div>
<script type="text/javascript">
    var d = new Date(); // for now
    hn = d.getHours(); // => 9
    d.getMinutes(); // =>  30
    d.getSeconds(); // => 51

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
</script>
<?php
include('../../internal/footer.php');
?>