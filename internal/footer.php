<?php
    //footer code
    //get date and time
    date_default_timezone_set("Asia/Kuala_Lumpur");
    $dateNow = date('Y-m-d');
    $timeNow = date('H:i:s');
    $yearNow = date('Y');
?>
<div class="w-100">
    <div class="toast-container fixed-bottom me-3 bottom-0 end-0 float-end" style="left:unset;">
        <div id="toastAuthErr" class="toast align-items-center" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <span class="material-symbols-outlined align-middle text-center px-0">
                        warning
                    </span>
                    You need to login to add to cart.
                </div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
        <div id="toastErr" class="toast align-items-center" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <span class="material-symbols-outlined align-middle text-center px-0">
                        warning
                    </span>
                    Failed to add item to Your Cart!
                </div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
        <div id="toastSucc" class="toast align-items-center mb-3" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <span class="material-symbols-outlined align-middle text-center px-0">
                        check_circle
                    </span>
                    The item has been added to Your Cart.
                </div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
        <div id="toastUpdSucc" class="toast align-items-center mb-3" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <span class="material-symbols-outlined align-middle text-center px-0">
                        check_circle
                    </span>
                    Your Cart has been updated.
                </div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
        <div id="toastUpdErr" class="toast align-items-center mb-3" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <span class="material-symbols-outlined align-middle text-center px-0">
                        warning
                    </span>
                    Failed to update Your Cart.
                </div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
</div>
    <script>
        $(document).on('click', '#prodShoppingBtn', function(){
            btnData = $(this).data("value");
            $.ajax('/api/user/post/cart.php', {
                type: 'POST',
                data: {
                    value: btnData,
                },
                success: function(){
                    const toastElList = document.querySelectorAll('#toastSucc')
                    const toastList = [...toastElList].map(toastEl => new bootstrap.Toast(toastEl, {autohide:true, animation:true, delay:3000}))
                    toastList.forEach(toast => toast.show());
                },
                error: function(jqXHR){
                    if(jqXHR.status == "401"){
                        const toastElList = document.querySelectorAll('#toastAuthErr')
                        const toastList = [...toastElList].map(toastEl => new bootstrap.Toast(toastEl, {autohide:true, animation:true, delay:3000}))
                        toastList.forEach(toast => toast.show());
                        $('#loginRequiredModal').modal('show');
                    } else {
                        const toastElList = document.querySelectorAll('#toastErr')
                        const toastList = [...toastElList].map(toastEl => new bootstrap.Toast(toastEl, {autohide:true, animation:true, delay:3000}))
                        toastList.forEach(toast => toast.show());
                    }
                }
            });
            /*$.post("/api/user/post/cart.php",
            {
                value: btnData,
            })
            .done(function(){
                //success
                const toastElList = document.querySelectorAll('#toastSucc')
                const toastList = [...toastElList].map(toastEl => new bootstrap.Toast(toastEl, {autohide:true, animation:true, delay:3000}))
                toastList.forEach(toast => toast.show());
            })
            .fail(function(response){
                //fail
                console.log(response)
                const toastElList = document.querySelectorAll('#toastErr')
                const toastList = [...toastElList].map(toastEl => new bootstrap.Toast(toastEl, {autohide:true, animation:true, delay:3000}))
                toastList.forEach(toast => toast.show());
            });*/
            $.get('/api/user/get/cart.php', function(data, status){
                $('.qtynum').attr('value', data.data[0][2][0][1]);
                $('.qtynum').val(data.data[0][2][0][1]);
            });
        });
    </script>
    <footer class="flex-wrap align-items-center justify-content-center justify-content-md-between footer mt-auto bg-dark py-2 px-3 mt-5">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between">
            <a class="col h3 mb-0 fw-black text-light text-decoration-none d-flex flex-wrap align-items-center">AHVELO COFFEE</a>
            <b class="col fw-medium text-light text-end me-0">Copyright ©️ <?php echo $yearNow; ?> Megat Al Zhahir Daniel. All Rights Reserved.</b>
        </div>
    </footer>
</body>
</html>