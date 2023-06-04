<?php
    session_start();
    $ROOTPATH = $_SERVER["DOCUMENT_ROOT"] . '/..';
    include($ROOTPATH . '/internal/staffcontrol.php');
    require_once $ROOTPATH . "/internal/db.php";

    $backPage = $_SESSION["backPage"];

    if(!isset($_SESSION["backPage"])){
        //backPage is not set, defaulting to index.php
        $backPage = "/staff/products/";
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

        if(isset($_POST["prodStock"])){
            $productStock = $_POST["prodStock"];
        } else {
            $_SESSION["userErrCode"] = "FORM_FAILED";
            $_SESSION["userErrMsg"] = "Cannot get POST data from form. Please contact the administrator if you believe that this should not happen.";
            header("refresh:0;url=$backPage?error=true");
            die();
        }

        $editProdSQL = "UPDATE products SET prod_stock = ? WHERE prod_id = $pid";
        if ($stmt=mysqli_prepare($conn, $editProdSQL)){
            mysqli_stmt_bind_param($stmt, "s", $product_stock);
            
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