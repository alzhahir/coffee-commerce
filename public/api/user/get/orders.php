<?php
    session_start();
    $SERVERROOT = $_SERVER["DOCUMENT_ROOT"];
    $PROJECTROOT = $_SERVER["DOCUMENT_ROOT"] . '/..';
    if(!isset($_SESSION["uid"])){
        http_response_code(401);
        include($SERVERROOT . "/error/401.php");
        die();
    }
    if(!isset($_SESSION["cust_id"])){
        http_response_code(403);
        include($SERVERROOT . "/error/403.php");
        die();
    }
    require_once $PROJECTROOT . "/internal/db.php";

    if($_SERVER["REQUEST_METHOD"] == "GET"){
        $cid = $_SESSION["cust_id"];
        $getOrdSQL = "SELECT order_id, order_date, order_time, order_status, order_total FROM orders WHERE cust_id = $cid";
        $ordRes = mysqli_query($conn, $getOrdSQL);
        if(!is_bool($ordRes)){
            $outputItmArr = array();
            $outputOrdArr = array();
            $ordArr = mysqli_fetch_all($ordRes);
            $ordArr = array_values($ordArr);
            foreach($ordArr as $currOrd){
                $oid = $currOrd[0];
                $getOrdItmSQL = "SELECT prod_id, ord_list_qty, ord_list_price, ord_list_amt FROM order_lists WHERE order_id = $oid";
                $ordItmRes = mysqli_query($conn, $getOrdItmSQL);
                if(!is_bool($ordItmRes)){
                    $ordItmArr = mysqli_fetch_all($ordItmRes);
                    $ordItmArr = array_values($ordItmArr);
                    foreach($ordItmArr as $currItm){
                        array_push($outputItmArr, array_values(array(
                            "id" => $currItm[0],
                            "quantity" => $currItm[1],
                            "price" => $currItm[2],
                            "subtotal" => $currItm[3],
                        )));
                    }
                } else {
                    $ordArr = array("0" => "Error");
                    header('X-PHP-Response-Code: 500', true, 500);
                    die();
                }
                array_push($outputOrdArr, array_values(array(
                    "id" => $currOrd[0],
                    "date" => $currOrd[1],
                    "time" => $currOrd[2],
                    "status" => $currOrd[3],
                    "total" => $currOrd[4],
                    "items" => $outputItmArr,
                )));
            }
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