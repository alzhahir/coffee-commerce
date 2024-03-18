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
        if(!isset($_GET["cat_id"])){
            $_SESSION["userErrCode"] = "FORM_FAILED";
            $_SESSION["userErrMsg"] = "Cannot get POST data from form. Please contact the administrator if you believe that this should not happen.";
            header("refresh:0;url=$backPage?error=true");
            die();
        }

        $cid = $_GET["cat_id"];

        if(isset($_POST["catName"])){
            $categoryName = $_POST["catName"];
            $categoryImg = $_POST["catImgUrl"];
        }

        if(!isset($_POST["catImgUrl"]) || empty($_POST["catImgUrl"])){
            $categoryImg = null;
        }


        $editCatSQL = "UPDATE categories SET cat_name = ?, cat_image = ? WHERE cat_id = $cid";
        if ($stmt=mysqli_prepare($conn, $editCatSQL)){
            mysqli_stmt_bind_param($stmt, "ss", $category_name, $category_imgurl);

            $category_name = $categoryName;
            $category_imgurl = $categoryImg;

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