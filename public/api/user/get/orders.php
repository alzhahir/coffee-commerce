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
        if(isset($_GET['order_id'])){
            if(!is_numeric($_GET['order_id'])){
                http_response_code(400);
                die();
            }
            $ordId = $_GET['order_id'];
            $getOrdSQL = "SELECT order_id, order_date, order_time, order_status, order_total, payment_id FROM orders WHERE order_id = $ordId AND cust_id = $cid";
            $ordRes = mysqli_query($conn, $getOrdSQL);
            if(!is_bool($ordRes)){
                if(mysqli_num_rows($ordRes) == 0){
                    http_response_code(404);
                    header("Content-Type: application/json");
                    echo json_encode(array(
                        'data' => [],
                    ));
                    die();
                }
                $outputItmArr = array();
                $outputOrdArr = array();
                $ordArr = mysqli_fetch_all($ordRes);
                $ordArr = array_values($ordArr);
                $getOrdItmSQL = "SELECT prod_id, ord_list_temp, ord_list_qty, ord_list_price, ord_list_amt FROM order_lists WHERE order_id = $ordId";
                $ordItmRes = mysqli_query($conn, $getOrdItmSQL);
                if(!is_bool($ordItmRes)){
                    $ordItmArr = mysqli_fetch_all($ordItmRes);
                    $ordItmArr = array_values($ordItmArr);
                    foreach($ordItmArr as $currItm){
                        $getProdSQL = "SELECT prod_name, prod_img_url FROM products WHERE prod_id = $currItm[0]";
                        $prodRes = mysqli_query($conn, $getProdSQL);
                        if(!is_bool($prodRes)){
                            $prodArr = mysqli_fetch_all($prodRes);
                            $prodArr = array_values($prodArr);
                            foreach($prodArr as $currProd){
                                $prodName = $currProd[0];
                                $prodImg = $currProd[1];
                            }
                        }
                        if(!isset($prodName) || $prodName == null){
                            $prodName = "null";
                            $prodImg = "null";
                        }
                        $displayTemp = null;
                        switch($currItm[1]){
                            case 1:
                                $displayTemp = "Hot";
                                break;
                            case 2:
                                $displayTemp = "Cold";
                                break;
                            default:
                                $displayTemp = null;
                                break;
                        }
                        array_push($outputItmArr, array_values(array(
                            "id" => $currItm[0],
                            "name" => $prodName,
                            "temperature" => $displayTemp,
                            "quantity" => $currItm[2],
                            "price" => number_format($currItm[3],2),
                            "subtotal" => number_format($currItm[4],2),
                            "img" => $prodImg,
                        )));
                    }
                } else {
                    $ordArr = array("0" => "Error");
                    header('X-PHP-Response-Code: 500', true, 500);
                    die();
                }
                foreach($ordArr as $currOrd){
                    $getPaymSQL = "SELECT payment_method, payment_txn_url FROM payments WHERE payment_id = $currOrd[5]";
                    $paymRes = mysqli_query($conn, $getPaymSQL);
                    if(!is_bool($paymRes)){
                        $paymArr = mysqli_fetch_all($paymRes);
                        $paymArr = array_values($paymArr);
                        foreach($paymArr as $currPaym){
                            $payMethod = $currPaym[0];
                            $payURL = $currPaym[1];
                        }
                    }
                    $outputOrdArr = array(
                        "id" => $currOrd[0],
                        "date" => $currOrd[1],
                        "time" => $currOrd[2],
                        "status" => $currOrd[3],
                        "total" => number_format($currOrd[4],2),
                        "paymentMethod" => $payMethod,
                        "paymentLink" => $payURL,
                        "data" => $outputItmArr,
                    );
                }
            } else {
                $ordArr = array("0" => "Error");
                header('X-PHP-Response-Code: 500', true, 500);
                die();
            }
        } else {
            $getOrdSQL = "SELECT order_id, order_date, order_time, order_status, order_total, payment_id FROM orders WHERE cust_id = $cid";
            $ordRes = mysqli_query($conn, $getOrdSQL);
            if(!is_bool($ordRes)){
                $outputItmArr = array();
                $outputOrdArr = array();
                $ordArr = mysqli_fetch_all($ordRes);
                $ordArr = array_values($ordArr);
                foreach($ordArr as $currOrd){
                    $getPaymSQL = "SELECT payment_method, payment_txn_url FROM payments WHERE payment_id = $currOrd[5]";
                    $paymRes = mysqli_query($conn, $getPaymSQL);
                    if(!is_bool($paymRes)){
                        $paymArr = mysqli_fetch_all($paymRes);
                        $paymArr = array_values($paymArr);
                        foreach($paymArr as $currPaym){
                            $payMethod = $currPaym[0];
                            $payURL = $currPaym[1];
                        }
                    }
                    array_push($outputOrdArr, array_values(array(
                        "id" => $currOrd[0],
                        "date" => $currOrd[1],
                        "time" => $currOrd[2],
                        "status" => $currOrd[3],
                        "total" => number_format($currOrd[4],2),
                        "paymentMethod" => $payMethod,
                        "paymentLink" => $payURL,
                    )));
                }
                $outputOrdArr = array(
                    "data" => $outputOrdArr
                );
            } else {
                $ordArr = array("0" => "Error");
                header('X-PHP-Response-Code: 500', true, 500);
                die();
            }
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