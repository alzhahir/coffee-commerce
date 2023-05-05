<?php
    session_start();
    $ROOTPATH = $_SERVER["DOCUMENT_ROOT"] . '/..';
    include($ROOTPATH . '/internal/admincontrol.php');
    require_once $ROOTPATH . "/internal/db.php";

    $backPage = $_SESSION["backPage"];

    if(!isset($_SESSION["backPage"])){
        //backPage is not set, defaulting to index.php
        $backPage = "/admin/products/";
    }

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(!isset($_GET["prod_id"])){
            $_SESSION["userErrCode"] = "FORM_FAILED";
            $_SESSION["userErrMsg"] = "Cannot get POST data from form. Please contact the administrator if you believe that this should not happen.";
            header("refresh:0;url=$backPage?error=true");
            die();
        }

        $pid = $_GET["prod_id"];

        if(isset($_POST["prodName"]) && isset($_POST["prodPrice"]) && isset($_POST["prodStock"])){
            $productName = $_POST["prodName"];
            $productPrice = $_POST["prodPrice"];
            $productStock = $_POST["prodStock"];
            $productImg = $_POST["prodImgUrl"];
        } else {
            $_SESSION["userErrCode"] = "FORM_FAILED";
            $_SESSION["userErrMsg"] = "Cannot get POST data from form. Please contact the administrator if you believe that this should not happen.";
            header("refresh:0;url=$backPage?error=true");
            die();
        }

        if(!isset($_POST["prodImgUrl"]) || empty($_POST["prodImgUrl"])){
            $productImg = null;
        }


        $addTrackingSQL = "UPDATE products (prod_name, prod_img_url, prod_price, prod_stock) VALUES (?, ?, ?, ?) WHERE prod_id = $pid";
        if ($stmt=mysqli_prepare($conn, $addTrackingSQL)){
            mysqli_stmt_bind_param($stmt, "ssss", $product_name, $product_imgurl, $product_price, $product_stock);

            $product_name = $productName;
            $product_imgurl = $productImg;
            $product_price = $productPrice;
            $product_stock = $productStock;

            if(mysqli_stmt_execute($stmt)){
                //echo "SUCCESS ADD TO tracking TABLE!<br>";
            } else {
                $_SESSION["userErrCode"] = "MYSQL_ERROR";
                $_SESSION["userErrMsg"] = "MySQL error encountered: ".mysqli_error($conn)." Please contact the administrator if you believe that this should not happen.";
                header("refresh:0;url=$backPage?error=true");
                die();
            }

            mysqli_stmt_close($stmt);
        }
        $_SESSION["userErrCode"] = "EDIT_PRODUCT_SUCCESS";
        $_SESSION["userErrMsg"] = "Product successfully updated. You can view the latest product listing via the Products page.";
        header("refresh:0;url=$backPage?signup=success");
    }
?>