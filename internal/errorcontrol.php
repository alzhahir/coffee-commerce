<?php
session_start();
if(!isset($ROOTPATH)){
    $ROOTPATH = $_SERVER["DOCUMENT_ROOT"] . '/..';
}
$userType = "";
if(isset($_SESSION["utype"])){
    $userType = $_SESSION["utype"];
    switch($userType){
        case "customer":
            $userType = $_SESSION["utype"] . "/";
            include($ROOTPATH . '/internal/htmlhead.php');
            include($ROOTPATH . '/internal/header.php');
            break;
        case "staff": //staff
            $userType = $_SESSION["utype"] . "/";
            include($ROOTPATH . '/internal/staffcontrol.php');
            include($ROOTPATH . '/internal/htmlhead.php');
            include($ROOTPATH . '/internal/staffheader.php');
            break;
        case "admin": //admin
            $userType = $_SESSION["utype"] . "/";
            include($ROOTPATH . '/internal/admincontrol.php');
            include($ROOTPATH . '/internal/htmlhead.php');
            include($ROOTPATH . '/internal/adminheader.php');
            break;
    }
} else {
    include($ROOTPATH . '/internal/htmlhead.php');
    include($ROOTPATH . '/internal/header.php');
}
?>