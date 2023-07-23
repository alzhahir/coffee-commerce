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
        if(isset($_POST["prodName"]) && isset($_POST["prodPrice"]) && isset($_POST["prodStock"]) && isset($_POST["catId"])){
            $productName = $_POST["prodName"];
            $productPrice = $_POST["prodPrice"];
            $productStock = $_POST["prodStock"];
            $productImg = $_POST["prodImgUrl"];
            $categoryId = $_POST["catId"];
        } else {
            $_SESSION["userErrCode"] = "FORM_FAILED";
            $_SESSION["userErrMsg"] = "Cannot get POST data from form. Please contact the administrator if you believe that this should not happen.";
            header("refresh:0;url=$backPage?error=true");
            die();
        }

        if(!isset($_POST["prodImgUrl"]) || empty($_POST["prodImgUrl"])){
            $productImg = null;
        }


        $addTrackingSQL = "INSERT INTO products (prod_name, prod_img_url, prod_price, prod_stock, cat_id) VALUES (?, ?, ?, ?, ?)";
        if ($stmt=mysqli_prepare($conn, $addTrackingSQL)){
            mysqli_stmt_bind_param($stmt, "ssssi", $product_name, $product_imgurl, $product_price, $product_stock, $cat_id);

            $product_name = $productName;
            $product_imgurl = $productImg;
            $product_price = $productPrice;
            $product_stock = $productStock;
            $cat_id = $categoryId;

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
        $_SESSION["userErrCode"] = "ADD_PRODUCT_SUCCESS";
        $_SESSION["userErrMsg"] = "Product successfully added. You can view the latest product listing via the Products page.";
        header("refresh:0;url=$backPage?signup=success");
    }
?>