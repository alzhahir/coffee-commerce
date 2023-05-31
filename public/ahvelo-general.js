$(function(){
    $('a').each(function(){
        if ($(this).prop('href') == window.location.href) {
            $(this).addClass('active'); $(this).parents('li').addClass('active');
        }
    });
});

$(document).on('click', '.prodShoppingBtn', function(){
    btnData = $(this).data("value");
    itmId = btnData;
    $.ajax('/api/user/post/cart.php', {
        type: 'POST',
        data: {
            value: btnData,
        },
        success: function(){
            const toastElList = document.querySelectorAll('#toastSucc')
            const toastList = [...toastElList].map(toastEl => new bootstrap.Toast(toastEl, {autohide:true, animation:true, delay:3000}))
            toastList.forEach(toast => toast.show());
            itemExists = false;
            $('.qtynum').each(function(){
                if($(this).data('id') == itmId){
                    itmQty = parseInt($(this).attr('value'));
                    $(this).attr('value', (itmQty + 1));
                    $(this).val((itmQty + 1));
                    itemExists = true;
                }

            })
            if(!itemExists){
                location.reload();
            }
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
});

$('#dropdownMenuButton').click(function() {
    $('#menuIconLabel').toggleClass('material-symbols-outlined filled')
    if ($('.avdrpd').is(":visible") && screen.width < 580){
        $('body').css('overflow', 'hidden');
    } else {
        $('body').css('overflow', 'auto');
    }
});

$('#dropdownCartButton').click(function() {
    $('#cartIconLabel').toggleClass('material-symbols-outlined filled')
    if ($('.avdrpd').is(":visible") && screen.width < 580){
        $('body').css('overflow', 'hidden');
    } else {
        $('body').css('overflow', 'auto');
    }
});

$('.navbar-toggler').on('hidden.bs.dropdown', function() {
    if ($('.avdrpd').is(":hidden")){
        $('body').css('overflow', 'auto');
    } else {
        $('body').css('overflow', 'hidden');
    }
});

$('#loginModal').on('hidden.bs.modal', function(){
    let url = new URL(window.location.href);
    url.searchParams.delete('error');
    url.searchParams.delete('signup');
    window.history.pushState({}, document.title, url);
})

$('#closebtn').click(function() {
    $("#drpmenu").dropdown("toggle");
    let url = new URL(window.location.href);
    url.searchParams.delete('error');
    url.searchParams.delete('signup');
    url.searchParams.delete('autherror');
    window.history.pushState({}, document.title, url);
});

function createCartTable(){
    var mainTable = $('#cartTable').DataTable({
                            autoWidth: false,
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
    })
    new $.fn.dataTable.FixedHeader( mainTable );
}

$(document).ready(function(){
    $('.checkoutBtn').on('click', function(){
        window.location.href = '/customer/checkout.php'
    })
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