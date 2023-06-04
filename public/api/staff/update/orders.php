<?php
    session_start();
    $ROOTPATH = $_SERVER["DOCUMENT_ROOT"] . '/..';
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
        }
        $_SESSION["userErrCode"] = "UPDATE_ORDER_SUCCESS";
        $_SESSION["userErrMsg"] = "Order status successfully updated. You can view the latest order listing via the Orders page.";
        header("refresh:0;url=$backPage?signup=success");
    }
?>