<?php

//login api

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Ahvelo Coffee - Processing request...</title>
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
                $backPage = "/login.php";
            }

            $backPage = $_SESSION["backPage"];

            if(isset($_SESSION["uid"])){
                //user is logged in already
                $_SESSION["userErrCode"] = "SESSION_EXISTS";
                $_SESSION["userErrMsg"] = "You are already logged in. Please log out to log in as another user.";
                header("refresh:0;url=$backPage?error=true");
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
                    header("refresh:0;url=$backPage?error=true");
                    die();
                }
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $_SESSION["userErrCode"] = "INVALID_EMAIL";
                    $_SESSION["userErrMsg"] = "Email is invalid. Please make sure that your email is valid.";
                    header("refresh:0;url=$backPage?error=true");
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
                            header("refresh:0;url=$backPage?error=true");
                            die();
                        }//end if
                        //echo "SUCCESS QUERY USERS TABLE FOR EMAIL!<br>";
                    } else {
                        $_SESSION["userErrCode"] = "MYSQL_ERROR";
                        $_SESSION["userErrMsg"] = "MySQL error encountered: ".mysqli_error($conn)." Please contact the administrator if you believe that this should not happen.";
                        header("refresh:0;url=$backPage?error=true");
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
                    header("refresh:0;url=$backPage?error=true");
                    die();
                } else{
                    $password = trim($_POST["signInPassword"]);
                }

                //get usercreds
                $getUserCredsSQL = "SELECT user_id, user_pass, user_type FROM users WHERE user_email = (?)";
                if ($stmt=mysqli_prepare($conn, $getUserCredsSQL)){
                    mysqli_stmt_bind_param($stmt, "s", $user_email);

                    $user_email = $email;

                    if(mysqli_stmt_execute($stmt)){
                        $usersArray = mysqli_fetch_array(mysqli_stmt_get_result($stmt));
                        $userId = $usersArray["user_id"];
                        $userPass = $usersArray["user_pass"];
                        $userType = $usersArray["user_type"];
                        //echo "SUCCESS QUERY USERS TABLE!\n";
                    } else {
                        $_SESSION["userErrCode"] = "MYSQL_ERROR";
                        $_SESSION["userErrMsg"] = "MySQL error encountered: ".mysqli_error($conn)." Please contact the administrator if you believe that this should not happen.";
                        header("refresh:0;url=$backPage?error=true");
                        //echo "MYSQL ERROR QUERY USERS TABLE! ".mysqli_error($conn);

                    }

                    mysqli_stmt_close($stmt);
                }

                if(password_verify($password, $userPass)){
                    //correct password
                    if($userType == 0){
                        //student
                        $getStudentInfoSQL = "SELECT student_id, student_name, student_telno, club_id FROM students WHERE user_id = (?)";
                        if ($stmt=mysqli_prepare($conn, $getStudentInfoSQL)){
                            mysqli_stmt_bind_param($stmt, "i", $u_id);

                            $u_id = $userId;

                            if(mysqli_stmt_execute($stmt)){
                                $studentArray = mysqli_fetch_array(mysqli_stmt_get_result($stmt));
                                $studentId = $studentArray["student_id"];
                                $studentName = $studentArray["student_name"];
                                $studentTel = $studentArray["student_telno"];
                                $studentClubId = $studentArray["club_id"];
                                //echo "SUCCESS QUERY USERS TABLE!<br>";
                            } else {
                                $_SESSION["userErrCode"] = "MYSQL_ERROR";
                                $_SESSION["userErrMsg"] = "MySQL error encountered: ".mysqli_error($conn)." Please contact the administrator if you believe that this should not happen.";
                                header("refresh:0;url=$backPage?error=true");
                                //echo "MYSQL ERROR QUERY USERS TABLE! ".mysqli_error($conn);
                            }

                            mysqli_stmt_close($stmt);
                        }
                        $_SESSION["utype"] = "student";
                        $_SESSION["email"] = $email;
                        $_SESSION["uid"] = $userId;
                        $_SESSION["name"] = $studentName;
                        $_SESSION["tel"] = $studentTel;
                        $_SESSION["student_id"] = $studentId;
                        $_SESSION["club_id"] = $studentClubId;
                        header("refresh:0;url=/student/index.php");
                    } else if ($userType == 1){
                        //admin
                        $getAdminInfoSQL = "SELECT admin_id, admin_name, admin_telno FROM admins WHERE user_id = (?)";
                        if ($stmt=mysqli_prepare($conn, $getAdminInfoSQL)){
                            mysqli_stmt_bind_param($stmt, "i", $u_id);

                            $u_id = $userId;

                            if(mysqli_stmt_execute($stmt)){
                                $adminArray = mysqli_fetch_array(mysqli_stmt_get_result($stmt));
                                $adminId = $adminArray["admin_id"];
                                $adminName = $adminArray["admin_name"];
                                $adminTel = $adminArray["admin_telno"];
                                //echo "SUCCESS QUERY USERS TABLE!<br>";
                            } else {
                                $_SESSION["userErrCode"] = "MYSQL_ERROR";
                                $_SESSION["userErrMsg"] = "MySQL error encountered: ".mysqli_error($conn)." Please contact the administrator if you believe that this should not happen.";
                                header("refresh:0;url=$backPage?error=true");
                                //echo "MYSQL ERROR QUERY USERS TABLE! ".mysqli_error($conn);
                            }

                            mysqli_stmt_close($stmt);
                        }
                        $_SESSION["utype"] = "admin";
                        $_SESSION["email"] = $email;
                        $_SESSION["uid"] = $userId;
                        $_SESSION["name"] = $adminName;
                        $_SESSION["tel"] = $adminTel;
                        $_SESSION["admin_id"] = $adminId;
                        header("refresh:0;url=/admin/index.php");
                    } else if ($userType == 2){
                        //officer
                        $getOfficerInfoSQL = "SELECT officer_id, officer_name, officer_telno FROM officers WHERE user_id = (?)";
                        if ($stmt=mysqli_prepare($conn, $getOfficerInfoSQL)){
                            mysqli_stmt_bind_param($stmt, "i", $u_id);

                            $u_id = $userId;

                            if(mysqli_stmt_execute($stmt)){
                                $officerArray = mysqli_fetch_array(mysqli_stmt_get_result($stmt));
                                $officerId = $officerArray["officer_id"];
                                $officerName = $officerArray["officer_name"];
                                $officerTel = $officerArray["officer_telno"];
                                //echo "SUCCESS QUERY USERS TABLE!<br>";
                            } else {
                                $_SESSION["userErrCode"] = "MYSQL_ERROR";
                                $_SESSION["userErrMsg"] = "MySQL error encountered: ".mysqli_error($conn)." Please contact the administrator if you believe that this should not happen.";
                                header("refresh:0;url=$backPage?error=true");
                                //echo "MYSQL ERROR QUERY USERS TABLE! ".mysqli_error($conn);
                            }

                            mysqli_stmt_close($stmt);
                        }
                        $_SESSION["utype"] = "officer";
                        $_SESSION["email"] = $email;
                        $_SESSION["uid"] = $userId;
                        $_SESSION["name"] = $officerName;
                        $_SESSION["tel"] = $officerTel;
                        $_SESSION["officer_id"] = $officerId;
                        header("refresh:0;url=/officer/index.php");
                    } else if ($userType == 3){
                        //officer
                        $getAttendeeInfoSQL = "SELECT attendee_id, attendee_name, attendee_telno, attendee_course FROM attendees WHERE user_id = (?)";
                        if ($stmt=mysqli_prepare($conn, $getAttendeeInfoSQL)){
                            mysqli_stmt_bind_param($stmt, "i", $u_id);

                            $u_id = $userId;

                            if(mysqli_stmt_execute($stmt)){
                                $attendeeArray = mysqli_fetch_array(mysqli_stmt_get_result($stmt));
                                $attendeeId = $attendeeArray["attendee_id"];
                                $attendeeName = $attendeeArray["attendee_name"];
                                $attendeeTel = $attendeeArray["attendee_telno"];
                                $attendeeCourse = $attendeeArray["attendee_course"];
                                //echo "SUCCESS QUERY USERS TABLE!<br>";
                            } else {
                                $_SESSION["userErrCode"] = "MYSQL_ERROR";
                                $_SESSION["userErrMsg"] = "MySQL error encountered: ".mysqli_error($conn)." Please contact the administrator if you believe that this should not happen.";
                                header("refresh:0;url=$backPage?error=true");
                                //echo "MYSQL ERROR QUERY USERS TABLE! ".mysqli_error($conn);
                            }

                            mysqli_stmt_close($stmt);
                        }
                        $_SESSION["utype"] = "attendee";
                        $_SESSION["email"] = $email;
                        $_SESSION["uid"] = $userId;
                        $_SESSION["name"] = $attendeeName;
                        $_SESSION["tel"] = $attendeeTel;
                        $_SESSION["attendee_id"] = $attendeeId;
                        header("refresh:0;url=/attendee/index.php");
                    } else {
                        $_SESSION["userErrCode"] = "WRONG_CREDS";
                        $_SESSION["userErrMsg"] = "Invalid username or password. Please re-enter the credentials";
                        header("refresh:0;url=$backPage?error=true");
                        //echo '<script>alert("Wrong password. Returning to login page...")</script>';
                        //header("refresh:0;url=$backPage");
                    }
                } else {
                    $_SESSION["userErrCode"] = "WRONG_CREDS";
                    $_SESSION["userErrMsg"] = "Invalid username or password. Please re-enter the credentials";
                    header("refresh:0;url=$backPage?error=true");
                }
            } else {
                mysqli_close($conn);
                die("<p>Invalid method.</p>");
            }
            mysqli_close($conn);
        ?>
    </body>
</html>