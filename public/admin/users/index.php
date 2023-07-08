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
                                                        '<div><span class="h1 fw-black">AHVELO COFFEE USERS<span></div>'
                                                    )
                                                    .append('<footer class="">Ahvelo Coffee Orders</div>');

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
        });
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
                </tr>
            </thead>
        </table>
    </div>
</div>
<?php
include($ROOTPATH . '/internal/footer.php');
?>