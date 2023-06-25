var gl_total;
var gl_items = [];

$(function(){
    $('a').each(function(){
        if ($(this).prop('href') == window.location.href) {
            $(this).addClass('active'); $(this).parents('li').addClass('active');
        }
    });
});

$(document).on('click', '.prodShoppingBtn2', function(){
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

function openProductModal(product){
    $('#productCartModal').modal('show');
    $('#prodId').val(product);
    $('#cartQty').val(1);
    $('#tempProd').prop('checked', true);
    //cartQty.value = 1;
}

function createCheckoutTable(){
    var checkoutTable = $('#cartTable').DataTable({
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
            },
        });
    $("#cartTable tbody").on('click', 'button', function() {
        var data = checkoutTable.row($(this).parents('tr')).data();
    })
    new $.fn.dataTable.FixedHeader( checkoutTable );
    $('#cartTable').on('draw.dt', function(){
        items = []
        t_items = []
        checkoutTable.rows().every(function(){
            curRow = this.columns(5).data()
            items = this.columns(0).data()[0]
            itemNames = this.columns(1).data()[0]
            itemTemp = this.columns(2).data()[0]
            itemQty = this.columns(3).data()[0]
            itemPrices = this.columns(4).data()[0]
        })
        total = 0.00
        for(let i = 0; i < items.length; i++){
            switch(itemTemp[i]){
                case 'Hot':
                    itemTemp[i] = 1;
                    break;
                case 'Cold':
                    itemTemp[i] = 2;
                    break;
                default:
                    itemTemp[i] = null;
                    break;
            }
            t_items.push([items[i], itemNames[i], itemTemp[i], itemQty[i], itemPrices[i], curRow[0][i]])
        }
        if(typeof curRow === 'undefined'){
            showItemRequiredModal()
        }
        curRow.each(function(index){
            for(let i = 0; i < index.length; i++){
                total = total + parseFloat(index[i])
            }
        })
        subTotal.innerText = total.toFixed(2);
        subTotalVal = total.toFixed(2);
        tax = total*0.06
        taxTotal.innerText = tax.toFixed(2);
        taxVal = tax.toFixed(2);
        finalTotal = total + tax
        gl_total = finalTotal.toFixed(2);
        gl_items.push({data: t_items, subtotal: subTotalVal, tax: taxVal, total: gl_total})
        totalSum.innerText = finalTotal.toFixed(2);
    })
}

function showItemRequiredModal(){
    $('#itemRequiredModal').modal('show');
    $("#itemRequiredModal").on("hidden.bs.modal", function () {
        $('.btn').prop('disabled', true)
        window.location.href = "/shop.php"
    });
}

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

function renderOrdItemDT(apiEndpoint){
    vdetTable = $('#ordDetTable').DataTable({
        autoWidth: false,
        responsive: true,
        ajax: {
            url: apiEndpoint,
            dataSrc: 'data',
        },
        responsive: true,
        columnDefs: [
            {
                "defaultContent": "-",
                "targets": "_all"
            },
        ],
    });
}
function custOrder(){
    var ordTable = $('#ordTable').DataTable({
            autoWidth: false,
            responsive: true,
            ajax: {
                url: '/api/user/get/orders.php',
                dataSrc: 'data',
            },
            columnDefs: [
                {
                    targets: 6,
                    visible: false,
                },
                {
                    "defaultContent": '<button class="btn btn-primary rounded-pill viewDetBtn"><span class="align-middle material-symbols-outlined" style="font-size:24px;">visibility</span>View Details</button>',
                    "targets": -1
                },
                {
                    "defaultContent": "-",
                    "targets": "_all"
                },
            ],
            language: {
                emptyTable: "You have no orders"
            },
        });
    
    $("#ordTable tbody").on('click', '.viewDetBtn', function() {
        var data = ordTable.row($(this).parents()[0]).data();
        var getOrdEndpoint = '/api/user/get/orders.php?order_id='+data[0];
        renderOrdItemDT(getOrdEndpoint);
        $('#viewOrd').modal('show');
        $.get(getOrdEndpoint, function(data){
            if(!(data['paymentLink'] == null || data['paymentLink'] == 'expired')){
                pstatout = '<a href='+data['paymentLink']+'>'+data['status']+'</a>';
                pnbtn = '<a class="btn btn-outline-success border-0 rounded-pill" href='+data['paymentLink']+'>Pay Now</a>';
            } else {
                pstatout = data['status'];
                pnbtn = '';
            }
            ordDate.innerText = data['date'];
            ordTime.innerText = data['time'];
            ordStat.innerHTML = pstatout;
            ordPMethod.innerText = data['paymentMethod']
            ordTot.innerText = "RM " + data['total'];
            ordPayNow.innerHTML = pnbtn;
        })
    })
    $('#viewOrd').on('hidden.bs.modal', function(){
        vdetTable.destroy();
        ordDate.innerText = "";
        ordTime.innerText = "";
        ordStat.innerHTML = "";
        ordPMethod.innerText = "";
        ordTot.innerText = "";
        ordPayNow.innerHTML = "";
    })
    new $.fn.dataTable.FixedHeader( ordTable );
}

$(document).ready(function(){
    $('#prodCartForm').submit(function(e){
        e.preventDefault();
        //

        $.post("/api/user/post/cart.php",
        {
            value: $('#prodId').val(),
            quantity: $('#cartQty').val(),
            temperature: $('input[name="temperature"]:checked').val()
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

    $('.navbar-toggler').on('hidden.bs.dropdown', function() {
        $('#menuIconLabel').toggleClass('filled', $('#drpmenu').is(":visible"))
        $('#cartIconLabel').toggleClass('filled', $('#drpcart').is(":visible"))
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
    

    $('#dropdownMenuButton').click(function() {
        $('#menuIconLabel').toggleClass('filled', $('#drpmenu').is(":visible"))
        if ($('.avdrpd').is(":visible") && screen.width < 580){
            $('body').css('overflow', 'hidden');
        } else {
            $('body').css('overflow', 'auto');
        }
    });
    
    $('#dropdownCartButton').click(function() {
        $('#cartIconLabel').toggleClass('filled', $('#drpcart').is(":visible"))
        if ($('.avdrpd').is(":visible") && screen.width < 580){
            $('body').css('overflow', 'hidden');
        } else {
            $('body').css('overflow', 'auto');
        }
    });

    $('.itmreqclose').on('click', function(){
        window.location.href = "/shop.php"
    })

    $('.continueCheckoutBtn').on('click', function(){
        window.location.href = '/customer/payment.php'
        gl_items_jstr = JSON.stringify(gl_items[0])
        sessionStorage.setItem('cartitems', gl_items_jstr)
    });

    $('.backCheckoutBtn').on('click', function(){
        sessionStorage.removeItem('cartitem')
        window.location.href = '/customer/checkout.php'
    });

    $('.checkoutBtn').on('click', function(){
        window.location.href = '/customer/checkout.php'
    });

    $('.backCartBtn').on('click', function(){
        window.location.href = '/cart.php'
    });

    $('.gotoShopBtn').on('click', function(){
        window.location.href = '/shop.php'
    });

    $('.qtybtnminus').each(function(){
        if(parseInt($(this).closest('.qtycol').children('.qtynum').attr('value')) < 1){
            $(this).attr("disabled", true);
        } else {
            $(this).attr("disabled", false);
        }
    });

    $('.tocartbtn').on('click', function(){
        window.location.href = '/cart.php'
    });

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
            $('#confirmCartDel').modal('show');
            $('#confirmCartDelBtn').data("value", $(this).data('value'));
            $('#confirmCartDelBtn').data("amt", 0);
            //$(this).attr("disabled", true);
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