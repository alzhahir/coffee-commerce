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
    <script type="text/javascript">
        $(document).ready( function () {
            var mainTable = $('#usrTable').DataTable({
                                order: [[0, 'asc']],
                                autoWidth: false,
                                responsive: true,
                                ajax: {
                                    url: '/api/admin/get/users.php',
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
                                                    '<div><span class="h1 fw-black">AHVELO COFFEE ORDERS<span></div>'
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