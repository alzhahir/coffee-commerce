<?php
$ROOTPATH = $_SERVER["DOCUMENT_ROOT"] . '/..';
$creds = parse_ini_file($ROOTPATH."/.ini");
date_default_timezone_set($creds['timezone']);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if(!isset($pageTitle)){
    $pageTitle = "Ahvelo Coffee - Welcome";
}
?>
<!DOCTYPE html>
<html lang="en" class="h-100">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="noindex">
        <title><?php echo($pageTitle) ?></title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
        <link rel="icon" type="image/x-icon" href="https://api.alzhahir.com/static/images/misc/ahvelo/favicon.ico">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
        <!-- DataTables -->
        <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.css" rel="stylesheet"/>
        <link href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.bootstrap5.css" rel="stylesheet"/>
        <link href="https://cdn.datatables.net/colreorder/1.6.2/css/colReorder.bootstrap5.css" rel="stylesheet"/>
        <link href="https://cdn.datatables.net/datetime/1.4.1/css/dataTables.dateTime.css" rel="stylesheet"/>
        <link href="https://cdn.datatables.net/fixedcolumns/4.2.2/css/fixedColumns.bootstrap5.css" rel="stylesheet"/>
        <link href="https://cdn.datatables.net/fixedheader/3.3.2/css/fixedHeader.bootstrap5.css" rel="stylesheet"/>
        <link href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap5.css" rel="stylesheet"/>
        <!-- Tempus Dominus Styles -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@eonasdan/tempus-dominus@6.4.4/dist/css/tempus-dominus.min.css" crossorigin="anonymous">
        <!-- PrintJS -->
        <link rel="stylesheet" href="https://printjs-4de6.kxcdn.com/print.min.css"/>
        <!-- Additional custom stylesheet -->
        <link href="/ahvelo-general.css" rel="stylesheet"/>
    </head>
    <body class="d-flex flex-column h-100">
        <script src='https://www.gstatic.com/firebasejs/8.10.1/firebase-app.js' type="application/javascript"></script>
        <script src='https://www.gstatic.com/firebasejs/8.10.1/firebase-messaging.js' type="application/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.js" integrity="sha512-6DC1eE3AWg1bgitkoaRM1lhY98PxbMIbhgYCGV107aZlyzzvaWCW1nJW2vDuYQm06hXrW0As6OGKcIaAVWnHJw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.min.js" integrity="sha384-heAjqF+bCxXpCWLa6Zhcp4fu20XoNIA98ecBC1YkdXhszjoejr5y9Q77hIrv8R9i" crossorigin="anonymous"></script>
        <!-- DataTables -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
        <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.bootstrap5.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.colVis.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.js"></script>
        <script src="https://cdn.datatables.net/colreorder/1.6.2/js/dataTables.colReorder.js"></script>
        <script src="https://cdn.datatables.net/datetime/1.4.1/js/dataTables.dateTime.js"></script>
        <script src="https://cdn.datatables.net/fixedcolumns/4.2.2/js/dataTables.fixedColumns.js"></script>
        <script src="https://cdn.datatables.net/fixedheader/3.3.2/js/dataTables.fixedHeader.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap5.js"></script>
        <!-- Tempus Dominus JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/@eonasdan/tempus-dominus@6.4.4/dist/js/tempus-dominus.min.js" crossorigin="anonymous"></script>
        <!-- PrintJS -->
        <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
        <!-- Google Charts -->
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <!-- Additional custom JavaScript -->
        <script src="/ahvelo-general.js"></script>