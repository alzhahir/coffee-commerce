<?php
    session_start();
    $SERVERROOT = $_SERVER["DOCUMENT_ROOT"];
    $PROJECTROOT = $_SERVER["DOCUMENT_ROOT"] . '/..';
    if(!isset($_SESSION["uid"])){
        http_response_code(401);
        include($SERVERROOT . "/error/401.php");
        die();
    }
    if(!isset($_SESSION["emp_id"])){
        http_response_code(403);
        include($SERVERROOT . "/error/403.php");
        die();
    }
    require_once $PROJECTROOT . "/internal/db.php";

    if($_SERVER["REQUEST_METHOD"] == "GET"){
        if(isset($_GET['cust_id'])){
            $cid = $_GET["cust_id"];
            $getOrdSQL = "SELECT order_id, order_date, order_time, order_status, order_total, payment_id, emp_id FROM orders WHERE cust_id = $cid";
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
                foreach($ordArr as $currOrd){
                    $getPaymSQL = "SELECT payment_method FROM payments WHERE payment_id = $currOrd[5]";
                    $paymRes = mysqli_query($conn, $getPaymSQL);
                    if(!is_bool($paymRes)){
                        $paymArr = mysqli_fetch_all($paymRes);
                        $paymArr = array_values($paymArr);
                        foreach($paymArr as $currPaym){
                            $payMethod = $currPaym[0];
                        }
                    }
                    array_push($outputOrdArr, array_values(array(
                        "id" => $currOrd[0],
                        "date" => $currOrd[1],
                        "time" => $currOrd[2],
                        "status" => $currOrd[3],
                        "total" => $currOrd[4],
                        "paymentMethod" => $payMethod,
                        "assignedemp" => $currOrd[6],
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
        } else if(isset($_GET['emp_id'])){
            $eid = $_GET["emp_id"];
            $getOrdSQL = "SELECT order_id, order_date, order_time, order_status, order_total, payment_id, cust_id FROM orders WHERE emp_id = $eid";
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
                foreach($ordArr as $currOrd){
                    $getPaymSQL = "SELECT payment_method FROM payments WHERE payment_id = $currOrd[5]";
                    $paymRes = mysqli_query($conn, $getPaymSQL);
                    if(!is_bool($paymRes)){
                        $paymArr = mysqli_fetch_all($paymRes);
                        $paymArr = array_values($paymArr);
                        foreach($paymArr as $currPaym){
                            $payMethod = $currPaym[0];
                        }
                    }
                    array_push($outputOrdArr, array_values(array(
                        "id" => $currOrd[0],
                        "date" => $currOrd[1],
                        "time" => $currOrd[2],
                        "status" => $currOrd[3],
                        "total" => $currOrd[4],
                        "paymentMethod" => $payMethod,
                        "cust" => $currOrd[6],
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
        } else if(isset($_GET['order_id'])){
            $ordId = $_GET['order_id'];
            $getOrdSQL = "SELECT order_id, order_date, order_time, order_status, order_total, payment_id, cust_id FROM orders WHERE order_id = $ordId";
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
                        $itmTemp = null;
                        switch($currItm[1]){
                            case 1:
                                $itmTemp = "Hot";
                                break;
                            case 2:
                                $itmTemp = "Cold";
                                break;
                            case 0:
                            default:
                                break;
                        }
                        array_push($outputItmArr, array_values(array(
                            "id" => $currItm[0],
                            "name" => $prodName,
                            "temperature" => $itmTemp,
                            "quantity" => $currItm[2],
                            "price" => $currItm[3],
                            "subtotal" => $currItm[4],
                            "img" => $prodImg,
                        )));
                    }
                } else {
                    $ordArr = array("0" => "Error");
                    header('X-PHP-Response-Code: 500', true, 500);
                    die();
                }
                foreach($ordArr as $currOrd){
                    $getCustSQL = "SELECT cust_name FROM customers WHERE cust_id = $currOrd[6]";
                    $custRes = mysqli_query($conn, $getCustSQL);
                    if(!is_bool($custRes)){
                        $custArr = mysqli_fetch_all($custRes);
                        $custArr = array_values($custArr);
                        foreach($custArr as $thisCust){
                            $custName = $thisCust[0];
                        }
                    }
                    $getPaymSQL = "SELECT payment_method FROM payments WHERE payment_id = $currOrd[5]";
                    $paymRes = mysqli_query($conn, $getPaymSQL);
                    if(!is_bool($paymRes)){
                        $paymArr = mysqli_fetch_all($paymRes);
                        $paymArr = array_values($paymArr);
                        foreach($paymArr as $currPaym){
                            $payMethod = $currPaym[0];
                        }
                    }
                    $outputOrdArr = array(
                        "id" => $currOrd[0],
                        "name" => $custName,
                        "date" => $currOrd[1],
                        "time" => $currOrd[2],
                        "status" => $currOrd[3],
                        "total" => $currOrd[4],
                        "paymentMethod" => $payMethod,
                        "data" => $outputItmArr,
                    );
                }
            } else {
                $ordArr = array("0" => "Error");
                header('X-PHP-Response-Code: 500', true, 500);
                die();
            }
        } else {
            $getOrdSQL = "SELECT order_id, order_date, order_time, order_status, order_total, cust_id FROM orders";
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
                foreach($ordArr as $currOrd){
                    array_push($outputOrdArr, array_values(array(
                        "id" => $currOrd[0],
                        "date" => $currOrd[1],
                        "time" => $currOrd[2],
                        "status" => $currOrd[3],
                        "total" => $currOrd[4],
                        "cust" => $currOrd[5],
                    )));
                }
                $getSumOrdSQL = "SELECT SUM(order_total), COUNT(order_id) FROM orders";
                $sumOrdRes = mysqli_query($conn, $getSumOrdSQL);
                if(!is_bool($sumOrdRes)){
                    $sumOrdArr = mysqli_fetch_all($sumOrdRes);
                    $sumOrdArr = array_values($sumOrdArr);
                    foreach($sumOrdArr as $currSumOrd){
                        $totalRevenue = $currSumOrd[0];
                        $totalOrders = $currSumOrd[1];
                    }
                }
                $getMonthOrdSQL = "SELECT SUM(order_total), COUNT(order_id) FROM orders WHERE MONTH(order_date) = MONTH(CURRENT_DATE)";
                $monthOrdRes = mysqli_query($conn, $getMonthOrdSQL);
                if(!is_bool($monthOrdRes)){
                    $monthOrdArr = mysqli_fetch_all($monthOrdRes);
                    $monthOrdArr = array_values($monthOrdArr);
                    foreach($monthOrdArr as $currMonthOrd){
                        $monthRevenue = $currMonthOrd[0];
                        $monthOrders = $currMonthOrd[1];
                    }
                }
                $outputOrdArr = array(
                    "total_orders" => $totalOrders,
                    "total_revenue" => $totalRevenue,
                    "current_month" => [
                        "orders" => $monthOrders,
                        "revenue" => $monthRevenue,
                    ],
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