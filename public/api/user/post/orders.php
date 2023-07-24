<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $ROOTPATH = $_SERVER["DOCUMENT_ROOT"] . '/..';
    $DOMAIN = $_SERVER['HTTP_HOST'];
    $PROTOCOL = $_SERVER['HTTPS'] ? 'https://' : 'http://';
    $creds = parse_ini_file($ROOTPATH."/.ini");
    $HOST_PROTOCOL = $creds['protocol'];
    $HOST_NAME = $creds['host'];
    $STRIPE_API_KEY = $creds['secret_key'];
    include($ROOTPATH . '/internal/custcontrol.php');
    require_once $ROOTPATH . '/vendor/autoload.php';
    //require_once $ROOTPATH . '/internal/stripe-php/init.php';
    $stripe = new \Stripe\StripeClient($STRIPE_API_KEY);
    require_once $ROOTPATH . "/internal/db.php";

    function genResData(?string $errorMsg, string $status = "NO_STATUS_GIVEN", string $data = null){
        return json_encode([
            'data' => $data,
            'status' => $status,
            'error' => $errorMsg
        ]);
    }

    $errResData = json_encode([
        'data' => null
    ]);

    if(isset($_POST['testMode'])){
        switch($_POST['testMode']){
            case 'success':
                header("Content-Type: application/json;");
                echo genResData('Test mode success', 'TEST_MODE_SUCCESS', 'testData');
                http_response_code(200);
                die();
            case 'fail':
                header("Content-Type: application/json;");
                echo genResData('Test mode fail', 'TEST_MODE_FAIL');
                http_response_code(200);
                die();
            default:
                header("Content-Type: application/json;");
                echo genResData('Test mode error', 'TEST_MODE_ERROR');
                http_response_code(500);
                die();
        }
    }

    if(!isset($_SESSION['name'])){
        header("Content-Type: application/json;");
        echo genResData('Session error', 'SESSION_ERROR');
        http_response_code(500);
        die();
    }

    $custName = strtok($_SESSION["name"], " ");

    $backPage = $_SESSION["backPage"];

    if(!isset($_SESSION["backPage"])){
        //backPage is not set, defaulting to index.php
        $backPage = "/index.php";
    }

    //error_reporting(E_ALL);
    //ini_set('display_errors', 1);

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST["paymethod"]) && isset($_POST["items"]) && isset($_POST["total"])){
            $paymethod = $_POST["paymethod"];
            $custId = $_SESSION["cust_id"];
            $items = $_POST["items"];
            $total = $_POST["total"];
        } else {
            header("Content-Type: application/json;");
            echo genResData('POST data invalid', 'INVALID_POST_DATA');
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
                header("Content-Type: application/json;");
                echo genResData('Invalid Payment Method', "INVALID_PAYMENT_METHOD");
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
            header("Content-Type: application/json;");
            echo genResData('Database failed', "DB_FAIL_PAYMENT");
            http_response_code(500);
            die();
        }

        if(!isset($payId)){
            header("Content-Type: application/json;");
            echo genResData('Payment ID not found', "DB_PAYMENT_ID_FAIL");
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
            header("Content-Type: application/json;");
            echo genResData('Database failed', "DB_FAIL_ORD");
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
            header("Content-Type: application/json;");
            echo genResData('Database failed', "DB_FAIL_CART_ID");
            http_response_code(500);
            die();
        }

        if(!isset($ordId) || !isset($caid)){
            header("Content-Type: application/json;");
            echo genResData('Failed to get order ID or cart ID', "ORD_ID_CA_ID_FAIL");
            http_response_code(500);
            die();
        }

        $_SESSION['latestOrdID'] = $ordId;

        $ordItmIndex = 0;
        $lineItm = [];
        foreach($items as $curritm){
            $currentTemp = 'Null';
            switch($curritm[2]){
                case 1:
                    $currentTemp = 'Hot';
                    break;
                case 2:
                    $currentTemp = 'Cold';
                    break;
                default:
                    $currentTemp = 'Null';
                    break;
            }
            array_push($lineItm, [
                'price_data' => [
                        'currency' => 'MYR',
                        'unit_amount' => ($curritm[4]*100),
                        'product_data' => [
                            'name' => $curritm[1].' - '.$currentTemp
                        ]
                    ],
                'quantity' => $curritm[3],
            ]);
            $addOrdItmSQL = "INSERT INTO order_lists (order_id, prod_id, ord_list_temp, ord_list_qty, ord_list_price, ord_list_amt) VALUES (?, ?, ?, ?, ?, ?)";
            if($stmt=mysqli_prepare($conn, $addOrdItmSQL)){
                mysqli_stmt_bind_param($stmt, 'iiisss', $order_id, $prod_id, $ord_list_temp, $ord_list_qty, $ord_list_price, $ord_list_amt);

                $order_id = $ordId;
                $prod_id = $curritm[0];
                $ord_list_temp = $curritm[2];
                $ord_list_qty = $curritm[3];
                $ord_list_price = $curritm[4];
                $ord_list_amt = $curritm[5];

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
                    header("Content-Type: application/json;");
                    echo genResData('Database failed', "DB_FAIL_ORD");
                    http_response_code(500);
                    die();
                }

                $currStockSQL = "SELECT prod_stock FROM products WHERE prod_id = $curritm[0]";
                $currStockRes = mysqli_query($conn, $currStockSQL);
                if(!is_bool($currStockRes)){
                    $currStockArr = mysqli_fetch_all($currStockRes);
                    $currStockArr = array_values($currStockArr);
                    foreach($currStockArr as $currStock){
                        $prodStock = $currStock[0];
                    }
                }

                if(!isset($prodStock)){
                    http_response_code(500);
                    die();
                }

                $updateStockSQL = "UPDATE products SET prod_stock = ? WHERE prod_id = ?";
                if($stmt=mysqli_prepare($conn, $updateStockSQL)){
                    mysqli_stmt_bind_param($stmt, 'ii', $prod_stock, $prod_id);

                    $prod_id = $curritm[0];
                    $prod_stock = $prodStock - $curritm[3];
                    if(!mysqli_stmt_execute($stmt)){
                        mysqli_stmt_close($stmt);
                        http_response_code(500);
                        die();
                    }

                    mysqli_stmt_close($stmt);
                }
            } else {
                http_response_code(500);
                die();
            }

            $delCartItm = "DELETE FROM cart_items WHERE cart_id = ? AND prod_id = ? AND cart_itm_temp = ?";
            if ($stmt=mysqli_prepare($conn, $delCartItm)){
                mysqli_stmt_bind_param($stmt, "iii", $cart_id, $prod_id, $cart_itm_temp);

                $cart_id = $caid;
                $prod_id = $curritm[0];
                $cart_itm_temp = $curritm[2];;

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
                        header("Content-Type: application/json;");
                        echo genResData('Database failed', "DB_FAIL_DEL_CART");
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

        $stripeArr = [
            'metadata' => [
                'order_id' => $ordId,
            ],
            'success_url' => $HOST_PROTOCOL.'://'.$HOST_NAME.'/customer/order.php?order=success',
            'cancel_url' => $HOST_PROTOCOL.'://'.$HOST_NAME.'/customer/order.php?order=pending',
            'line_items' => $lineItm,
            'mode' => 'payment',
            'expires_at' => strtotime('+30 minutes'),
        ];

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
            header("Content-Type: application/json;");
            echo genResData('Database failed', "DB_FAIL_TRACK");
            http_response_code(500);
            die();
        }

        if(str_contains($DOMAIN, 'localhost')){
            $DOMAIN = "fyp.alzhahir.com";
            $PROTOCOL = "https://";
        }

        $getCustUserId = "SELECT user_id FROM customers WHERE cust_id = $custId";
        $custUIdRes = mysqli_query($conn, $getCustUserId);
        if(!is_bool($custUIdRes)){
            $custUIdArr = mysqli_fetch_all($custUIdRes);
            $custUIdArr = array_values($custUIdArr);
            foreach($custUIdArr as $thisCust){
                $custUID = $thisCust[0];
            }
        } else {
            $_SESSION["userErrCode"] = "MYSQL_ERROR";
            $_SESSION["userErrMsg"] = "MySQL error encountered: ".mysqli_error($conn)." Please contact the administrator if you believe that this should not happen.";
            header("refresh:0;url=$backPage?error=true");
            die();
        }

        $getCustEmail = "SELECT user_email FROM users WHERE user_id = $custUID";
        $custEmailRes = mysqli_query($conn, $getCustEmail);
        if(!is_bool($custEmailRes)){
            $custEmailArr = mysqli_fetch_all($custEmailRes);
            $custEmailArr = array_values($custEmailArr);
            foreach($custEmailArr as $thisCust){
                $custEmail = $thisCust[0];
            }
        } else {
            $_SESSION["userErrCode"] = "MYSQL_ERROR";
            $_SESSION["userErrMsg"] = "MySQL error encountered: ".mysqli_error($conn)." Please contact the administrator if you believe that this should not happen.";
            header("refresh:0;url=$backPage?error=true");
            die();
        }

        $notifApiUrl = $PROTOCOL.$DOMAIN."/api/notification/post/message.php";

        $title = 'Order Received';
        $body = 'Our barista had just received your order.';
        $imageUrl = 'https://img.icons8.com/fluency/96/cup.png';
        $topicVal = $_SESSION['notiftopic'];
        $redir = "#";

        $postfields = [
            "title" => $title,
            "body" => $body,
            "topic" => $topicVal,
            "imgurl" => $imageUrl,
            "redirurl" => $redir
        ];

        $req = curl_init();
        curl_setopt($req, CURLOPT_URL, $notifApiUrl);
        curl_setopt($req, CURLOPT_POST, true);
        curl_setopt($req, CURLOPT_POSTFIELDS, $postfields);
        curl_setopt($req, CURLOPT_RETURNTRANSFER, true);
        $res1 = curl_exec($req);
        curl_close ($req);

        $title = 'New Order';
        $body = "Order $ordId received! Please check the order.";
        $imageUrl = 'https://img.icons8.com/fluency/96/cup.png';
        $topicVal = 'staff';
        $redir = "/staff/orders/";

        $postfields = [
            "title" => $title,
            "body" => $body,
            "topic" => $topicVal,
            "imgurl" => $imageUrl,
            "redirurl" => $redir
        ];

        $req = curl_init();
        curl_setopt($req, CURLOPT_URL, $notifApiUrl);
        curl_setopt($req, CURLOPT_POST, 1);
        curl_setopt($req, CURLOPT_POSTFIELDS, $postfields);
        curl_setopt($req, CURLOPT_RETURNTRANSFER, true);
        $res2 = curl_exec($req);
        curl_close ($req);

        $emailApiUrl = $PROTOCOL.$DOMAIN."/api/create/mail.php";

        $subject = "[ORDER] Your order, order $ordId, was received!";

        $mailpostfields = [
            "recipient_address" => $custEmail,
            "subject" => $subject,
            "alternative_body" => 'We have received your order. More details available on the website.',
            "context" => 1,
            "mail_object" => [
                "order_id" => $ordId,
                "status" => 'Pending'
            ]
        ];

        $finalpost = http_build_query($mailpostfields);

        $req2 = curl_init();
        curl_setopt($req2, CURLOPT_URL, $emailApiUrl);
        curl_setopt($req2, CURLOPT_POST, true);
        curl_setopt($req2, CURLOPT_POSTFIELDS, $finalpost);
        curl_setopt($req2, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($req2, CURLOPT_SSL_VERIFYPEER, FALSE);
        $response2 = curl_exec($req2);
        $reserr2 = curl_error($req2);
        $rescode2 = curl_getinfo($req2, CURLINFO_HTTP_CODE);
        if(!$response2){
            error_log('Email Error '.$rescode2 . $reserr2);
        }
        curl_close($req2);

        switch($paymethod){
            case "0": //cash
                header("Content-Type: application/json;");
                echo genResData(null, 'CHECKOUT_SUCCESS', '/customer/order.php?order=success');
                http_response_code(200);
                die();
                break;
            case "1": //stripe
                $checkout_session = $stripe->checkout->sessions->create($stripeArr);
                $checkout_url = $checkout_session->url;
                if(!isset($checkout_url)){
                    header("Content-Type: application/json;");
                    echo genResData('Stripe error', "STRIPE_ERROR");
                    http_response_code(500);
                    die();
                }
                $updPaymentSQL = "UPDATE payments SET payment_txn_url = ? WHERE payment_id = ?";
                if($stmt=mysqli_prepare($conn, $updPaymentSQL)){
                    mysqli_stmt_bind_param($stmt, "si", $payment_txn_url, $payment_id);

                    $payment_txn_url = $checkout_url;
                    $payment_id = $payId;

                    if(mysqli_stmt_execute($stmt)){
                        //
                    } else {
                        mysqli_stmt_close($stmt);
                        http_response_code(500);
                        die();
                    }

                    mysqli_stmt_close($stmt);
                } else {
                    header("Content-Type: application/json;");
                    echo genResData('Database failed', "DB_FAIL_UPD_PAYMENT_URL");
                    http_response_code(500);
                    die();
                }

                header("Content-Type: application/json;");
                echo genResData(null, 'CHECKOUT_SUCCESS', $checkout_url);
                http_response_code(200);
                die();
                break;
            default:
                echo genResData('Invalid payment method', "INVALID_PAYMENT_METHOD");
                http_response_code(500);
                die();
                break;
        }
    } else {
        header("Content-Type: application/json;");
        echo genResData('Invalid method', "INVALID_METHOD");
        http_response_code(500);
        die();
    }
?>