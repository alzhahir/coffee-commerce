<?php
//use this page to store useful variables for global API use
$SERVERROOT = $_SERVER["DOCUMENT_ROOT"]; //server root, /public/
$PROJECTROOT = $_SERVER["DOCUMENT_ROOT"] . '/..';
$isApiPage = true;
//http_response_code(401);
//include($SERVERROOT . "/error/401.php");
include($PROJECTROOT . "/internal/htmlhead.php");
include($PROJECTROOT . "/internal/apiheader.php");
?>
<div class="px-3">
    <div class="h3 fw-black">
        AHVELO COFFEE API
    </div>
    <div>
        Welcome to Ahvelo Coffee API landing page.
    </div>
</div>
<?php
include($PROJECTROOT . "/internal/footer.php")
?>