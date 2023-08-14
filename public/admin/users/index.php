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
        <button class="btn btn-primary ahvbutton float-end" data-bs-toggle="modal" data-bs-target="#newUser">
            + Add User
        </button>
    </p>
    <?php 
        $_SESSION["backPage"] = $_SERVER["PHP_SELF"];
        //check if $_GET isset
        if(isset($_GET["error"])){
            if($_GET["error"] == "true"){
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
    <div class="w-100 pb-4 mb-2 position-relative">
        <div class='text-nowrap position-absolute top-50 start-50 translate-middle'>
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
                <h3 class="modal-title fw-black" id="editUser">EDIT USER</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="col pb-3">
                    <p>You can use this form to edit users. Gender and date of birth cannot be edited.</p>
                    <?php 
                        $_SESSION["backPage"] = $_SERVER["PHP_SELF"];
                        //check if $_GET isset
                        if(isset($_GET["error"])){
                            if($_GET["error"] == "true"){
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
                    <form id="editUsrForm" action="/api/admin/update/users.php" method="post">
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
                <button type="button" class="me-auto btn btn-outline-danger border-0 rounded-pill" data-bs-target="#delItemModal" data-bs-toggle="modal"><span class="material-symbols-outlined align-middle text-center px-0">delete_forever</span><span class="align-middle text-center ps-1">Delete</span></button>
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
            <div class="modal-body row">
                <div class="col col-auto pe-2">
                    <span class="material-symbols-outlined filled text-danger align-middle text-center px-0 py-auto" style="font-size:48px;">
                        warning
                    </span>
                </div>
                <div class="col ps-0">
                    <span class="fs-5">Are you sure that you want to delete this user?</span><br>
                    <span class="fs-5 fw-bold">THIS ACTION IS IRREVERSIBLE!</span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary border-0 rounded-pill" data-bs-dismiss="modal">Cancel</button>
                <button id="delItmBtn" class="btn btn-danger rounded-pill" onclick="deleteItem()">YES, DELETE USER</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL FOR NEW USER -->
<div class="modal fade" id="newUser" tabindex="-1" aria-labelledby="createNewUser" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fw-black" id="createNewUser">CREATE NEW USER</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="col pb-3">
                    <p>You can use this form to create new users.</p>
                    <form id="signupForm" action="/api/auth/signup.php?admin_mode=true" method="post">
                        <div class="form-floating mb-3">
                            <input class="form-control" name="email" type="email" placeholder="Email Address" required/>
                            <label for="emailAddress">Email Address</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" name="password" type="password" placeholder="Password" required/>
                            <label for="password">Password</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" name="confirmPassword" type="password" placeholder="Confirm Password" required/>
                            <label for="password">Confirm Password</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" name="name" type="text" placeholder="Name" required/>
                            <label for="name">Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" name="dob" type="date" placeholder="Date of Birth" required/>
                            <label for="dob">Date of Birth</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-select" name="gender" aria-label="Gender">
                                <option value="0">Male</option>
                                <option value="1">Female</option>
                                <option value="2">Prefer not to say</option>
                            </select>
                            <label for="gender">Gender</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control number" name="telephone" type="text" placeholder="Telephone" onkeydown='{(evt) => ["e", "E", "-"].includes(evt.key) && evt.preventDefault()}' required/>
                            <label for="telephone">Telephone</label>
                        </div>
                        <!--The code below is left as is to enable the usage of doSignUp.php as a some sort of an API to allow other
                        forms to reuse the same code. (cant leave the role POST as null)-->
                        <div class="form-floating mb-3">
                            <select id="userRole" class="form-select" name="role" aria-label="Role">
                                <option value="0">Customer</option>
                                <option value="1">Staff</option>
                                <option value="2">Admin</option>
                            </select>
                            <label for="role">Role</label>
                        </div>
                        <div class="form-floating mb-3" id="posField" style="display: none;">
                            <select class="form-select" name="posid" id="poslist" aria-label="Club">
                                <option value=""></option>
                                <!--Code here-->
                            </select>
                            <label for="posid">Position</label>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary border-0 rounded-pill" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-primary ahvbutton" form="signupForm" id="signUpButton" type="submit">Save changes</button>
            </div>
        </div>
    </div>
</div>

<script type="application/javascript">
    var xmlhttp = new XMLHttpRequest();
    var url = "/api/get/positions.php";
    document.querySelector(".number").addEventListener("keypress", function (evt) {
        if (evt.which != 8 && evt.which != 0 && evt.which < 48 || evt.which > 57)
        {
            evt.preventDefault();
        }
    });

    xmlhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            var data = JSON.parse(this.responseText);
            var htmlData = "<option value=\"\"></option>";
            for(let i = 0; i < data.posId.length; i++){
                htmlData = htmlData.concat("\n", "<option value=\""+data.posId[i]+"\">"+data.posName[i]+"</option>\n");
            }
            document.getElementById("poslist").innerHTML = htmlData;
        }
    }
    xmlhttp.open("GET", url, true);
    xmlhttp.send();

    var roleSelection = document.getElementById('userRole');
    roleSelection.onchange = function(){
        if(roleSelection.selectedIndex === 1 || roleSelection.selectedIndex === 2) {
            document.getElementById('posField').style.display = "block";
            document.getElementById('poslist').required = true;
        } else {
            document.getElementById('posField').style.display = "none";
            document.getElementById('poslist').required = false;
        }
    }
</script>

<?php
include($ROOTPATH . '/internal/footer.php');
?>