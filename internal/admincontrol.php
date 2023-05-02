<?php
session_start();
if (isset($_SESSION["cust_id"])){
    include('../../public/error/403.php');
    die();
}
if (!isset($_SESSION["emp_id"])){
    $_SESSION["userErrCode"] = "EMP_ID_NOT_SET";
    $_SESSION["userErrMsg"] = "The session has expired or is invalid. Please login again. Do contact the administrator if you believe that this should not happen.";
    header("refresh:0;url=/signup.php?error=true");
    die();
}
if (!isset($_SESSION["utype"])){
    $_SESSION["userErrCode"] = "UTYPE_NOT_SET";
    $_SESSION["userErrMsg"] = "Invalid user configuration. Please login again. Do contact the administrator if you believe that this should not happen.";
    header("refresh:0;url=/signup.php?error=true");
    die();
}
if (isset($_SESSION["utype"]) && $_SESSION["utype"] != "admin"){
    include('../../public/error/403.php');
    die();
}
?>