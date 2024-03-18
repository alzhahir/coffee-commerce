<?php
    session_start();
    $ROOTPATH = $_SERVER["DOCUMENT_ROOT"] . '/..';
    //echo "<p>Processing your sign in request...</p>";
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    // Include config file
    require_once $ROOTPATH . "/internal/db.php";
    
    $backPage = $_SESSION["backPage"];
    
    if(!isset($_SESSION["backPage"])){
        //backPage is not set, defaulting to login.php
        $backPage = "/index.php";
    }

    if(!isset($_GET["errorType"])){
        //errorType is not set, defaulting to error
        $errorType = "error";
    } else {
        $errorType = $_GET["errorType"];
    }

    if(isset($_SESSION["uid"])){
        //user is logged in already
        $_SESSION["userErrCode"] = "SESSION_EXISTS";
        $_SESSION["userErrMsg"] = "You are already logged in. Please log out to log in as another user.";
        header("refresh:0;url=$backPage?$errorType");
        die();
    }

    // Define variables and initialize with empty values
    //$username = $password = $confirm_password = "";
    //$username_err = $password_err = $confirm_password_err = "";

    // Processing form data when form is submitted
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        //echo "<p>Please wait for a few seconds.</p>";
        $email = $_POST["signInEmail"];
        if(empty(trim($_POST["signInEmail"]))){
            $_SESSION["userErrCode"] = "INVALID_EMAIL";
            $_SESSION["userErrMsg"] = "Email is invalid. Please make sure that your email is valid.";
            header("refresh:0;url=$backPage?$errorType");
            die();
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION["userErrCode"] = "INVALID_EMAIL";
            $_SESSION["userErrMsg"] = "Email is invalid. Please make sure that your email is valid.";
            header("refresh:0;url=$backPage?$errorType");
            die();
        }

        //check if email exists
        $emailsql = "SELECT count(user_email) FROM users WHERE user_email = (?)" ;
        if ($stmt=mysqli_prepare($conn, $emailsql)){
            mysqli_stmt_bind_param($stmt, "s", $user_email);

            $user_email = $email;

            if(mysqli_stmt_execute($stmt)){
                $emailArray = mysqli_fetch_array(mysqli_stmt_get_result($stmt));
                $userEmail = $emailArray["count(user_email)"];
                if($userEmail == 0 || $userEmail == NULL){
                    $_SESSION["userErrCode"] = "WRONG_CREDS";
                    $_SESSION["userErrMsg"] = "Invalid username or password. Please re-enter the credentials";
                    header("refresh:0;url=$backPage?$errorType");
                    die();
                }//end if
                //echo "SUCCESS QUERY USERS TABLE FOR EMAIL!";
            } else {
                $_SESSION["userErrCode"] = "MYSQL_ERROR";
                $_SESSION["userErrMsg"] = "MySQL error encountered: ".mysqli_error($conn)." Please contact the administrator if you believe that this should not happen.";
                header("refresh:0;url=$backPage?$errorType");
            }

            mysqli_stmt_close($stmt);
        }

        // Validate password
        if(empty(trim($_POST["signInPassword"]))){
            $password_err = "Please enter a password.";
            die(/*$password_err*/);
        } elseif(strlen(trim($_POST["signInPassword"])) < 8){
            $_SESSION["userErrCode"] = "INVALID_PASSWORD";
            $_SESSION["userErrMsg"] = "Password is invalid. Password must have at least 8 characters.";
            header("refresh:0;url=$backPage?$errorType");
            die();
        } else{
            $password = trim($_POST["signInPassword"]);
        }

        //get usercreds
        $getUserCredsSQL = "SELECT user_id, user_password, user_enabled, user_type FROM users WHERE user_email = (?)";
        if ($stmt=mysqli_prepare($conn, $getUserCredsSQL)){
            mysqli_stmt_bind_param($stmt, "s", $user_email);

            $user_email = $email;

            if(mysqli_stmt_execute($stmt)){
                $usersArray = mysqli_fetch_array(mysqli_stmt_get_result($stmt));
                $userId = $usersArray["user_id"];
                $userPass = $usersArray["user_password"];
                $userEnabled = $usersArray["user_enabled"];
                $userType = $usersArray["user_type"];
                //echo "SUCCESS QUERY USERS TABLE!\n";
            } else {
                $_SESSION["userErrCode"] = "MYSQL_ERROR";
                $_SESSION["userErrMsg"] = "MySQL error encountered: ".mysqli_error($conn)." Please contact the administrator if you believe that this should not happen.";
                header("refresh:0;url=$backPage?$errorType");
                //echo "MYSQL ERROR QUERY USERS TABLE! ".mysqli_error($conn);

            }

            mysqli_stmt_close($stmt);
        }

        //check if user is disabled
        if($userEnabled == 0){
            $_SESSION["userErrCode"] = "ACCOUNT_DISABLED";
            $_SESSION["userErrMsg"] = "Account is permanently disabled. Please contact the administrator if you believe that this should not happen.";
            header("refresh:0;url=$backPage?$errorType");
        }

        if(password_verify($password, $userPass)){
            //correct password
            if($userType == 0){
                //customer
                $getCustInfoSQL = "SELECT cust_id, cust_name, cust_dob, cust_gender, cust_phone FROM customers WHERE user_id = (?)";
                if ($stmt=mysqli_prepare($conn, $getCustInfoSQL)){
                    mysqli_stmt_bind_param($stmt, "i", $u_id);

                    $u_id = $userId;

                    if(mysqli_stmt_execute($stmt)){
                        $custArray = mysqli_fetch_array(mysqli_stmt_get_result($stmt));
                        $custId = $custArray["cust_id"];
                        $custName = $custArray["cust_name"];
                        $custDob = $custArray["cust_dob"];
                        $custTel = $custArray["cust_phone"];
                        //echo "SUCCESS QUERY USERS TABLE!<br>";
                    } else {
                        $_SESSION["userErrCode"] = "MYSQL_ERROR";
                        $_SESSION["userErrMsg"] = "MySQL error encountered: ".mysqli_error($conn)." Please contact the administrator if you believe that this should not happen.";
                        header("refresh:0;url=$backPage?$errorType");
                        //echo "MYSQL ERROR QUERY USERS TABLE! ".mysqli_error($conn);
                    }

                    mysqli_stmt_close($stmt);
                }
                $_SESSION["utype"] = "customer";
                $_SESSION["email"] = $email;
                $_SESSION["uid"] = $userId;
                $_SESSION["name"] = $custName;
                $_SESSION["dob"] = $custDob;
                $_SESSION["tel"] = $custTel;
                $_SESSION["cust_id"] = $custId;
                header("refresh:0;url=/customer/index.php");
            } else if ($userType >= 1 && $userType <= 2){
                //employees
                $getEmpInfoSQL = "SELECT emp_id, emp_name, emp_dob, emp_gender, emp_phone, pos_id FROM employees WHERE user_id = (?)";
                if ($stmt=mysqli_prepare($conn, $getEmpInfoSQL)){
                    mysqli_stmt_bind_param($stmt, "i", $u_id);

                    $u_id = $userId;

                    if(mysqli_stmt_execute($stmt)){
                        $empArray = mysqli_fetch_array(mysqli_stmt_get_result($stmt));
                        $empId = $empArray["emp_id"];
                        $empName = $empArray["emp_name"];
                        $empDob = $empArray["emp_dob"];
                        $empGender = $empArray["emp_gender"];
                        $empTel = $empArray["emp_phone"];
                        $posId = $empArray["pos_id"];
                        //echo "SUCCESS QUERY USERS TABLE!<br>";
                    } else {
                        $_SESSION["userErrCode"] = "MYSQL_ERROR";
                        $_SESSION["userErrMsg"] = "MySQL error encountered: ".mysqli_error($conn)." Please contact the administrator if you believe that this should not happen.";
                        header("refresh:0;url=$backPage?$errorType");
                        //echo "MYSQL ERROR QUERY USERS TABLE! ".mysqli_error($conn);
                    }

                    mysqli_stmt_close($stmt);
                }
                $_SESSION["email"] = $email;
                $_SESSION["uid"] = $userId;
                $_SESSION["name"] = $empName;
                $_SESSION["tel"] = $empTel;
                $_SESSION["emp_id"] = $empId;
                $_SESSION["pos_id"] = $posId;
                switch($userType){
                    case 1: //staff
                        $_SESSION["utype"] = "staff";
                        header("refresh:0;url=/staff/index.php");
                        break;
                    case 2: //admin
                        $_SESSION["utype"] = "admin";
                        header("refresh:0;url=/admin/index.php");
                        break;
                }
            } else {
                $_SESSION["userErrCode"] = "WRONG_CREDS";
                $_SESSION["userErrMsg"] = "Invalid username or password. Please re-enter the credentials";
                header("refresh:0;url=$backPage?$errorType");
                //echo '<script>alert("Wrong password. Returning to login page...")</script>';
                //header("refresh:0;url=$backPage");
            }
        } else {
            $_SESSION["userErrCode"] = "WRONG_CREDS";
            $_SESSION["userErrMsg"] = "Invalid username or password. Please re-enter the credentials";
            header("refresh:0;url=$backPage?$errorType");
        }
    } else {
        mysqli_close($conn);
        http_response_code(405);
        //header('X-PHP-Response-Code: 405', true, 405);
        die();
    }
    mysqli_close($conn);
?>