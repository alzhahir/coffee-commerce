<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$ROOTPATH = $_SERVER["DOCUMENT_ROOT"] . '/..';
if (!isset($_SESSION["uid"])){
    http_response_code(401);
    include($ROOTPATH . '/public/error/401.php');
    die();
}
if (isset($_SESSION["emp_id"])){
    http_response_code(403);
    include($ROOTPATH . '/public/error/403.php');
    die();
}
if (!isset($_SESSION["cust_id"])){
    $_SESSION["userErrCode"] = "CUST_ID_NOT_SET";
    $_SESSION["userErrMsg"] = "The session has expired or is invalid. Please login again. Do contact the administrator if you believe that this should not happen.";
    header("refresh:0;url=/signup.php?error=true");
    http_response_code(401);
    die();
}
?>