<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $ROOTPATH = $_SERVER["DOCUMENT_ROOT"] . '/..';
    $DOMAIN = $_SERVER['HTTP_HOST'];
    $PROTOCOL = $_SERVER['HTTPS'] ? 'https://' : 'http://';
    include($ROOTPATH . '/internal/staffcontrol.php');
    require_once $ROOTPATH . "/internal/db.php";

    $backPage = $_SESSION["backPage"];

    if(!isset($_SESSION["backPage"])){
        //backPage is not set, defaulting to index.php
        $backPage = "/staff/orders/";
    }

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(!isset($_GET["order_id"]) || !is_numeric($_GET["order_id"])){
            $_SESSION["userErrCode"] = "FORM_FAILED";
            $_SESSION["userErrMsg"] = "Cannot get POST data from form. Please contact the administrator if you believe that this should not happen.";
            header("refresh:0;url=$backPage?error=true");
            die();
        }

        if(!isset($_SESSION['emp_id'])){
            $_SESSION["userErrCode"] = "FORM_FAILED";
            $_SESSION["userErrMsg"] = "Cannot get POST data from form. Please contact the administrator if you believe that this should not happen.";
            header("refresh:0;url=$backPage?error=true");
            die();
        }

        $empId = $_SESSION['emp_id'];

        $oid = $_GET["order_id"];

        if(isset($_POST["ordStatus"]) && $_POST["ordStatus"] != null){
            $orderStatus = $_POST["ordStatus"];
        } else {
            $_SESSION["userErrCode"] = "FORM_FAILED";
            $_SESSION["userErrMsg"] = "Cannot get POST data from form. Please contact the administrator if you believe that this should not happen.";
            header("refresh:0;url=$backPage?error=true");
            die();
        }

        $updateOrdSQL = "UPDATE orders SET order_status = ?, emp_id = ? WHERE order_id = $oid";
        if ($stmt=mysqli_prepare($conn, $updateOrdSQL)){
            mysqli_stmt_bind_param($stmt, "si", $order_status, $emp_id);

            $order_status = $orderStatus;
            $emp_id = $empId;

            if(mysqli_stmt_execute($stmt)){
                $addTrackingSQL = "INSERT INTO trackings (track_desc, emp_id, order_id) VALUES (?, ?, ?)";
                if($stmt=mysqli_prepare($conn, $addTrackingSQL)){
                    mysqli_stmt_bind_param($stmt, "sii", $track_desc, $emp_id, $order_id);

                    $track_desc = "Staff $empId changed order $oid status to $orderStatus";
                    $emp_id = $empId;
                    $order_id = $oid;

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
            } else {
                $_SESSION["userErrCode"] = "MYSQL_ERROR";
                $_SESSION["userErrMsg"] = "MySQL error encountered: ".mysqli_error($conn)." Please contact the administrator if you believe that this should not happen.";
                header("refresh:0;url=$backPage?error=true");
                die();
            }

            $getCustId = "SELECT cust_id FROM orders WHERE order_id = $oid";
            $custIdRes = mysqli_query($conn, $getCustId);
            if(!is_bool($custIdRes)){
                $custIdArr = mysqli_fetch_all($custIdRes);
                $custIdArr = array_values($custIdArr);
                foreach($custIdArr as $thisCust){
                    $custId = $thisCust[0];
                }
            } else {
                $_SESSION["userErrCode"] = "MYSQL_ERROR";
                $_SESSION["userErrMsg"] = "MySQL error encountered: ".mysqli_error($conn)." Please contact the administrator if you believe that this should not happen.";
                header("refresh:0;url=$backPage?error=true");
                die();
            }

            if(str_contains($DOMAIN, 'localhost')){
                $DOMAIN = "fyp.alzhahir.com";
                $PROTOCOL = "https://";
            }

            $getCustUserId = "SELECT user_id FROM customers WHERE cust_id = $custId";
            $custUIdRes = mysqli_query($conn, $getCustUserId);
            if(!is_bool($custIdRes)){
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

            $title = "Order $orderStatus";
            $body = "Your order, order $oid had changed status to $orderStatus";
            $imageUrl = 'https://img.icons8.com/fluency/96/cup.png';
            $topicVal = "cust".$custId; //get customer topic
            $redir = "/customer/index.php";

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
            curl_setopt($req, CURLOPT_SSL_VERIFYPEER, FALSE);
            $response = curl_exec($req);
            $reserr = curl_error($req);
            $rescode = curl_getinfo($req, CURLINFO_HTTP_CODE);
            if(!$response){
                error_log('Notification Error '.$rescode . $reserr);
            }
            curl_close($req);

            $emailApiUrl = $PROTOCOL.$DOMAIN."/api/create/mail.php";
            error_log($emailApiUrl);

            $subject = "[ORDER] Your order, order $oid had changed status to $orderStatus";

            $mailpostfields = [
                "recipient_address" => $custEmail,
                "subject" => $subject,
                "alternative_body" => 'Your order status was changed. More details available on the website.',
                "context" => 1,
                "context_object" => [
                    "order_id" => $oid,
                    "status" => $orderStatus
                ]
            ];

            $req2 = curl_init();
            curl_setopt($req2, CURLOPT_URL, $emailApiUrl);
            curl_setopt($req2, CURLOPT_POST, true);
            curl_setopt($req2, CURLOPT_POSTFIELDS, $mailpostfields);
            curl_setopt($req2, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($req2, CURLOPT_SSL_VERIFYPEER, FALSE);
            $response2 = curl_exec($req2);
            $reserr2 = curl_error($req2);
            $rescode2 = curl_getinfo($req2, CURLINFO_HTTP_CODE);
            if(!$response2){
                error_log('Email Error '.$rescode2 . $reserr2);
            }
            curl_close($req2);

        }
        $_SESSION["userErrCode"] = "UPDATE_ORDER_SUCCESS";
        $_SESSION["userErrMsg"] = "Order status successfully updated. You can view the latest order listing via the Orders page.";
        header("refresh:0;url=$backPage?update=success");
    }
?>