<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if(!isset($ROOTPATH)){
    $ROOTPATH = $_SERVER["DOCUMENT_ROOT"] . '/..';
}

$currentPath = $_SERVER['REQUEST_URI'];
$parentDirs = explode("/", $currentPath);
foreach($parentDirs as $thisDir){
    if(str_contains($thisDir, "api")){
        $isApiPage = true;
        break;
    } else {
        $isApiPage = false;
    }
}

$userType = "";
if(isset($isApiPage) && $isApiPage){
    include($ROOTPATH . '/internal/htmlhead.php');
    include($ROOTPATH . '/internal/apiheader.php');
} else if(isset($_SESSION["utype"])){
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