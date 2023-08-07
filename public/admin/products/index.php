<?php
session_start();
$pageTitle = "Ahvelo Admin - Products";
$ROOTPATH = $_SERVER["DOCUMENT_ROOT"] . '/..';
include($ROOTPATH . '/internal/admincontrol.php');
include($ROOTPATH . '/internal/htmlhead.php');
include($ROOTPATH . '/internal/adminheader.php');
?>
<div class="px-3">
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
        if(isset($_GET["signup"])){
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
        PRODUCTS
        <button type="button" class="btn btn-primary ahvbutton float-end" data-bs-toggle="modal" data-bs-target="#newProd">
            + Add Product
        </button>
    </p>
    <div class="w-100 pb-4 mb-2 position-relative">
        <div class='position-absolute top-50 start-50 translate-middle'>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="prodStockOptions" id="allChoice" value="all" checked>
                <label class="form-check-label" for="allChoice">All</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="prodStockOptions" id="customerChoice" value="outstock">
                <label class="form-check-label" for="outStockChoice">Out of Stock</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="prodStockOptions" id="empChoice" value="instock">
                <label class="form-check-label" for="inStockChoice">In Stock</label>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        var pid;
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
        $(document).ready( function () {
            function renderProdTable(apiEndpoint){
                mainTable = $('#prodTable').DataTable({
                    ajax: {
                        url: apiEndpoint,
                        dataSrc: 'data',
                    },
                    pagingType: 'full_numbers',
                    autoWidth: false,
                    responsive: true,
                    columnDefs: [
                        {
                            targets: 2,
                            visible: false,
                        },
                        {
                            targets: 5,
                            visible: false,
                        },
                        {
                            "defaultContent": '<button class="btn btn-primary ahvbutton"><span class="material-symbols-outlined align-middle text-center px-0">edit</span><span class="align-middle text-center ps-1">Edit</span></button>',
                            "targets": -1
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
                                    4,
                                    5
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
                                                <p class="fw-bold fs-5 text-center">PRODUCT LISTING REPORT</p>
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
            }
            apiEndpoint = '/api/get/products.php';
            renderProdTable(apiEndpoint)
            $('input[name=prodStockOptions]').change(function(){
                mainTable.destroy();
                var choice = $('input[name=prodStockOptions]:checked').val();
                if(choice == 'all'){
                    apiEndpoint = '/api/get/products.php';
                } else if(choice == 'outstock') {
                    apiEndpoint = '/api/get/products.php?in_stock=false';
                } else if(choice == 'instock') {
                    apiEndpoint = '/api/get/products.php?in_stock=true'
                }
                renderProdTable(apiEndpoint);
            })
            $("#prodTable tbody").on('click', 'button', function() {
                var updEndpoint = '/api/admin/update/products.php';
                var data = mainTable.row($(this).parents()[0]).data();
                //window.location.href = "index.php?edit=true&app_id="+data[0];
                pid = data[0];
                $('#editProdForm').attr('action', updEndpoint+'?prod_id='+data[0]);
                $('#edProdName').val(data[1]);
                $('#edProdImgUrl').val(data[2]);
                $('#edProdPrice').val(data[3]);
                $('#edProdStock').val(data[4]);
                $('#catlist').val(data[5]);
                if(data[7] == "Hot"){
                    $("#edProdHot").prop('checked', true);
                    $("#edProdCold").prop('checked', false);
                } else if (data[7] == "Cold"){
                    $("#edProdHot").prop('checked', false);
                    $("#edProdCold").prop('checked', true);
                } else if (data[7] == "Hot, Cold"){
                    $("#edProdHot").prop('checked', true);
                    $("#edProdCold").prop('checked', true);
                }
                $('#editProd').modal('show');
            })
            new $.fn.dataTable.FixedHeader( mainTable );
        } );
        function deleteItem(){
            $.ajax('/api/admin/delete/product.php?prod_id='+pid, {
                type: 'POST',
                data: {
                    id: pid
                },
                success: function(){
                    $('#delProductModal').modal('hide');
                    location.reload();
                },
                fail: function(){
                    console.log("Failed to delete product.")
                }
            })
        }
    </script>
    <div class="px-4 py-4 bg-white rounded-4 shadow">
        <table id="prodTable" class="table table-bordered table-hover dt-responsive">
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Product Image URL</th>
                    <th>Product Price</th>
                    <th>Product Stock</th>
                    <th>Product Category ID</th>
                    <th>Product Category</th>
                    <th>Temperature</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- MODAL FOR EDITING PRODUCTS -->
<div class="modal fade" id="editProd" tabindex="-1" aria-labelledby="editProduct" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fw-black" id="editProduct">EDIT PRODUCT</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="col pb-3">
                    <p>You can use this form to edit products.</p>
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
                    <form id="editProdForm" action="/api/admin/update/products.php" method="post">
                        <div class="form-floating mb-3">
                            <input id="edProdName" class="form-control" name="prodName" type="text" placeholder="Product Name" required/>
                            <label for="prodName">Product Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input id="edProdImgUrl" class="form-control" name="prodImgUrl" type="text" placeholder="Product Image URL"/>
                            <label for="prodImgUrl">Product Image URL</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input id="edProdPrice" class="form-control" name="prodPrice" type="text" placeholder="Product Price" required/>
                            <label for="prodPrice">Unit Price</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input id="edProdStock" class="form-control" name="prodStock" type="text" placeholder="Stock Amount" required/>
                            <label for="prodStock">Stock Amount</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-select" name="catId" id="catlist" aria-label="Categories">
                                <option value=""></option>
                                <!--Code here-->
                            </select>
                            <label for="catId">Categories</label>
                        </div>
                        <div class="mb-3">
                            <label class="form-label d-block">Temperature</label>
                            <div class="form-check form-check-inline">
                                <input id="edProdHot" class="form-check-input" type="checkbox" name="isHot" value='1'/>
                                <label class="form-check-label" for="isHot">Hot</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input id="edProdCold" class="form-check-input" type="checkbox" name="isCold" value='2'/>
                                <label class="form-check-label" for="isCold">Cold</label>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="me-auto btn btn-outline-danger border-0 rounded-pill" data-bs-target="#delProductModal" data-bs-toggle="modal"><span class="material-symbols-outlined align-middle text-center px-0">delete_forever</span><span class="align-middle text-center ps-1">Delete</span></button>
                <button type="button" class="btn btn-outline-secondary border-0 rounded-pill" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-primary ahvbutton" form="editProdForm" id="signUpButton" type="submit">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL TO DELETE STUFF -->
<div class="modal fade" id="delProductModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
            <h3 class="modal-title fw-black" id="delProduct">DELETE PRODUCT</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body row">
                <div class="col col-auto pe-2 h-100">
                    <span class="material-symbols-outlined filled text-danger align-middle text-center px-0 py-auto" style="font-size:48px;">
                        warning
                    </span>
                </div>
                <div class="col ps-0">
                    <span class="fs-5">Are you sure that you want to delete this product?</span><br>
                    <span class="fs-5 fw-bold">THIS ACTION IS IRREVERSIBLE!</span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary border-0 rounded-pill" data-bs-dismiss="modal">Cancel</button>
                <button id="delProdBtn" class="btn btn-danger rounded-pill" onclick="deleteItem()">YES, DELETE PRODUCT</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL FOR NEW PRODUCTS -->
<div class="modal fade" id="newProd" tabindex="-1" aria-labelledby="createNewProduct" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fw-black" id="createNewProduct">CREATE NEW PRODUCT</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="col pb-3">
                    <p>You can use this form to create new products.</p>
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
                    <form id="newProdForm" action="/api/admin/create/product.php" method="post">
                        <div class="form-floating mb-3">
                            <input class="form-control" name="prodName" type="text" placeholder="Product Name" required/>
                            <label for="prodName">Product Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" name="prodImgUrl" type="text" placeholder="Product Image URL"/>
                            <label for="prodImgUrl">Product Image URL</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" name="prodPrice" type="text" placeholder="Product Price" required/>
                            <label for="prodPrice">Unit Price</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" name="prodStock" type="text" placeholder="Stock Amount" required/>
                            <label for="prodStock">Stock Amount</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-select" name="catId" id="catlist2" aria-label="Categories">
                                <option value=""></option>
                                <!--Code here-->
                            </select>
                            <label for="catId">Categories</label>
                        </div>
                        <div class="mb-3">
                            <label class="form-label d-block">Temperature</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="isHot" value="1" checked='true'/>
                                <label class="form-check-label" for="isHot">Hot</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="isCold" value="2" checked='true'/>
                                <label class="form-check-label" for="isCold">Cold</label>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary border-0 rounded-pill" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-primary ahvbutton" form="newProdForm" id="signUpButton" type="submit">Save changes</button>
            </div>
        </div>
    </div>
</div>
<script>
    var xmlhttp = new XMLHttpRequest();
    var url = "/api/get/categories.php";

    xmlhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            var data = JSON.parse(this.responseText);
            var dataCat = data.data;
            var htmlData = "<option value=\"\"></option>";
            for(let i = 0; i < dataCat.length; i++){
                htmlData = htmlData.concat("\n", "<option value=\""+dataCat[i][0]+"\">"+dataCat[i][1]+"</option>\n");
            }
            document.getElementById("catlist").innerHTML = htmlData;
            document.getElementById("catlist2").innerHTML = htmlData;
        }
    }
    xmlhttp.open("GET", url, true);
    xmlhttp.send();

    $(window).on('load', function(){
        <?php
            if(isset($_GET["prodstat"])){
                //error exists
                echo "$('#newProd').modal('show');";
            }
        ?>
    })
    $('#newProd').on('hidden.bs.modal', function(){
        let url = new URL(window.location.href);
        url.searchParams.delete('prodstat');
        //url.searchParams.delete('');
        window.history.pushState({}, document.title, url);
        document.location.reload();
    })
</script>
<?php
include($ROOTPATH . '/internal/footer.php');
?>