<?php
session_start();
include('../../internal/custcontrol.php');
include('../../internal/htmlhead.php');
include('../../internal/header.php');
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