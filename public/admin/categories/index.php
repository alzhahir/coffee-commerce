<?php
session_start();
$pageTitle = "Ahvelo Admin - Categories";
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
        CATEGORIES
        <button type="button" class="btn btn-primary ahvbutton float-end" data-bs-toggle="modal" data-bs-target="#newProd">
            + Add Category
        </button>
    </p>
    <script type="text/javascript">
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
        $(document).ready( function () {
            var mainTable = $('#catTable').DataTable({
                                ajax: {
                                    url: '/api/get/categories.php',
                                    dataSrc: 'data',
                                },
                                pagingType: 'full_numbers',
                                autoWidth: false,
                                responsive: true,
                                columnDefs: [
                                    {
                                        "defaultContent": '<button class="btn btn-primary ahvbutton">Edit Category</button>',
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
                                                            <p class="fw-bold fs-5 text-center">CATEGORY LISTING REPORT</p>
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
            $("#catTable tbody").on('click', 'button', function() {
                var updEndpoint = '/api/admin/update/categories.php';
                var data = mainTable.row($(this).parents()[0]).data();
                //window.location.href = "index.php?edit=true&app_id="+data[0];
                $('#editCatForm').attr('action', updEndpoint+'?cat_id='+data[0]);
                $('#edCatName').val(data[1]);
                $('#edCatImgUrl').val(data[2]);
                $('#editCatModal').modal('show');
            })
            new $.fn.dataTable.FixedHeader( mainTable );
        } );
    </script>
    <div class="px-4 py-4 bg-white rounded-4 shadow">
        <table id="catTable" class="table table-bordered table-hover dt-responsive">
            <thead>
                <tr>
                    <th>Category ID</th>
                    <th>Category Name</th>
                    <th>Category Image URL</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- MODAL FOR EDITING PRODUCTS -->
<div class="modal fade" id="editCatModal" tabindex="-1" aria-labelledby="editProduct" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fw-black" id="editProduct">EDIT CATEGORY</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="col pb-3">
                    <p>You can use this form to edit categories.</p>
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
                    <form id="editCatForm" action="/api/admin/update/categories.php" method="post">
                        <div class="form-floating mb-3">
                            <input id="edCatName" class="form-control" name="catName" type="text" placeholder="Product Name" required/>
                            <label for="catName">Category Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input id="edCatImgUrl" class="form-control" name="catImgUrl" type="text" placeholder="Product Image URL"/>
                            <label for="catImgUrl">Category Image URL</label>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="me-auto btn btn-outline-danger border-0 rounded-pill" data-bs-target="#delProductModal" data-bs-toggle="modal">Delete Product</button>
                <button type="button" class="btn btn-outline-secondary border-0 rounded-pill" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-primary ahvbutton" form="editCatForm" id="catUpdateButton" type="submit">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL FOR NEW PRODUCTS -->
<div class="modal fade" id="newProd" tabindex="-1" aria-labelledby="createNewProduct" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fw-black" id="createNewProduct">CREATE NEW CATEGORY</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="col pb-3">
                    <p>You can use this form to create new categories.</p>
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
                    <form id="newProdForm" action="/api/admin/create/category.php" method="post">
                        <div class="form-floating mb-3">
                            <input class="form-control" name="catName" type="text" placeholder="Product Name" required/>
                            <label for="catName">Category Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" name="catImgUrl" type="text" placeholder="Product Image URL"/>
                            <label for="catImgUrl">Category Image URL</label>
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