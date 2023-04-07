<!DOCTYPE html>
<html>
    <head>
        <title>AHVELO - api/auth/login</title>
    </head>
    <body>
        <!--h1>Authenticating...</h1-->
        <?php
            session_start();
            //echo "<p>Processing your sign in request...</p>";
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
            // Include config file
            require_once "../../../internal/db.php";
            
            if(!isset($_SESSION["backPage"])){
                //backPage is not set, defaulting to login.php
                $backPage = "/index.php";
            }

            if(!isset($_SESSION["errorType"])){
                //errorType is not set, defaulting to error
                $errorType = "error";
            }

            $errorType = $_SESSION["errorType"];
            $backPage = $_SESSION["backPage"];

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
                        //echo "SUCCESS QUERY USERS TABLE FOR EMAIL!<br>";
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
                $getUserCredsSQL = "SELECT user_id, user_password, user_type FROM users WHERE user_email = (?)";
                if ($stmt=mysqli_prepare($conn, $getUserCredsSQL)){
                    mysqli_stmt_bind_param($stmt, "s", $user_email);

                    $user_email = $email;

                    if(mysqli_stmt_execute($stmt)){
                        $usersArray = mysqli_fetch_array(mysqli_stmt_get_result($stmt));
                        $userId = $usersArray["user_id"];
                        $userPass = $usersArray["user_password"];
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

                if(password_verify($password, $userPass)){
                    //correct password
                    if($userType == 0){
                        //customer
                        $getCustInfoSQL = "SELECT cust_id, cust_name, cust_dob, cust_gender, student_phone FROM students WHERE user_id = (?)";
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
                        $_SESSION["utype"] = "admin";
                        $_SESSION["email"] = $email;
                        $_SESSION["uid"] = $userId;
                        $_SESSION["name"] = $empName;
                        $_SESSION["tel"] = $empTel;
                        $_SESSION["admin_id"] = $empId;
                        $_SESSION["pos_id"] = $posId;
                        switch($userType){
                            case 1: //staff
                                header("refresh:0;url=/staff/index.php");
                                break;
                            case 2: //admin
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
                die("<p>Invalid method.</p>");
            }
            mysqli_close($conn);
        ?>
    </body>
</html>