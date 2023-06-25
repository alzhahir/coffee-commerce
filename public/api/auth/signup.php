<?php
    session_start();
    $ROOTPATH = $_SERVER["DOCUMENT_ROOT"] . '/..';
    //echo "<p>Processing your sign up request...</p>";
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    // Include config file
    require_once $ROOTPATH . "/internal/db.php";

    if(!isset($_SESSION["backPage"])){
        //backPage is not set, defaulting to login.php
        $backPage = "/signup.php";
    }

    $backPage = $_SESSION["backPage"];

    if(isset($_SESSION["uid"]) && strpos($backPage, 'new.php') === false){
        //user is logged in already
        $_SESSION["userErrCode"] = "SESSION_EXISTS";
        $_SESSION["userErrMsg"] = "You are already logged in. Please log out to sign up as another user.";
        header("refresh:0;url=$backPage?error=true");
        die();
    }

    // Define variables and initialize with empty values
    //$username = $password = $confirm_password = "";
    //$username_err = $password_err = $confirm_password_err = "";

    // Processing form data when form is submitted
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $role = $_POST["role"];

        if($role > 0){
            if(!isset($_POST["posid"])){
                $_SESSION["userErrCode"] = "NO_POS_ID";
                $_SESSION["userErrMsg"] = "Position ID is missing. Please select a position or contact the administrator if you believe that this should not happen.";
                header("refresh:0;url=$backPage?error=true");
                die() ;
            }
            $posid = $_POST["posid"];
            //get poslist
            //check if poslist exists
            $poslistsql = "SELECT pos_id FROM positions WHERE pos_id = (?)" ;
            if ($stmt=mysqli_prepare($conn, $poslistsql)){
                mysqli_stmt_bind_param($stmt, "i", $pos_id);

                $pos_id = $posid;

                if(mysqli_stmt_execute($stmt)){
                    $posidArray = mysqli_fetch_array(mysqli_stmt_get_result($stmt));
                    $posIdRes = $posidArray["pos_id"];
                    if($posIdRes == 0 || $posIdRes == NULL){
                        $_SESSION["userErrCode"] = "INVALID_POS_ID";
                        $_SESSION["userErrMsg"] = "Position ID is invalid. Please view the position list or contact the administrator if you believe that this should not happen.";
                        header("refresh:0;url=$backPage?error=true");
                        die() ;
                    }//end if
                    //echo "SUCCESS QUERY USERS TABLE FOR CLUB_ID!<br>";
                } else {
                    //echo "MYSQL ERROR QUERY USERS TABLE! ".mysqli_error($conn);
                    $_SESSION["userErrCode"] = "MYSQL_ERROR";
                    $_SESSION["userErrMsg"] = "MySQL error encountered: ".mysqli_error($conn)." Please contact the administrator if you believe that this should not happen.";
                    header("refresh:0;url=$backPage?error=true");
                    die();
                }

                mysqli_stmt_close($stmt);
            }
        }

        //echo "<p>Please wait for a few seconds.</p>";
        $email = $_POST["email"];
        if(empty(trim($_POST["email"]))){
            $_SESSION["userErrCode"] = "INVALID_EMAIL";
            $_SESSION["userErrMsg"] = "Email is invalid. Please make sure that your email is valid.";
            header("refresh:0;url=$backPage?error=true");
            die();
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION["userErrCode"] = "INVALID_EMAIL";
            $_SESSION["userErrMsg"] = "Email is invalid. Please make sure that your email is valid.";
            header("refresh:0;url=$backPage?error=true");
            die();
        }

        // Validate password
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

        // Validate confirm password
        if(empty(trim($_POST["confirmPassword"]))){
            $_SESSION["userErrCode"] = "CONFIRM_PASSWORD_NONEXISTANT";
            $_SESSION["userErrMsg"] = "Please enter the password confirmation.";
            header("refresh:0;url=$backPage?error=true");
            die();
        } else{
            $confirm_password = trim($_POST["confirmPassword"]);
            if(empty($password_err) && ($password != $confirm_password)){
                $_SESSION["userErrCode"] = "CONFIRM_PASSWORD_MISMATCH";
                $_SESSION["userErrMsg"] = "Confirmation password does not match with the password.";
                header("refresh:0;url=$backPage?error=true");
                die();
            }
        }

        $password = password_hash($password, PASSWORD_DEFAULT);
        $name = $_POST["name"];
        $tel = $_POST["telephone"];
        $gender = $_POST["gender"];
        $dob = $_POST["dob"];

        if ($role < 0 || $role > 2){
            $_SESSION["userErrCode"] = "INVALID_ROLE";
            $_SESSION["userErrMsg"] = "User role is invalid. Please contact the administrator for further assistance.";
            header("refresh:0;url=$backPage?error=true");
            die();
        }

        // check for invalid names
        if(preg_match('~[0-9]+~', $name)){
            $_SESSION["userErrCode"] = "INVALID_NAME";
            $_SESSION["userErrMsg"] = "User name is invalid. Numbers are not allowed on names.";
            header("refresh:0;url=$backPage?error=true");
            die();
        }

        //MYSQL STATEMENTS BELOW
        //check for duplicate email
        $emailsql = "SELECT count(user_email) FROM users WHERE user_email = (?)" ;
        if ($stmt=mysqli_prepare($conn, $emailsql)){
            mysqli_stmt_bind_param($stmt, "s", $user_email);

            $user_email = $email;

            if(mysqli_stmt_execute($stmt)){
                $emailArray = mysqli_fetch_array(mysqli_stmt_get_result($stmt));
                $userEmail = $emailArray["count(user_email)"];
                if($userEmail > 0 || $userEmail != NULL){
                    $_SESSION["userErrCode"] = "EMAIL_EXISTS";
                    $_SESSION["userErrMsg"] = "The account for this email already exists. Please log in instead.";
                    header("refresh:0;url=$backPage?error=true");
                    die();
                }//end if
                //echo "SUCCESS QUERY USERS TABLE FOR EMAIL!<br>";
            } else {
                $_SESSION["userErrCode"] = "MYSQL_ERROR";
                $_SESSION["userErrMsg"] = "MySQL error encountered: ".mysqli_error($conn)." Please contact the administrator if you believe that this should not happen.";
                header("refresh:0;url=$backPage?error=true");
                die();
            }

            mysqli_stmt_close($stmt);
        }

        //prepare mysql statements for user
        $signUpSQL = "INSERT INTO users (user_email, user_password, user_type) VALUES (?, ?, ?)";
        if ($stmt=mysqli_prepare($conn, $signUpSQL)){
            mysqli_stmt_bind_param($stmt, "ssi", $db_email, $db_password, $db_type);

            $db_email = $email;
            $db_password = $password;
            $db_type = $role;

            if(mysqli_stmt_execute($stmt)){
                //echo "SUCCESS ADD TO USERS TABLE!<br>";
            } else {
                $_SESSION["userErrCode"] = "MYSQL_ERROR";
                $_SESSION["userErrMsg"] = "MySQL error encountered: ".mysqli_error($conn)." Please contact the administrator if you believe that this should not happen.";
                header("refresh:0;url=$backPage?error=true");
                die();
            }

            mysqli_stmt_close($stmt);
        }

        //get userid
        $getUserIDSQL = "SELECT user_id FROM users WHERE user_email = (?)";
        if ($stmt=mysqli_prepare($conn, $getUserIDSQL)){
            mysqli_stmt_bind_param($stmt, "s", $user_email);

            $user_email = $email;

            if(mysqli_stmt_execute($stmt)){
                $usersArray = mysqli_fetch_array(mysqli_stmt_get_result($stmt));
                $userId = $usersArray["user_id"];
                //echo "SUCCESS QUERY USERS TABLE!<br>";
            } else {
                $_SESSION["userErrCode"] = "MYSQL_ERROR";
                $_SESSION["userErrMsg"] = "MySQL error encountered: ".mysqli_error($conn)." Please contact the administrator if you believe that this should not happen.";
                header("refresh:0;url=$backPage?error=true");
                die();
            }

            mysqli_stmt_close($stmt);
        }

        //prepare mysql statements for role-specific stuff
        if ($role == 0){
            //customers
            $custSignUpSQL = "INSERT INTO customers (cust_name, cust_dob, cust_gender, cust_phone, user_id) VALUES (?, ?, ?, ?, ?)";
            if ($stmt=mysqli_prepare($conn, $custSignUpSQL)){
                mysqli_stmt_bind_param($stmt, "ssssi", $ct_name, $ct_dob, $ct_gender, $ct_phone, $u_id);

                $ct_name = $name;
                $ct_dob = $dob;
                $ct_gender = $gender;
                $ct_phone = $tel;
                $u_id = $userId;

                if(mysqli_stmt_execute($stmt)){
                    //echo "SUCCESS ADD TO STUDENTS TABLE!<br>";
                } else {
                    $_SESSION["userErrCode"] = "MYSQL_ERROR";
                    $_SESSION["userErrMsg"] = "MySQL error encountered: ".mysqli_error($conn)." Please contact the administrator if you believe that this should not happen.";
                    header("refresh:0;url=$backPage?error=true");
                    die();
                }

                mysqli_stmt_close($stmt);
            }
        } else if($role >= 1 && $role <=2) {
            //employees
            $empSignUpSQL = "INSERT INTO employees (emp_name, emp_dob, emp_gender, emp_phone, pos_id, user_id) VALUES (?, ?, ?, ?, ?, ?)";
            if ($stmt=mysqli_prepare($conn, $empSignUpSQL)){
                mysqli_stmt_bind_param($stmt, "ssssii", $emp_name, $emp_dob, $emp_gender, $emp_phone, $p_id, $u_id);

                $emp_name = $name;
                $emp_dob = $dob;
                $emp_gender = $gender;
                $emp_phone = $tel;
                $p_id = $posid;
                $u_id = $userId;

                if(mysqli_stmt_execute($stmt)){
                    //echo "SUCCESS ADD TO ADMINS TABLE!<br>";
                } else {
                    $_SESSION["userErrCode"] = "MYSQL_ERROR";
                    $_SESSION["userErrMsg"] = "MySQL error encountered: ".mysqli_error($conn)." Please contact the administrator if you believe that this should not happen.";
                    header("refresh:0;url=$backPage?error=true");
                    die();
                }

                mysqli_stmt_close($stmt);
            }
        } else {
            $_SESSION["userErrCode"] = "INVALID_ROLE_DB";
            $_SESSION["userErrMsg"] = "Role is invalid when adding to database. CONTACT THE ADMINSTRATOR.";
            header("refresh:0;url=$backPage?error=true");
            die();
        }
        
    } else {
        mysqli_close($conn);
        die("<p>Invalid method.</p>");
    }
    mysqli_close($conn);
    $_SESSION["userErrCode"] = "SIGNUP_SUCCESS";
    $_SESSION["userErrMsg"] = "Sign up success. You may login now.";
    header("refresh:0;url=$backPage?signup=success");
?>