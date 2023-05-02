<?php
session_start();
if (isset($_SESSION["emp_id"])){
    include('../../public/error/403.php');
    die();
}
if (!isset($_SESSION["cust_id"])){
    $_SESSION["userErrCode"] = "CUST_ID_NOT_SET";
    $_SESSION["userErrMsg"] = "The session has expired or is invalid. Please login again. Do contact the administrator if you believe that this should not happen.";
    header("refresh:0;url=/signup.php?error=true");
    die();
}
?>