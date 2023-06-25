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
    //ini_set('display_errors', 1);

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
            $productIsHot = 0;
            $productIsCold = 0;

            if(isset($_POST["isHot"])){
                switch($_POST['isHot']){
                    case 1:
                        $productIsHot = $_POST['isHot'];
                        break;
                    case 0:
                        $productIsHot = 0;
                        break;
                    case null:
                        $productIsHot = 0;
                        break;
                    default:
                        $_SESSION["userErrCode"] = "FORM_DATA_INVALID";
                        $_SESSION["userErrMsg"] = "Got invalid POST data from form. Please contact the administrator if you believe that this should not happen.";
                        header("refresh:0;url=$backPage?error=true");
                        die();
                }
            }

            if(isset($_POST["isCold"])){
                switch($_POST['isCold']){
                    case 2:
                        $productIsCold = $_POST['isCold'];
                        break;
                    case 0:
                        $productIsCold = 0;
                        break;
                    case null:
                        $productIsCold = 0;
                        break;
                    default:
                        $_SESSION["userErrCode"] = "FORM_DATA_INVALID";
                        $_SESSION["userErrMsg"] = "Got invalid POST data from form. Please contact the administrator if you believe that this should not happen.";
                        header("refresh:0;url=$backPage?error=true");
                        die();
                }
            }

            $resultAdd = $productIsHot + $productIsCold;

            switch($resultAdd){
                case 3:
                    //both set - 3
                    $productTemp = 3;
                    break;
                case 2:
                    //cold - 2
                    $productTemp = 2;
                    break;
                case 1:
                    //hot - 1
                    $productTemp = 1;
                    break;
                case 0:
                    //both unset - 0
                    $productTemp = 0;
                    $_SESSION["userErrCode"] = "PROD_TEMP_UNSET";
                    $_SESSION["userErrMsg"] = "Product temperature unset. Please chose either hot or cold. Contact the administrator if you believe that this should not happen.";
                    header("refresh:0;url=$backPage?error=true");
                    die();
                default:
                    $_SESSION["userErrCode"] = "PROD_DATA_INVALID";
                    $_SESSION["userErrMsg"] = "Got invalid product data from form. Please contact the administrator if you believe that this should not happen.";
                    header("refresh:0;url=$backPage?error=true");
                    die();
            }
        } else {
            $_SESSION["userErrCode"] = "FORM_FAILED";
            $_SESSION["userErrMsg"] = "Cannot get POST data from form. Please contact the administrator if you believe that this should not happen.";
            header("refresh:0;url=$backPage?error=true");
            die();
        }

        if(!isset($productTemp) || $productTemp == null){
            $_SESSION["userErrCode"] = "PROD_TEMP_UNSET";
            $_SESSION["userErrMsg"] = "Product temperature unset. Please chose either hot or cold. Contact the administrator if you believe that this should not happen.";
            header("refresh:0;url=$backPage?error=true");
            die();
        }

        if(!isset($_POST["prodImgUrl"]) || empty($_POST["prodImgUrl"])){
            $productImg = null;
        }


        $editProdSQL = "UPDATE products SET prod_name = ?, prod_img_url = ?, prod_price = ?, prod_stock = ?, prod_temp = ? WHERE prod_id = $pid";
        if ($stmt=mysqli_prepare($conn, $editProdSQL)){
            mysqli_stmt_bind_param($stmt, "ssssi", $product_name, $product_imgurl, $product_price, $product_stock, $product_temp);

            $product_name = $productName;
            $product_imgurl = $productImg;
            $product_price = $productPrice;
            $product_stock = $productStock;
            $product_temp = $productTemp;

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
        http_response_code(200);
        header("refresh:0;url=$backPage?signup=success");
    }
?>