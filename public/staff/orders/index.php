<?php
session_start();
$pageTitle = "Ahvelo Staff - Orders";
$ROOTPATH = $_SERVER["DOCUMENT_ROOT"] . '/..';
include($ROOTPATH . '/internal/staffcontrol.php');
include($ROOTPATH . '/internal/htmlhead.php');
include($ROOTPATH . '/internal/staffheader.php');
?>
<div class="px-3 mb-4">
    <?php 
        $_SESSION["backPage"] = $_SERVER["PHP_SELF"];
        //check if $_GET isset
        if(isset($_GET["error"])){
            //error exists
            echo "<div class=\"alert alert-danger\">";
            if(isset($_SESSION["userErrMsg"])){
                //get err msg
                $errMsg = $_SESSION["userErrMsg"];
                $errCode = $_SESSION["userErrCode"];
                echo "<h5 class=\"my-0 fw-semibold\" style=\"text-align: justify; text-justify: inter-word;\">$errMsg</h5>";
                echo "<p class=\"my-0 fst-italic fw-light\">Error code: $errCode</p>";
            }
            echo "</div>";
        }
        if(isset($_GET["update"])){
            echo "<div class=\"alert alert-success\">";
            if(isset($_SESSION["userErrMsg"])){
                //get err msg
                $errMsg = $_SESSION["userErrMsg"];
                $errCode = $_SESSION["userErrCode"];
                echo "<h5 class=\"my-0 fw-semibold\" style=\"text-align: justify; text-justify: inter-word;\">$errMsg</h5>";
            }
            echo "</div>";
        }
    ?>
    <p class="h3 fw-black">
        ORDERS
    </p>
    <script type="text/javascript">
        var minDate, maxDate;
        
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
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
        $(document).ready( function () {
            // Create date inputs
            minDate = new DateTime('#minDate', {
                format: 'YYYY-MM-DD'
            });
            maxDate = new DateTime('#maxDate', {
                format: 'YYYY-MM-DD'
            });
            function renderItemDT(apiEndpoint){
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
            var mainTable = $('#ordTable').DataTable({
                                order: [[0, 'desc']],
                                autoWidth: false,
                                responsive: true,
                                ajax: {
                                    url: '/api/staff/get/orders.php',
                                    dataSrc: 'data',
                                },
                                columnDefs: [
                                    {
                                        "defaultContent": '<button class="btn btn-primary ahvbutton editStatBtn"><span class="align-middle material-symbols-outlined" style="font-size:24px;">edit</span><span class="align-middle text-center ps-1">Edit Status</span></button>',
                                        "targets": -1
                                    },
                                    {
                                        "defaultContent": '<button class="btn btn-primary rounded-pill viewDetBtn"><span class="align-middle material-symbols-outlined" style="font-size:24px;">visibility</span><span class="align-middle text-center ps-1">View Details</span></button>',
                                        "targets": -2
                                    },
                                    {
                                        "defaultContent": "-",
                                        "targets": "_all"
                                    },
                                ],
                                dom: "<'row'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'f>>" +
                                    "<'row'<'col-sm-12'tr>>" +
                                    "<'row'<'col-sm-5 col-md-5'i><'col-sm-12 col-md-2'l><'col-sm-12 col-md-5'p>>",
                                buttons: [
                                    {
                                        extend: 'print',
                                        exportOptions: {
                                            columns: [
                                                0,
                                                1,
                                                2,
                                                3,
                                                4
                                            ],
                                        },
                                        title: '',
                                        footer: true,
                                        customize: function ( win ) {
                                            $(win.document.body)
                                                .css( 'font-size', '12pt' )
                                                .prepend(
                                                    `
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
                                                            <p class="fw-bold fs-5 text-center">ORDER LISTING REPORT</p>
                                                            <p class="text-center">Valid as of <?php echo date('m/d/Y, h:i:s A', time()) ?>.</p>
                                                        </div>
                                                    </div>
                                                    `
                                                )
                                                .append(
                                                    `
                                                    <div>
                                                        <hr>
                                                        <div>
                                                        <p><span>Note: this report is generated by <?php echo $_SESSION['name'] ?> which has the role of <?php echo $_SESSION['utype'] ?>. This report is for use only by </span><span class="fw-black">AHVELO COFFEE</span> and their partners.</p>
                                                        </div>
                                                    </div>
                                                    `
                                                );

                                            $(win.document.body).find( 'table' )
                                                .addClass( 'compact' )
                                                .css( 'font-size', 'inherit' );
                                        }
                                    }
                                ]
                            });
            $('#minDate, #maxDate').on('change', function () {
                mainTable.draw();
            });
            $("#ordTable tbody").on('click', '.editStatBtn', function() {
                var updEndpoint = '/api/staff/update/orders.php';
                var data = mainTable.row($(this).parents()[0]).data();
                //window.location.href = "index.php?edit=true&app_id="+data[0];
                $('#editOrdForm').attr('action', updEndpoint+'?order_id='+data[0]);
                currStat = data[3];
                $('#editOrd').modal('show');
                $('#ordStatus').val(data[3]).change;
                if(data[3] == "Complete" || data[3] == $('#ordStatus').val() || data[3] == "Canceled"){
                    $('.saveOrdBtn').prop('disabled', true);
                }
            })
            $('#editOrd').on('shown.bs.modal', function(){
                $('#ordStatus').on('change', function(){
                    if(this.value != currStat && currStat != "Complete" && currStat != "Canceled"){
                        $('.saveOrdBtn').prop('disabled', false);
                    } else {
                        $('.saveOrdBtn').prop('disabled', true);
                    }
                })
            })
            $("#ordTable tbody").on('click', '.viewDetBtn', function() {
                var data = mainTable.row($(this).parents()[0]).data();
                var getOrdEndpoint = '/api/staff/get/orders.php?order_id='+data[0];
                renderItemDT(getOrdEndpoint);
                $('#viewOrd').modal('show');
                $.get(getOrdEndpoint, function(data){
                    ordCust.innerText = data['name'];
                    ordDate.innerText = data['date'];
                    ordTime.innerText = data['time'];
                    ordStat.innerText = data['status'];
                    ordPMethod.innerText = data['paymentMethod'];
                    ordTot.innerText = data['total'];
                    $('#printBtn').show();
                })
            })
            $('#editOrd').on('hidden.bs.modal', function(){
                $('.saveOrdBtn').prop('disabled', false);
            })
            $('#viewOrd').on('hidden.bs.modal', function(){
                vdetTable.destroy();
                ordCust.innerText = "";
                ordDate.innerText = "";
                ordTime.innerText = "";
                ordStat.innerText = "";
                ordPMethod.innerText = "";
                ordTot.innerText = "";
                $('#printBtn').hide();
            })
            new $.fn.dataTable.FixedHeader( mainTable );
        });
    </script>
    <div class="px-3 py-4 bg-white rounded-4 shadow">
        <div class="row justify-content-start mb-3">
            <div class="col-sm-4 col-md-3 form-floating">
                <input id="minDate" class="form-control" name="minDate" type="text" placeholder="Start Date" required/>
                <label class="ps-4" for="mindate">
                    <span class="material-symbols-outlined align-middle text-center pb-1">
                        date_range
                    </span>
                    Start Date
                </label>
            </div>
            <div class="col-sm-auto my-3 px-0 position-relative">
                <span class="d-none d-sm-block material-symbols-outlined align-middle text-center position-absolute top-50 start-50 translate-middle">
                navigate_next
                </span>
                <span class="d-block d-sm-none material-symbols-outlined align-middle text-center position-absolute top-50 start-50 translate-middle">
                expand_more
                </span>
            </div>
            <div class="col-sm-4 col-md-3 form-floating">
                <input id="maxDate" class="form-control" name="maxDate" type="text" placeholder="End Date" required/>
                <label class="ps-4" for="maxDate">
                    <span class='align-middle text-center px-0'>
                        <span class="material-symbols-outlined align-middle text-center pb-1">
                            calendar_month
                        </span>
                        End Date
                    </span>
                </label>
            </div>
        </div>
        <table id="ordTable" class="table table-bordered table-hover dt-responsive">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Order Date</th>
                    <th>Order Time</th>
                    <th>Order Status</th>
                    <th>Order Total</th>
                    <th>Customer ID</th>
                    <th>View Details</th>
                    <th>Edit Status</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- MODAL FOR EDITING ORDER -->
<div class="modal fade" id="editOrd" tabindex="-1" aria-labelledby="editOrder" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fw-black" id="editOrder">EDIT ORDER STATUS</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="col pb-3">
                    <p>You can use this form to edit order status.</p>
                    <?php 
                        $_SESSION["backPage"] = $_SERVER["PHP_SELF"];
                        //check if $_GET isset
                        if(isset($_GET["prodstat"])){
                            if($_GET["prodstat"] == "error"){
                                //err
                                echo "<div class=\"alert alert-danger\">";
                                if(isset($_SESSION["userErrMsg"])){
                                    //get err msg
                                    $errMsg = $_SESSION["userErrMsg"];
                                    $errCode = $_SESSION["userErrCode"];
                                    echo "<h5 class=\"my-0 fw-semibold\" style=\"text-align: justify; text-justify: inter-word;\">$errMsg</h5>";
                                    echo "<p class=\"my-0 fst-italic fw-light\">Error code: $errCode</p>";
                                }
                                echo "</div>";
                            } else if($_GET["prodstat"] == "success"){
                                //noerr
                                echo "<div class=\"alert alert-success\">";
                                if(isset($_SESSION["userErrMsg"])){
                                    //get err msg
                                    $errMsg = $_SESSION["userErrMsg"];
                                    $errCode = $_SESSION["userErrCode"];
                                    echo "<h5 class=\"my-0 fw-semibold\" style=\"text-align: justify; text-justify: inter-word;\">$errMsg</h5>";
                                }
                                echo "</div>";
                            } else {
                                //echo "Test lol";
                            }
                        }
                    ?>
                    <form id="editOrdForm" action="/api/staff/update/orders.php" method="post">
                        <div class="form-floating mb-3">
                            <!--input id="edOrdStock" class="form-control" name="ordStock" type="text" placeholder="Order Status" required/>
                            <label for="ordStock">Status</label-->
                            <select class="form-select" name="ordStatus" id="ordStatus" aria-label="ordStatus">
                                <option value="Pending">Pending</option>
                                <option value="Paid">Paid</option>
                                <option value="Preparing">Preparing</option>
                                <option value="Ready">Ready</option>
                                <option value="Complete">Complete</option>
                                <option value="Canceled">Canceled</option>
                            </select>
                            <label for="ordStatus">Status</label>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary border-0 rounded-pill" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-primary ahvbutton saveOrdBtn" form="editOrdForm" type="submit">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL FOR VIEWING ORDER DETAILS -->
<div class="modal fade" id="viewOrd" tabindex="-1" aria-labelledby="viewOrder" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-fullscreen-md-down modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fw-black" id="viewOrder">VIEW DETAILS</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="col pb-3">
                    <p>You can use this table to view order details.</p>
                    <?php 
                        $_SESSION["backPage"] = $_SERVER["PHP_SELF"];
                        //check if $_GET isset
                        if(isset($_GET["prodstat"])){
                            if($_GET["prodstat"] == "error"){
                                //err
                                echo "<div class=\"alert alert-danger\">";
                                if(isset($_SESSION["userErrMsg"])){
                                    //get err msg
                                    $errMsg = $_SESSION["userErrMsg"];
                                    $errCode = $_SESSION["userErrCode"];
                                    echo "<h5 class=\"my-0 fw-semibold\" style=\"text-align: justify; text-justify: inter-word;\">$errMsg</h5>";
                                    echo "<p class=\"my-0 fst-italic fw-light\">Error code: $errCode</p>";
                                }
                                echo "</div>";
                            } else if($_GET["prodstat"] == "success"){
                                //noerr
                                echo "<div class=\"alert alert-success\">";
                                if(isset($_SESSION["userErrMsg"])){
                                    //get err msg
                                    $errMsg = $_SESSION["userErrMsg"];
                                    $errCode = $_SESSION["userErrCode"];
                                    echo "<h5 class=\"my-0 fw-semibold\" style=\"text-align: justify; text-justify: inter-word;\">$errMsg</h5>";
                                }
                                echo "</div>";
                            } else {
                                //echo "Test lol";
                            }
                        }
                    ?>
                    <div id="custReceipt">
                        <div class="row d-flex justify-content-end">
                            <h5 class="col fw-bold">Customer Name: </h5>
                            <span class="col text-end fw-bold fs-5 ps-1" id="ordCust"></span>
                        </div>
                        <div class="row d-flex justify-content-end">
                            <h5 class="col fw-bold">Order Date: </h5>
                            <span class="col text-end fw-bold fs-5 ps-1" id="ordDate"></span>
                        </div>
                        <div class="row d-flex justify-content-end">
                            <h5 class="col fw-bold">Order Time: </h5>
                            <span class="col text-end fw-bold fs-5 ps-1" id="ordTime"></span>
                        </div>
                        <table id="ordDetTable" class="table table-bordered table-hover dt-responsive">
                            <thead>
                                <tr>
                                    <th>Item ID</th>
                                    <th>Item Name</th>
                                    <th>Item Temperature</th>
                                    <th>Item Quantity</th>
                                    <th>Item Unit Price</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                        </table>
                        <div class="row d-flex justify-content-end">
                            <h5 class="col fw-bold">Status: </h5>
                            <span class="col text-end fw-bold fs-5 ps-1" id="ordStat"></span>
                        </div>
                        <div class="row d-flex justify-content-end">
                            <h5 class="col fw-bold">Payment Method: </h5>
                            <span class="col text-end fw-bold fs-5 ps-1" id="ordPMethod"></span>
                        </div>
                        <div class="row d-flex justify-content-end">
                            <h5 class="col fw-bold">Total: </h5>
                            <span class="col text-end fw-bold fs-5 ps-1" id="ordTot"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="printBtn" type="button" class="me-auto btn btn-outline-secondary border-0 rounded-pill" onclick="printContent()" style="display:none;">Print</button>
                <button type="button" class="btn btn-outline-danger border-0 rounded-pill closeViewItm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php
include($ROOTPATH . '/internal/footer.php');
?>