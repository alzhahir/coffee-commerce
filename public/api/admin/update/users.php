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
        //what to do?
        //if password exists,
        //check if password is good
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
            $password = password_hash($password, PASSWORD_DEFAULT);
        }
        //check if email would cause duplication
        $email = $_POST["email"];
        $userId = $_GET["user_id"];
        $emailsql = "SELECT count(user_email) FROM users WHERE user_email = (?) AND NOT user_id = (?)";
        if ($stmt=mysqli_prepare($conn, $emailsql)){
            mysqli_stmt_bind_param($stmt, "si", $user_email, $user_id);

            $user_email = $email;
            $user_id = $userId;

            if(mysqli_stmt_execute($stmt)){
                $emailArray = mysqli_fetch_array(mysqli_stmt_get_result($stmt));
                $userEmail = $emailArray["count(user_email)"];
                if($userEmail > 0 || $userEmail != NULL){
                    $_SESSION["userErrCode"] = "EMAIL_EXISTS";
                    $_SESSION["userErrMsg"] = "The account for this email already exists.";
                    header("refresh:0;url=$backPage?error=true");
                    die();
                }//end if
                //echo "SUCCESS QUERY USERS TABLE FOR EMAIL!<br>";
            } else {
                $_SESSION["userErrCode"] = "MYSQL_ERROR_EM";
                $_SESSION["userErrMsg"] = "MySQL error encountered: ".mysqli_error($conn)." Please contact the administrator if you believe that this should not happen.";
                header("refresh:0;url=$backPage?error=true");
                die();
            }

            mysqli_stmt_close($stmt);
        }

        //get role
        $rolesql = "SELECT user_type FROM users WHERE user_id = (?)";
        if ($stmt=mysqli_prepare($conn, $rolesql)){
            mysqli_stmt_bind_param($stmt, "i", $user_id);

            $user_id = $userId;

            if(mysqli_stmt_execute($stmt)){
                $roleArray = mysqli_fetch_array(mysqli_stmt_get_result($stmt));
                $userType = $roleArray["user_type"];
            } else {
                $_SESSION["userErrCode"] = "MYSQL_ERROR_EM";
                $_SESSION["userErrMsg"] = "MySQL error encountered: ".mysqli_error($conn)." Please contact the administrator if you believe that this should not happen.";
                header("refresh:0;url=$backPage?error=true");
                die();
            }

            mysqli_stmt_close($stmt);
        }
        //update users table
        if(isset($_POST["password"]) && strlen($_POST["password"]) > 1){
            $usersSql = "UPDATE users SET user_email = \"$email\", user_pass = \"$password\" WHERE user_id = $userId";
        } else {
            $usersSql = "UPDATE users SET user_email = \"$email\" WHERE user_id = $userId";
        }
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
        //update respective roles table
        $name = $_POST["name"];
        $telno = $_POST["phone"];
        switch ($userType){
            case "0":
                $roleSql = "UPDATE customers SET cust_name = \"$name\", cust_phone = \"$telno\" WHERE user_id = $userId";
                break;
            case "1":
            case "2":
                $roleSql = "UPDATE employees SET emp_name = \"$name\", emp_phone = $telno\" WHERE user_id = $userId";
                break;
            default:
                break;
        }
        $appRes = mysqli_query($conn, $roleSql);
        if(is_bool($appRes)){
            if($appRes){
                //success update
            } else {
                $_SESSION["userErrCode"] = "MYSQL_ERROR";
                $_SESSION["userErrMsg"] = "MySQL error encountered: ".mysqli_error($conn).". Please contact the administrator if you believe that this should not happen.";
                header("refresh:0;url=$backPage?error=true");
                die();
            }
        } else {
            $_SESSION["userErrCode"] = "MYSQL_ERROR";
            $_SESSION["userErrMsg"] = "MySQL error encountered: ".mysqli_error($conn)." Please contact the administrator if you believe that this should not happen.";
            header("refresh:0;url=$backPage?error=true");
            die();
        }
        $_SESSION["userErrCode"] = "UPDATE_USER_SUCCESS";
        $_SESSION["userErrMsg"] = "User updated successfully. Changes will be reflected on the system.";
        header("refresh:0;url=$backPage?signup=success");
    }
?>