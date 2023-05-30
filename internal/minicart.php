<?php
    session_start();
    $PROJECTROOT = $_SERVER["DOCUMENT_ROOT"] . '/..';
    $included = true;
    include($PROJECTROOT . '/public/api/user/get/cart.php');
    include($PROJECTROOT . '/public/api/get/products.php');
    $included = false;
    //outputProdArr are products, outputCartArr is cart
    if(!$noCart){
?>
<div id="miniCartObj">
    <div id="cartlabel" class="d-flex flex-row">
        <div class="col fw-bold">
            ITEM
        </div>
        <div class="col fw-bold text-end">
            QUANTITY
        </div>
    </div>
    <hr class="my-2">
    <?php
    //print_r($outputProdArr);
        foreach($outputCartArr[0][2] as $currCart){
    ?>
    <div id="itmrow" class="d-flex flex-row">
    <?php
        foreach($outputProdArr as $currProd){
            if($currProd[0] == $currCart[0]){
                ?>
                <div class="col fw-medium">
                    <?php echo($currProd[1]); ?>
                </div>
                <div class="col fw-medium text-end qtycol" style="float:right;">
                    <div style="display:inline-block;">
                        <button data-value="<?php echo($currProd[0]); ?>" class="btn btn-danger rounded-circle align-middle text-center border-0 px-0 qtybtnminus" style="width:36px;height:36px;" disabled>
                            <span class="material-symbols-outlined align-middle text-center px-0">
                                remove
                            </span>
                        </button>
                    </div>
                    <input id="itmMcart" data-id="<?php echo($currProd[0]); ?>" type="text" value="<?php echo($currCart[1]); ?>" min="0" max="99" class="form-control ms-auto qtynum" style="width:50px;display:inline-block;" disabled>
                    <div style="display:inline-block;">
                        <button data-value="<?php echo($currProd[0]); ?>" class="btn btn-success rounded-circle align-middle text-center border-0 px-0 qtybtnplus" style="width:36px;height:36px;">
                            <span class="material-symbols-outlined align-middle text-center px-0">
                                add
                            </span>
                        </button>
                    </div>
                </div>
                <?php
            }
        }
    ?>
    </div>
    <?php
        }
    ?>
    <hr class="my-2">
    <div class="">
        <button class="float-end btn btn-primary ahvbutton align-middle text-center border-0 px-2 tocartbtn">
            <span class="material-symbols-outlined align-middle text-center px-0">
                shopping_cart_checkout
            </span>
            To Your Cart
        </button>
    </div>
</div>
<?php
 } else {
    ?>
    <div style="display:table;">
        <span class="material-symbols-outlined" style="display:table-cell;vertical-align:middle;">
            remove_shopping_cart
        </span>
        <span class="ps-2" style="font-size:18px;display:table-cell;vertical-align:middle;">Your Cart is empty!</span>
    </div>
    <?php
}
?>
<script>
    function createCartTable(){
        var mainTable = $('#cartTable').DataTable({
                                ajax: {
                                    url: '/api/user/get/cart.php',
                                    dataSrc: 'data',
                                },
                                responsive: true,
                                columnDefs: [
                                    {
                                        targets: 0,
                                        visible: false,
                                    },
                                ],
                                //dom: 'Bfrtip',
                                buttons: [
                                    'print'
                                ],
                                language: {
                                    emptyTable: "Your Cart is empty"
                                }
                            });
            $("#cartTable tbody").on('click', 'button', function() {
                var data = mainTable.row($(this).parents('tr')).data();
                //window.location.href = "applicationDetails.php?app_id="+data[0];
            })
            new $.fn.dataTable.FixedHeader( mainTable );
    }
    //$('.qtybtnminus').on('load', function(){
    //    qtyval = parseInt($(this).closest('.qtycol').children('.qtynum').attr('value'));
    //    if(qtyval - 1 <= 1){
    //        $(this).attr("disabled", true);
    //    }
    //})
    $(document).ready(function(){
        $('.qtybtnminus').each(function(){
            if(parseInt($(this).closest('.qtycol').children('.qtynum').attr('value')) < 1){
                $(this).attr("disabled", true);
            } else {
                $(this).attr("disabled", false);
            }
        })
        $('.tocartbtn').on('click', function(){
            window.location.href = '/cart.php'
        })
        $('#confirmCartDelBtn').on('click', function(){
            $.post("/api/user/post/cart.php",
            {
                value: $(this).data('value'),
                quantity: $(this).data('amt'),
            })
            .done(function(){
                //success
                $('#confirmCartDel').modal('hide');
                const toastElList = document.querySelectorAll('#toastUpdSucc')
                const toastList = [...toastElList].map(toastEl => new bootstrap.Toast(toastEl, {autohide:true, animation:true, delay:3000}))
                toastList.forEach(toast => toast.show());
                $('#cartTable').DataTable().ajax.reload();
                window.location.reload();
            })
            .fail(function(){
                //fail
                $('#confirmCartDel').modal('hide');
                const toastElList = document.querySelectorAll('#toastUpdErr')
                const toastList = [...toastElList].map(toastEl => new bootstrap.Toast(toastEl, {autohide:true, animation:true, delay:3000}))
                toastList.forEach(toast => toast.show());
            });
        })
        $('.qtybtnplus').on('click', function(){
            qtyval = parseInt($(this).closest('.qtycol').children('.qtynum').attr('value'));
            if(qtyval + 1 > 1){
                $('.qtybtnminus').attr("disabled", false);
            }
            if(qtyval < 99){
                $(this).closest('.qtycol').children('.qtynum').val(qtyval+1);
                $(this).closest('.qtycol').children('.qtynum').attr('value', qtyval+1);
                if(qtyval <= 100){
                    $.post("/api/user/post/cart.php",
                    {
                        value: $(this).data('value'),
                        quantity: parseInt($(this).closest('.qtycol').children('.qtynum').attr('value')),
                    })
                    .done(function(){
                        //success
                        const toastElList = document.querySelectorAll('#toastUpdSucc')
                        const toastList = [...toastElList].map(toastEl => new bootstrap.Toast(toastEl, {autohide:true, animation:true, delay:3000}))
                        toastList.forEach(toast => toast.show());
                        $('#cartTable').DataTable().ajax.reload();
                        //window.location.reload();
                    })
                    .fail(function(){
                        //fail
                        const toastElList = document.querySelectorAll('#toastUpdErr')
                        const toastList = [...toastElList].map(toastEl => new bootstrap.Toast(toastEl, {autohide:true, animation:true, delay:3000}))
                        toastList.forEach(toast => toast.show());
                    });
                }
                qtyval++
            }
        })
        $('.qtybtnminus').on('click', function(){
            qtyval = parseInt($(this).closest('.qtycol').children('.qtynum').attr('value'));
            if(qtyval - 1 < 1){
                $(this).attr("disabled", true);
                $('#confirmCartDel').modal('show');
                $('#confirmCartDelBtn').data("value", $(this).data('value'));
                $('#confirmCartDelBtn').data("amt", 0);
            }
            if(qtyval > 1){
                $(this).closest('.qtycol').children('.qtynum').val(qtyval-1);
                $(this).closest('.qtycol').children('.qtynum').attr('value', qtyval-1);
                if(qtyval >= 1){
                    $.post("/api/user/post/cart.php",
                    {
                        value: $(this).data('value'),
                        quantity: parseInt($(this).closest('.qtycol').children('.qtynum').attr('value')),
                    })
                    .done(function(){
                        //success
                        const toastElList = document.querySelectorAll('#toastUpdSucc')
                        const toastList = [...toastElList].map(toastEl => new bootstrap.Toast(toastEl, {autohide:true, animation:true, delay:3000}))
                        toastList.forEach(toast => toast.show());
                        $('#cartTable').DataTable().ajax.reload();
                        //window.location.reload();
                    })
                    .fail(function(){
                        //fail
                        const toastElList = document.querySelectorAll('#toastUpdErr')
                        const toastList = [...toastElList].map(toastEl => new bootstrap.Toast(toastEl, {autohide:true, animation:true, delay:3000}))
                        toastList.forEach(toast => toast.show());
                    });
                }
                qtyval--
            }
        })
    })
</script>
<?php
    $included = false;
?>