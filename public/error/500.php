<?php
session_start();
$userType = $_SESSION["utype"];
switch($userType){
    case "customer":
        include('../../internal/htmlhead.php');
        include('../../internal/header.php');
        break;
    case "staff": //staff
        include('../../internal/staffcontrol.php');
        include('../../internal/htmlhead.php');
        include('../../internal/staffheader.php');
        break;
    case "admin": //admin
        include('../../internal/admincontrol.php');
        include('../../internal/htmlhead.php');
        include('../../internal/adminheader.php');
        break;
}
?>
<div class="px-3 my-auto">
    <div style="margin:auto; text-align:center; width:50%;">
        <span class="material-symbols-outlined" style="margin:auto;display:inline-block;font-size:96px;">
            unknown_document
        </span>
        <p class="h3 fw-medium user-select-none">The server is experiencing some issues. Please try again later.</p>
        <a href="/<?php echo($_SESSION["utype"]); ?>/index.php" class="btn btn-outline-danger">RETURN HOME</a>
    </div>
</div>
<?php
include('../../internal/footer.php');
?>