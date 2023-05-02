<?php
session_start();
include('../../internal/htmlhead.php');
include('../../internal/header.php');
?>
<div class="px-3 my-auto">
    <div style="margin:auto; text-align:center; width:50%;">
        <span class="material-symbols-outlined" style="margin:auto;display:inline-block;font-size:96px;">
            shield_lock
        </span>
        <p class="h3 fw-medium user-select-none">Your account does not have the required privileges to access this page.</p>
        <a href="/<?php echo($_SESSION["utype"]); ?>/index.php" class="btn btn-outline-danger">RETURN HOME</a>
    </div>
</div>
<?php
include('../../internal/footer.php');
?>