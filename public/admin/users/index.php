<?php
session_start();
$ROOTPATH = $_SERVER["DOCUMENT_ROOT"] . '/..';
include($ROOTPATH . '/internal/admincontrol.php');
include($ROOTPATH . '/internal/htmlhead.php');
include($ROOTPATH . '/internal/adminheader.php');
?>
<div class="px-3">
    <p class="h3 fw-black">
        USERS
        <a class="btn btn-primary ahvbutton float-end" href="new.php">
            + Add User
        </a>
    </p>
    <div class="w-100 pb-4 mb-2 position-relative">
        <div class='position-absolute top-50 start-50 translate-middle'>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="userTypeOptions" id="allChoice" value="all" checked>
                <label class="form-check-label" for="allChoice">All</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="userTypeOptions" id="customerChoice" value="customer">
                <label class="form-check-label" for="customerChoice">Customer</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="userTypeOptions" id="empChoice" value="employees">
                <label class="form-check-label" for="empChoice">Employee</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="userTypeOptions" id="staffChoice" value="staff">
                <label class="form-check-label" for="staffChoice">Staff</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="userTypeOptions" id="adminChoice" value="admin">
                <label class="form-check-label" for="adminChoice">Admin</label>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        var uid;
        $(document).ready( function () {
            function renderUserTable(apiEndpoint){
                mainTable = $('#usrTable').DataTable({
                                    order: [[0, 'asc']],
                                    autoWidth: false,
                                    responsive: true,
                                    ajax: {
                                        url: apiEndpoint,
                                        dataSrc: 'data',
                                    },
                                    columnDefs: [
                                        {
                                            targets: 5,
                                            visible: false,
                                        },
                                        {
                                            "defaultContent": '<button class="btn btn-primary ahvbutton">Edit User</button>',
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
                                                                <p class="fw-bold fs-5 text-center">USER LISTING REPORT</p>
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
                new $.fn.dataTable.FixedHeader( mainTable );
            }
            apiEndpoint = '/api/admin/get/users.php'
            renderUserTable(apiEndpoint)
            $('input[name=userTypeOptions]').change(function(){
                mainTable.destroy();
                var choice = $('input[name=userTypeOptions]:checked').val();
                if(choice == 'all'){
                    apiEndpoint = '/api/admin/get/users.php';
                } else {
                    apiEndpoint = '/api/admin/get/users.php?type='+choice;
                }
                renderUserTable(apiEndpoint);
            })
            //
            $("#usrTable tbody").on('click', 'button', function() {
                var updEndpoint = '/api/admin/update/users.php';
                var data = mainTable.row($(this).parents()[0]).data();
                //window.location.href = "index.php?edit=true&app_id="+data[0];
                uid = data[0];
                $('#editUsrForm').attr('action', updEndpoint+'?user_id='+data[0]);
                $('#edUsrName').val(data[2]);
                $('#edUsrEmail').val(data[3]);
                $('#edUsrPhone').val(data[5]);
                $('#editUserModal').modal('show');
            })
        });
        function deleteItem(){
            $.ajax('/api/admin/delete/user.php?user_id='+uid, {
                type: 'POST',
                data: {
                    id: uid
                },
                success: function(){
                    $('#delItemModal').modal('hide');
                    location.reload();
                },
                fail: function(){
                    console.log("Failed to delete customer.")
                }
            })
        }
    </script>
    <div class="px-3 py-4 bg-white rounded-4 shadow">
        <table id="usrTable" class="table table-bordered table-hover dt-responsive">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Role ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Gender</th>
                    <th>Phone</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- MODAL FOR EDITING USERS -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUser" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fw-black" id="editUser">EDIT PRODUCT</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="col pb-3">
                    <p>You can use this form to edit products. Gender and date of birth cannot be edited.</p>
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
                    <form id="editUsrForm" action="/api/admin/update/products.php" method="post">
                        <div class="form-floating mb-3">
                            <input id="edUsrName" class="form-control" name="name" type="text" placeholder="Product Name" required/>
                            <label for="name">User Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input id="edUsrEmail" class="form-control" name="email" type="text" placeholder="Product Price" required/>
                            <label for="email">User Email</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input id="edUsrPhone" class="form-control" name="phone" type="text" placeholder="Stock Amount" required/>
                            <label for="phone">User Phone</label>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="me-auto btn btn-outline-danger border-0 rounded-pill" data-bs-target="#delItemModal" data-bs-toggle="modal">Delete</button>
                <button type="button" class="btn btn-outline-secondary border-0 rounded-pill" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-primary ahvbutton" form="editUsrForm" id="signUpButton" type="submit">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL TO DELETE STUFF -->
<div class="modal fade" id="delItemModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
            <h3 class="modal-title fw-black" id="delItem">DELETE USER</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure that you want to delete this user? THIS ACTION IS IRREVERSIBLE!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary border-0 rounded-pill" data-bs-dismiss="modal">Cancel</button>
                <button id="delItmBtn" class="btn btn-danger rounded-pill" onclick="deleteItem()">Yes</button>
            </div>
        </div>
    </div>
</div>

<?php
include($ROOTPATH . '/internal/footer.php');
?>