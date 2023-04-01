<?php
    //footer code
    //get date and time
    date_default_timezone_set("Asia/Kuala_Lumpur");
    $dateNow = date('Y-m-d');
    $timeNow = date('H:i:s');
    $yearNow = date('Y');
?>
    <footer class="flex-wrap footer mt-auto bg-dark py-3 px-3 sticky-bottom">
        <div class="row align-items-center">
            <a class="col h3 fw-black text-light text-decoration-none">AHVELO COFFEE</a>
            <b class="col fw-medium text-light text-end me-0">Copyright ©️ <?php echo $yearNow; ?> Megat Al Zhahir Daniel. All Rights Reserved.</b>
        </div>
    </footer>
</body>
</html>