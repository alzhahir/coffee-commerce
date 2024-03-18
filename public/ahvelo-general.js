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
            //const toastElList = document.querySelectorAll('#toastSucc')
            //const toastList = [...toastElList].map(toastEl => new bootstrap.Toast(toastEl, {autohide:true, animation:true, delay:3000}))
            //toastList.forEach(toast => toast.show());
            $('#toastSucc').toast('show');
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
                //const toastElList = document.querySelectorAll('#toastAuthErr')
                //const toastList = [...toastElList].map(toastEl => new bootstrap.Toast(toastEl, {autohide:true, animation:true, delay:3000}))
                //toastList.forEach(toast => toast.show());
                $('#toastAuthErr').toast('show');
                $('#loginRequiredModal').modal('show');
            } else if(jqXHR.status == "400"){
                $('#toastErr').toast('show');
                $('#itemStockModal').modal('show');
            } else {
                //const toastElList = document.querySelectorAll('#toastErr')
                //const toastList = [...toastElList].map(toastEl => new bootstrap.Toast(toastEl, {autohide:true, animation:true, delay:3000}))
                //toastList.forEach(toast => toast.show());
                $('#toastErr').toast('show');
            }
        }
    });
});

function cartQuantitySend(itemId, itemTemp, itemQty){
    itemQty = parseInt(itemQty);
    itemTempInt = 0;
    if(itemTemp.includes("Hot") || itemTemp.includes("hot")){
        itemTempInt = 1;
    } else if(itemTemp.includes("Cold") || itemTemp.includes("cold")){
        itemTempInt = 2;
    } else {
        console.log("ERR: item temp invalid");
        return;
    }
    if(itemQty < 1){
        //delete item
        $('#confirmCartDelBtn').data("value", itemId);
        $('#confirmCartDelBtn').data("amt", 0);
        $('#confirmCartDelBtn').data('temp', itemTempInt);
        $('#confirmCartDel').modal('show');
        return;
    }
    if(itemQty > 6){
        $('#itemLimitModal').modal('show');
        $('#cartTable').DataTable().ajax.reload();
        return;
    }
    if(itemQty <= 6){
        $.post("/api/user/post/cart.php",
        {
            value: itemId,
            quantity: parseInt(itemQty),
            temperature: itemTempInt,
        })
        .done(function(){
            //success
            //const toastElList = document.querySelectorAll('#toastUpdSucc')
            //const toastList = [...toastElList].map(toastEl => new bootstrap.Toast(toastEl, {autohide:true, animation:true, delay:3000}))
            //toastList.forEach(toast => toast.show());
            $('#toastUpdSucc').toast('show');
            $('#cartTable').DataTable().ajax.reload();
            window.location.reload();
        })
        .fail(function(res){
            //fail
            //const toastElList = document.querySelectorAll('#toastUpdErr')
            //const toastList = [...toastElList].map(toastEl => new bootstrap.Toast(toastEl, {autohide:true, animation:true, delay:3000}))
            //toastList.forEach(toast => toast.show());
            $('#toastUpdErr').toast('show');
            if(res.status == 400){
                $('#itemStockModal').modal('show');
                $('#itemStockModal').on('hidden.bs.modal', function(){
                    window.location.reload();
                })
                
            }
        });
    }
}

function printContent() {
    var d = new Date();

    var month = d.getMonth()+1;
    var day = d.getDate();
    var hour = d.getHours();
    var min = d.getMinutes();
    var sec = d.getSeconds();
    var mid = 'PM';
    if(sec < 10) { 
      sec = "0" + sec; 
    }
    if (min < 10) {
      min = "0" + min;
    }
    if (hour > 12) {
      hour = hour - 12;
    }   
    if (hour < 10 ) {
      hour = "0" + hour;
    }   
    if(hour==0){ 
      hour=12;
    }
    if(hour < 12) {
       mid = 'AM';
    }

    var time = hour + ":" + min + ":" + sec + " " + mid;

    var year = d.getFullYear() + '/' +
        ((''+month).length<2 ? '0' : '') + month + '/' +
        ((''+day).length<2 ? '0' : '') + day;
    userCss = [
        "https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css",
        "https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.css",
        "https://cdn.datatables.net/buttons/2.3.6/css/buttons.bootstrap5.css",
        "https://cdn.datatables.net/colreorder/1.6.2/css/colReorder.bootstrap5.css",
        "https://cdn.datatables.net/datetime/1.4.1/css/dataTables.dateTime.css",
        "https://cdn.datatables.net/fixedcolumns/4.2.2/css/fixedColumns.bootstrap5.css",
        "https://cdn.datatables.net/fixedheader/3.3.2/css/fixedHeader.bootstrap5.css",
        "https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap5.css",
        "https://cdn.jsdelivr.net/npm/@eonasdan/tempus-dominus@6.4.4/dist/css/tempus-dominus.min.css",
        "/ahvelo-general.css"
    ]

    ignoreElements = [
        "ordDetTable_length",
        "ordDetTable_filter",
        "ordDetTable_info",
        "ordDetTable_paginate",
    ]
    headerObj =`
        <div>
            <div class="row">
                <p class="px-4 h1 fw-black mb-0">AHVELO COFFEE</p>
                <div class="col px-4">
                    <p class="mb-0">Laman Rafa, Chendering,</p>
                    <p class="mb-0">21080, Kuala Terengganu,</p>
                    <p class="mb-0">Terengganu</p>
                </div>
                <div class="col position-relative">
                    <div class="position-absolute top-50 start-50 translate-middle">
                        <p class="mb-0">Email: ahvelo@example.com</p>
                        <p class="mb-0">Phone: +60123456789</p>
                        <p class="mb-0">Website: fyp.alzhahir.com</p>
                    </div>
                </div>
            </div>
            <hr>
            <div>
                <p class="fw-bold fs-5 text-center">CUSTOMER RECEIPT</p>
                <p class="text-center">Valid as of `+year+`, `+time+`</p>
            </div>
        </div>
    `;
    footerObj = `
        <div>
            <hr>
            <div>
            <p><span>Note: this receipt is computer-generated. No signature is needed. Thank you for shopping at </span><span class="fw-black">AHVELO COFFEE</span>! We hope to see you again.</p>
            </div>
        </div>
    `;
    printJS({printable: 'custReceipt', type: 'html', header: headerObj, footer: footerObj, css: userCss, ignoreElements: ignoreElements })
}

function closeNotif(nid){
    $('#notif'+nid).remove();
    $.ajax('/api/notification/update/read.php', {
        type: 'POST',
        data: {
            id: nid
        },
        success: function(){
            //const toastElList = document.querySelectorAll('#toastNotifDel')
            //const toastList = [...toastElList].map(toastEl => new bootstrap.Toast(toastEl, {autohide:true, animation:true, delay:3000}))
            //toastList.forEach(toast => toast.show());
            $('#toastNotifDel').toast('show');
        },
        fail: function(){
            //console.log("FAIL!")
        }
    })
    if($('#notifContent').is(':empty')){
        $('#notifContent').prepend('All notifications dismissed.')
    }
}

function openProductModal(product, temp){
    $('#productCartModal').modal('show');
    $('#prodId').val(product);
    $('#cartQty').val(1);
    $('#hotProd').prop('checked', true);
    $('#hotProd').attr('disabled', false);
    $('#coldProd').attr('disabled', false);
    switch(temp){
        case '1':
            $('#coldProd').attr('disabled', true);
            $('#hotProd').prop('checked', true);
            break;
        case '2':
            $('#hotProd').attr('disabled', true);
            $('#coldProd').prop('checked', true);
            break;
        case '3':
            $('#hotProd').prop('checked', true);
            break;
        default:
            $('#hotProd').prop('checked', true);
            break;
    }
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
                {
                    target: 2,
                    render : function(data, type, row) {
                        if(data.includes('Hot')){
                            return data
                        } else if (data.includes('Cold')){
                            return data + '<span class="badge rounded-pill bg-danger align-middle ms-2">+RM 1.00<span class="visually-hidden">Cold</span></span>'
                        } else {
                            return data
                        }
                    } 
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
            itemTempVal = null;
            if(itemTemp[i].includes('Cold')){
                itemTempVal = 'Cold';
            } else {
                itemTempVal = 'Hot';
            }
            switch(itemTempVal){
                case 'Hot':
                    itemTempVal = 1;
                    break;
                case 'Cold':
                    itemTempVal = 2;
                    break;
                default:
                    itemTempVal = null;
                    break;
            }
            t_items.push([items[i], itemNames[i], itemTempVal, itemQty[i], itemPrices[i], curRow[0][i]])
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
        finalTotal = total
        gl_total = finalTotal.toFixed(2);
        gl_items.push({data: t_items, subtotal: subTotalVal, total: gl_total})
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
                {
                    target: 2,
                    render : function(data, type, row) {
                        if(data.includes('Hot')){
                            return data
                        } else if (data.includes('Cold')){
                            return data + '<span class="badge rounded-pill bg-danger align-middle ms-2">+RM 1.00<span class="visually-hidden">Cold</span></span>'
                        } else {
                            return data
                        }
                    } 
                },
                {
                    target: 3,
                    render : function(data, type, row) {
                        return '<div class="qtycol"><input data-id="'+row[0]+'" data-temp="'+row[2]+'" data-value="'+data+'" type="number" value="'+data+'" min="0" max="6" class="form-control ms-auto qtynum" style="width:50px;display:inline-block;" onchange="cartQuantitySend(this.dataset.id, this.dataset.temp, this.value)"></div>'
                    } 
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
    $('#cartTable').on('draw.dt', function(){
        items = []
        t_items = []
        mainTable.rows().every(function(){
            curRow = this.columns(5).data()
            items = this.columns(0).data()[0]
            itemNames = this.columns(1).data()[0]
            itemTemp = this.columns(2).data()[0]
            itemQty = this.columns(3).data()[0]
            itemPrices = this.columns(4).data()[0]
        })
        total = 0.00
        for(let i = 0; i < items.length; i++){
            itemTempVal = null;
            if(itemTemp[i].includes('Cold')){
                itemTempVal = 'Cold';
            } else {
                itemTempVal = 'Hot';
            }
            switch(itemTempVal){
                case 'Hot':
                    itemTempVal = 1;
                    break;
                case 'Cold':
                    itemTempVal = 2;
                    break;
                default:
                    itemTempVal = null;
                    break;
            }
            t_items.push([items[i], itemNames[i], itemTempVal, itemQty[i], itemPrices[i], curRow[0][i]])
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
        finalTotal = total
        gl_total = finalTotal.toFixed(2);
        gl_items.push({data: t_items, subtotal: subTotalVal, total: gl_total})
    })
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
    var minDate, maxDate;
    // Create date inputs
    minDate = new DateTime('#minDate', {
        format: 'YYYY-MM-DD'
    });
    maxDate = new DateTime('#maxDate', {
        format: 'YYYY-MM-DD'
    });
        
    // Custom filtering function which will search data in column four between two values
    DataTable.ext.search.push(function (settings, data, dataIndex) {
        var min = minDate.val();
        var max = maxDate.val();
        var date = new Date(data[1]);
    
        if (
            (min === null && max === null) ||
            (min === null && date <= max) ||
            (min <= date && max === null) ||
            (min <= date && date <= max)
        ) {
            return true;
        }
        return false;
    });
    var ordTable = $('#ordTable').DataTable({
            order: [[0, 'desc']],
            autoWidth: false,
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
                    "defaultContent": '<button class="btn btn-primary rounded-pill viewDetBtn"><span class="align-middle material-symbols-outlined" style="font-size:24px;">visibility</span>View Order</button>',
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
    $('#minDate, #maxDate').on('change', function () {
        ordTable.draw();
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
            $('#printBtn').show();
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
    const toastElList = document.querySelectorAll('.toast')
    const toastList = [...toastElList].map(toastEl => new bootstrap.Toast(toastEl, {autohide:true, animation:true, delay:3000}))
    $('#prodCartForm').submit(function(e){
        e.preventDefault();
        //

        $.post("/api/user/post/cart.php",
        {
            value: $('#prodId').val(),
            //quantity: $('#cartQty').val(),
            temperature: $('input[name="temperature"]:checked').val()
        })
        .done(function(){
            //success
            //const toastElList = document.querySelectorAll('#toastSucc')
            //const toastList = [...toastElList].map(toastEl => new bootstrap.Toast(toastEl, {autohide:true, animation:true, delay:3000}))
            //toastList.forEach(toast => toast.show());
            $('#toastSucc').toast('show');
            $('#cartTable').DataTable().ajax.reload();
            window.location.reload();
        })
        .fail(function (jqXHR){
            if(jqXHR.status == "401"){
                //const toastElList = document.querySelectorAll('#toastAuthErr')
                //const toastList = [...toastElList].map(toastEl => new bootstrap.Toast(toastEl, {autohide:true, animation:true, delay:3000}))
                //toastList.forEach(toast => toast.show());
                $('#toastAuthErr').toast('show');
                $('#loginRequiredModal').modal('show');
            } else if(jqXHR.status == "400"){
                $('#toastErr').toast('show');
                $('#itemStockModal').modal('show');
            } else {
                //const toastElList = document.querySelectorAll('#toastErr')
                //const toastList = [...toastElList].map(toastEl => new bootstrap.Toast(toastEl, {autohide:true, animation:true, delay:3000}))
                //toastList.forEach(toast => toast.show());
                $('#toastErr').toast('show');
            }
        });
        $('#productCartModal').modal('hide');
    })

    $('.navbar-toggler').on('hidden.bs.dropdown', function() {
        $('#menuIconLabel').toggleClass('filled', $('#drpmenu').is(":visible"))
        $('#notifIconLabel').toggleClass('filled', $('#drpnotif').is(":visible"))
        $('#cartIconLabel').toggleClass('filled', $('#drpcart').is(":visible"))
        //$('#notifContent').empty();
        //$('#notifContent').append("No unread notifications.");
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

    $('.collapsible-icn-btn').click(function(){
        if($(this).hasClass('collapsed')){
            $(this).children('.collapsible-icn').text("chevron_right");
        } else {
            $(this).children('.collapsible-icn').text("expand_more");
        }
    })

    $('#dropdownMenuButton').click(function() {
        $('#menuIconLabel').toggleClass('filled', $('#drpmenu').is(":visible"))
        if ($('.avdrpd').is(":visible") && screen.width < 580){
            $('body').css('overflow', 'hidden');
        } else {
            $('body').css('overflow', 'auto');
        }
    });

    $('#dropdownNotifButton').click(function() {
        $('#notifIconLabel').toggleClass('filled', $('#drpnotif').is(":visible"))
        $('#notifBadge').hide();
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
        $('#confirmCartDel').modal('hide');
        $.post("/api/user/post/cart.php",
        {
            value: $(this).data('value'),
            quantity: $(this).data('amt'),
            temperature: $(this).data('temp'),
        })
        .done(function(){
            //success
            //const toastElList = document.querySelectorAll('#toastUpdSucc')
            //const toastList = [...toastElList].map(toastEl => new bootstrap.Toast(toastEl, {autohide:true, animation:true, delay:3000}))
            //toastList.forEach(toast => toast.show());
            $('#toastUpdSucc').toast('show');
            $('#cartTable').DataTable().ajax.reload();
            window.location.reload();
        })
        .fail(function(){
            //fail
            //const toastElList = document.querySelectorAll('#toastUpdErr')
            //const toastList = [...toastElList].map(toastEl => new bootstrap.Toast(toastEl, {autohide:true, animation:true, delay:3000}))
            //toastList.forEach(toast => toast.show());
            $('#toastUpdErr').toast('show');
        });
    })
    $('.qtybtnplus').on('click', function(){
        var qtyval = parseInt($(this).closest('.qtycol').children('.qtynum').attr('value'));
        if(qtyval + 1 > 1){
            $(this).closest('.qtycol').children('.qtybtnminus').attr("disabled", false);
        }
        if(qtyval + 1 > 6){
            $('#itemLimitModal').modal('show');
        }
        if(qtyval < 6){
            $(this).closest('.qtycol').children('.qtynum').val(qtyval+1);
            $(this).closest('.qtycol').children('.qtynum').attr('value', qtyval+1);
            if(qtyval <= 6){
                $.post("/api/user/post/cart.php",
                {
                    value: $(this).data('value'),
                    quantity: parseInt($(this).closest('.qtycol').children('.qtynum').attr('value')),
                    temperature: $(this).data('temp'),
                })
                .done(function(){
                    //success
                    //const toastElList = document.querySelectorAll('#toastUpdSucc')
                    //const toastList = [...toastElList].map(toastEl => new bootstrap.Toast(toastEl, {autohide:true, animation:true, delay:3000}))
                    //toastList.forEach(toast => toast.show());
                    $('#toastUpdSucc').toast('show');
                    $('#cartTable').DataTable().ajax.reload();
                    //window.location.reload();
                })
                .fail(function(res){
                    //fail
                    //const toastElList = document.querySelectorAll('#toastUpdErr')
                    //const toastList = [...toastElList].map(toastEl => new bootstrap.Toast(toastEl, {autohide:true, animation:true, delay:3000}))
                    //toastList.forEach(toast => toast.show());
                    $('#toastUpdErr').toast('show');
                    if(res.status == 400){
                        $('#itemStockModal').modal('show');
                        $('#itemStockModal').on('hidden.bs.modal', function(){
                            window.location.reload();
                        })
                    }
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
            $('#confirmCartDelBtn').data('temp', $(this).data('temp'))
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
                    temperature: $(this).data('temp'),
                })
                .done(function(){
                    //success
                    //const toastElList = document.querySelectorAll('#toastUpdSucc')
                    //const toastList = [...toastElList].map(toastEl => new bootstrap.Toast(toastEl, {autohide:true, animation:true, delay:3000}))
                    //toastList.forEach(toast => toast.show());
                    $('#toastUpdSucc').toast('show');
                    $('#cartTable').DataTable().ajax.reload();
                    //window.location.reload();
                })
                .fail(function(){
                    //fail
                    //const toastElList = document.querySelectorAll('#toastUpdErr')
                    //const toastList = [...toastElList].map(toastEl => new bootstrap.Toast(toastEl, {autohide:true, animation:true, delay:3000}))
                    //toastList.forEach(toast => toast.show());
                    $('#toastUpdErr').toast('show');
                });
            }
            qtyval--
        }
    })
})