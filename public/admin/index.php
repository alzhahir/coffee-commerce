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
include($ROOTPATH . '/internal/footer.php');
?>