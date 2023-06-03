<?php
    session_start();
    $ROOTPATH = $_SERVER["DOCUMENT_ROOT"] . '/..';
    include($ROOTPATH . '/internal/custcontrol.php');
    require_once $ROOTPATH . "/internal/db.php";

    if(!isset($_SESSION['name'])){
        http_response_code(500);
        die();
    }

    $custName = strtok($_SESSION["name"], " ");

    $backPage = $_SESSION["backPage"];

    if(!isset($_SESSION["backPage"])){
        //backPage is not set, defaulting to index.php
        $backPage = "/index.php";
    }

    error_reporting(E_ALL);
    //ini_set('display_errors', 1);

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST["paymethod"]) && isset($_POST["items"]) && isset($_POST["total"])){
            $paymethod = $_POST["paymethod"];
            $custId = $_SESSION["cust_id"];
            $items = $_POST["items"];
            $total = $_POST["total"];
        } else {
            http_response_code(400);
            die();
        }

        switch($paymethod){
            case "0": //cash
                $paymethodstr = "Cash";
                break;
            case "1": //stripe
                $paymethodstr = "Stripe";
                break;
            default:
                http_response_code(500);
                die();
        }

        $createPaymentSQL = "INSERT INTO payments (payment_method, payment_amount) VALUES (?, ?)";
        if($stmt=mysqli_prepare($conn, $createPaymentSQL)){
            mysqli_stmt_bind_param($stmt, "ss", $payment_method, $payment_amount);

            $payment_method = $paymethodstr;
            $payment_amount = $total;

            if(mysqli_stmt_execute($stmt)){
                $payId = mysqli_insert_id($conn);
            } else {
                mysqli_stmt_close($stmt);
                http_response_code(500);
                die();
            }

            mysqli_stmt_close($stmt);
        } else {
            http_response_code(500);
            die();
        }

        if(!isset($payId)){
            http_response_code(500);
            die();
        }

        $createOrdSQL = "INSERT INTO orders (order_date, order_time, order_status, order_total, payment_id, cust_id) VALUES (?, ?, ?, ?, ?, ?)";
        if($stmt=mysqli_prepare($conn, $createOrdSQL)){
            mysqli_stmt_bind_param($stmt, "ssssii", $order_date, $order_time, $order_status, $order_total, $payment_id, $cust_id);
            
            $order_date = date('Y-m-d');
            $order_time = date('H:i:s');
            $order_status = "Pending";
            $order_total = $total;
            $payment_id = $payId;
            $cust_id = $custId;

            if(!mysqli_stmt_execute($stmt)){
                mysqli_stmt_close($stmt);
                $deletePaymentSQL = "DELETE FROM payments WHERE payment_id = ?";
                if($stmt=mysqli_prepare($conn, $deletePaymentSQL)){
                    mysqli_stmt_bind_param($stmt, 'i', $payment_id);

                    $payment_id = $payId;

                    if(!mysqli_stmt_execute($stmt)){
                        mysqli_stmt_close($stmt);
                        http_response_code(500);
                        die();
                    }
                    mysqli_stmt_close($stmt);
                } else {
                    http_response_code(500);
                    die();
                }
                http_response_code(500);
                die();
            } else {
                $ordId = mysqli_insert_id($conn);
            }
            mysqli_stmt_close($stmt);
        } else {
            http_response_code(500);
            die();
        }

        $testCartSQL = "SELECT * FROM carts WHERE cust_id = $custId";
        $testCartRes = mysqli_query($conn, $testCartSQL);
        if(!is_bool($testCartRes)){
            if(mysqli_num_rows($testCartRes) != 0){
                $testCartArr = mysqli_fetch_all($testCartRes);
                $testCartArr = array_values($testCartArr);
                foreach($testCartArr as $currCart){
                    $caid = $currCart[0];
                }
            }
        } else {
            http_response_code(500);
            die();
        }

        if(!isset($ordId) || !isset($caid)){
            http_response_code(500);
            die();
        }

        $ordItmIndex = 0;
        foreach($items as $curritm){
            $addOrdItmSQL = "INSERT INTO order_lists (order_id, prod_id, ord_list_qty, ord_list_price, ord_list_amt) VALUES (?, ?, ?, ?, ?)";
            if($stmt=mysqli_prepare($conn, $addOrdItmSQL)){
                mysqli_stmt_bind_param($stmt, 'iisss', $order_id, $prod_id, $ord_list_qty, $ord_list_price, $ord_list_amt);

                $order_id = $ordId;
                $prod_id = $curritm[0];
                $ord_list_qty = $curritm[2];
                $ord_list_price = $curritm[3];
                $ord_list_amt = $curritm[4];

                if(!mysqli_stmt_execute($stmt)){
                    mysqli_stmt_close($stmt);
                    if($ordItmIndex < 1){
                        $deleteOrderSQL = "DELETE FROM orders WHERE order_id = ?";
                        if($stmt=mysqli_prepare($conn, $deletePaymentSQL)){
                            mysqli_stmt_bind_param($stmt, 'i', $order_id);
    
                            $order_id = $ordId;
    
                            if(!mysqli_stmt_execute($stmt)){
                                mysqli_stmt_close($stmt);
                                http_response_code(500);
                                die();
                            }
                            mysqli_stmt_close($stmt);
                        } else {
                            http_response_code(500);
                            die();
                        }
                    }
                    http_response_code(500);
                    die();
                }
            } else {
                http_response_code(500);
                die();
            }

            $delCartItm = "DELETE FROM cart_items WHERE cart_id = ? AND prod_id = ?";
            if ($stmt=mysqli_prepare($conn, $delCartItm)){
                mysqli_stmt_bind_param($stmt, "ii", $cart_id, $prod_id);

                $cart_id = $caid;
                $prod_id = $curritm[0];

                if(mysqli_stmt_execute($stmt)){
                    mysqli_stmt_close($stmt);
                    $getCartItm = "SELECT * FROM cart_items WHERE cart_id = $caid";
                    $getCartItmRes = mysqli_query($conn, $getCartItm);
                    if(!is_bool($getCartItmRes)){
                        $cartItmNum = mysqli_num_rows($getCartItmRes);
                        if($cartItmNum < 1){
                            $delCartSQL = "DELETE FROM carts WHERE cust_id = ?";
                            if ($stmt=mysqli_prepare($conn, $delCartSQL)){
                                mysqli_stmt_bind_param($stmt, "s", $cust_id);
            
                                $cust_id = $custId;
            
                                if(mysqli_stmt_execute($stmt)){
                                    //
                                } else {
                                    mysqli_stmt_close($stmt);
                                    http_response_code(500);
                                    die();
                                }
            
                                mysqli_stmt_close($stmt);
                            }
                        } else {
                            //
                        }
                    } else {
                        http_response_code(500);
                        die();
                    }
                } else {
                    mysqli_stmt_close($stmt);
                    http_response_code(500);
                    die();
                }
            }
            $ordItmIndex++;
        }

        $addTrackingSQL = "INSERT INTO trackings (track_desc, order_id) VALUES (?, ?)";
        if($stmt=mysqli_prepare($conn, $addTrackingSQL)){
            mysqli_stmt_bind_param($stmt, "si", $track_desc, $order_id);

            $track_desc = "Order $ordId received from customer $custName";
            $order_id = $ordId;

            if(!mysqli_stmt_execute($stmt)){
                mysqli_stmt_close($stmt);
                http_response_code(500);
                die();
            }
            mysqli_stmt_close($stmt);
        } else {
            http_response_code(500);
            die();
        }
        http_response_code(200);
    }
?>