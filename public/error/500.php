<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$ROOTPATH = $_SERVER["DOCUMENT_ROOT"] . '/..';
include($ROOTPATH . '/internal/errorcontrol.php');
?>
<div class="px-3 my-auto">
    <div style="margin:auto; text-align:center; width:50%;">
        <span class="material-symbols-outlined" style="margin:auto;display:inline-block;font-size:96px;">
            unknown_document
        </span>
        <p class="h3 fw-medium user-select-none">The server is experiencing some issues. Please try again later.</p>
        <a href="/<?php echo($userType); ?>index.php" class="rounded-pill btn btn-outline-danger">RETURN HOME</a>
    </div>
</div>
<?php
include($ROOTPATH . '/internal/footer.php');
?>