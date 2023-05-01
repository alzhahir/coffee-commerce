<?php
    session_start();
    if(!isset($_SESSION["uid"])){
        header('X-PHP-Response-Code: 401', true, 401);
        die();
    }
    if(!isset($_SESSION["cust_id"])){
        header('X-PHP-Response-Code: 403', true, 403);
        die();
    }
    require_once "../../../../internal/db.php";

    if($_SERVER["REQUEST_METHOD"] == "GET"){
        $cid = $_SESSION["cust_id"];
        $getOrdSQL = "SELECT order_id, order_date, order_time, order_status, order_total FROM orders WHERE cust_id = $cid";
        $ordRes = mysqli_query($conn, $getOrdSQL);
        if(!is_bool($ordRes)){
            $outputOrdId = array();
            $outputOrdDate = array();
            $outputOrdTime = array();
            $outputOrdStatus = array();
            $outputOrdTotal = array();
            $outputOrdArr = array();
            $ordArr = mysqli_fetch_all($ordRes);
            $ordArr = array_values($ordArr);
            foreach($ordArr as $currOrd){
                array_push($outputOrdId, $currOrd[0]);
                array_push($outputOrdDate, $currOrd[1]);
                array_push($outputOrdTime, $currOrd[2]);
                array_push($outputOrdStatus, $currOrd[3]);
                array_push($outputOrdTotal, $currOrd[4]);
            }
            $outputOrdArr = array(
                "ordId" => $outputOrdId,
                "ordDate" => $outputOrdDate,
                "ordTime" => $outputOrdTime,
                "ordStatus" => $outputOrdStatus,
                "ordTotal" => $outputOrdTotal,
            );
        } else {
            $ordArr = array("0" => "Error");
            header('X-PHP-Response-Code: 500', true, 500);
            die();
        }

        header("Content-Type: application/json");
        echo json_encode($outputOrdArr);
        die();
    }
    else {
        header('X-PHP-Response-Code: 405', true, 405);
        die();
    }
?>