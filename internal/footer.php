<?php
    //footer code
    //get date and time
    date_default_timezone_set("Asia/Kuala_Lumpur");
    $dateNow = date('Y-m-d');
    $timeNow = date('H:i:s');
    $yearNow = date('Y');
?>
    <div class="toast align-items-center" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                Hello, world! This is a toast message.
            </div>
            <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
    <footer class="flex-wrap align-items-center justify-content-center justify-content-md-between footer mt-auto bg-dark py-2 px-3 mt-5">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between">
            <a class="col h3 mb-0 fw-black text-light text-decoration-none d-flex flex-wrap align-items-center">AHVELO COFFEE</a>
            <b class="col fw-medium text-light text-end me-0">Copyright ©️ <?php echo $yearNow; ?> Megat Al Zhahir Daniel. All Rights Reserved.</b>
        </div>
    </footer>
</body>
</html>