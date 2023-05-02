<?php
session_start();
$ROOTPATH = $_SERVER["DOCUMENT_ROOT"] . '/..';
include($ROOTPATH . '/internal/htmlhead.php');
include($ROOTPATH . '/internal/header.php');
$userType = "";
if(isset($_SESSION['utype'])){
    $userType = $_SESSION['utype'] . "/";
}
?>
<div class="px-3 my-auto">
    <div style="margin:auto; text-align:center; width:50%;">
        <span class="material-symbols-outlined" style="margin:auto;display:inline-block;font-size:96px;">
            block
        </span>
        <p class="h3 fw-medium user-select-none">You must be authenticated to access this service.</p>
        <a href="/<?php echo($userType); ?>index.php" class="btn btn-outline-danger">RETURN HOME</a>
    </div>
</div>
<?php
include($ROOTPATH . '/internal/footer.php');
?>