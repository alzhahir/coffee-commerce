<?php
$SERVERROOT = $_SERVER["DOCUMENT_ROOT"];
$PROJECTROOT = $_SERVER["DOCUMENT_ROOT"] . '/..';
session_start();
include($PROJECTROOT . '/internal/htmlhead.php');
include($PROJECTROOT . '/internal/header.php');
?>
<div class="px-3 pb-3">
    <div class="px-2">
        <div class="fw-black row px-2 h2">PRODUCTS</div>
        <div>Order now!</div>
        <div id="prodcat" class="d-flex justify-content-center row row-cols-auto w-100 align-items-start">
            <?php
                include($PROJECTROOT . "/internal/productgalleryobject.php");
            ?>
        </div>
    </div>
</div>
<?php
include($PROJECTROOT . '/internal/footer.php');
?>