<?php
    session_start();
    $ROOTPATH = $_SERVER["DOCUMENT_ROOT"] . '/..';
    require_once $ROOTPATH . "/internal/db.php";

    $backPage = $_SESSION["backPage"];

    if(!isset($_SESSION["backPage"])){
        //backPage is not set, defaulting to index.php
        $backPage = "/index.php";
    }

    error_reporting(E_ALL);
    //ini_set('display_errors', 1);

    $userEmail = $_SESSION['mail'];

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        //what to do?

        //if password exists,
        //check if password is good
        $password_err = "";
        if(isset($_POST["password"]) && strlen($_POST["password"]) > 1){
            if(empty(trim($_POST["password"]))){
                $password_err = "Please enter a password.";
                die($password_err);
            } elseif(strlen(trim($_POST["password"])) < 8){
                $_SESSION["userErrCode"] = "INVALID_PASSWORD";
                $_SESSION["userErrMsg"] = "Password is invalid. Password must have at least 8 characters.";
                header("refresh:0;url=$backPage?error=true");
                die();
            } else{
                $password = trim($_POST["password"]);
            }
        }

        //check confirm password
        if(empty(trim($_POST["confirmPassword"]))){
            $_SESSION["userErrCode"] = "CONFIRM_PASSWORD_NONEXISTANT";
            $_SESSION["userErrMsg"] = "Please enter the password confirmation.";
            header("refresh:0;url=$backPage?error=true");
            die();
        } else{
            $confirm_password = trim($_POST["confirmPassword"]);
            if($password != $confirm_password){
                $_SESSION["userErrCode"] = "CONFIRM_PASSWORD_MISMATCH";
                $_SESSION["userErrMsg"] = "Confirmation password does not match with the password.";
                header("refresh:0;url=$backPage?error=true");
                die();
            }
        }

        $password = password_hash($password, PASSWORD_DEFAULT);

        //update users table
        $usersSql = "UPDATE users SET user_password = \"$password\" WHERE user_email = \"$userEmail\"";
        $appRes = mysqli_query($conn, $usersSql);
        if(is_bool($appRes)){
            if($appRes){
                //success update
            } else {
                $_SESSION["userErrCode"] = "MYSQL_ERROR_UPD_FAIL";
                $_SESSION["userErrMsg"] = "MySQL error encountered: ".mysqli_error($conn).". Please contact the administrator if you believe that this should not happen.";
                header("refresh:0;url=$backPage?error=true");
                die();
            }
        } else {
            $_SESSION["userErrCode"] = "MYSQL_ERROR_UPD_NOT_BOOL";
            $_SESSION["userErrMsg"] = "MySQL error encountered: ".mysqli_error($conn)." Please contact the administrator if you believe that this should not happen.";
            header("refresh:0;url=$backPage?error=true");
            die();
        }
        $_SESSION["userErrCode"] = "RESET_PASSWORD_SUCCESS";
        $_SESSION["userErrMsg"] = "Password resetted successfully. Changes will be reflected on the system.";
        header("refresh:0;url=$backPage?signup=success");
    }
?>