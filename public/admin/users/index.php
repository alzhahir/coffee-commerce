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
</div>
<?php
include($ROOTPATH . '/internal/footer.php');
?>