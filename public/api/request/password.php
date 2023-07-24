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

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        //what to do?
        if(!isset($_POST['email'])){
            $_SESSION["userErrCode"] = "FORM_ERROR";
            $_SESSION["userErrMsg"] = "Form did not have adequate information. Please contact the administrator if you believe that this should not happen.";
            http_response_code(400);
            header("refresh:0;url=/signup.php?error=true");
        }
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION["userErrCode"] = "INVALID_EMAIL";
            $_SESSION["userErrMsg"] = "Email is invalid. Please make sure that your email is valid.";
            header("refresh:0;url=/signup.php?error=true");
            die();
        }

        $userMail = $_POST['email'];
        //check if there's account
        //check if email exists
        $emailsql = "SELECT count(user_email) FROM users WHERE user_email = (?)" ;
        if ($stmt=mysqli_prepare($conn, $emailsql)){
            mysqli_stmt_bind_param($stmt, "s", $user_email);

            $user_email = $userMail;

            if(mysqli_stmt_execute($stmt)){
                $emailArray = mysqli_fetch_array(mysqli_stmt_get_result($stmt));
                $userEmail = $emailArray["count(user_email)"];
                if($userEmail == 0 || $userEmail == NULL){
                    $_SESSION["userErrCode"] = "RESET_PASSWORD_DONE";
                    $_SESSION["userErrMsg"] = "If there is an account associated with this email, you will receive an email.";
                    header("refresh:0;url=/signup.php?signup=success");
                }//end if
                //echo "SUCCESS QUERY USERS TABLE FOR EMAIL!";
            } else {
                $_SESSION["userErrCode"] = "MYSQL_ERROR";
                $_SESSION["userErrMsg"] = "MySQL error encountered: ".mysqli_error($conn)." Please contact the administrator if you believe that this should not happen.";
                header("refresh:0;url=$backPage?$errorType");
            }

            mysqli_stmt_close($stmt);
        }

        //generate token
        $resToken = bin2hex(random_bytes(16)); //generates a crypto-secure 32 characters long

        //get current datetime in utc epoch, add 1 hour
        $expUtc = strtotime('+1 hour');

        $addTrackingSQL = "INSERT INTO password_resets (reset_token, token_exp, user_email) VALUES (?, ?, ?)";
        if ($stmt=mysqli_prepare($conn, $addTrackingSQL)){
            mysqli_stmt_bind_param($stmt, "sss", $reset_token, $token_exp, $user_email);

            $reset_token = $resToken;
            $token_exp = $expUtc;
            $user_email = $userMail;

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

        $DOMAIN = $_SERVER['HTTP_HOST'];
        $PROTOCOL = $_SERVER['HTTPS'] ? 'https://' : 'http://';
        if(str_contains($DOMAIN, 'localhost')){
            $DOMAIN = "fyp.alzhahir.com";
            $PROTOCOL = "https://";
        }

        //send email
        $emailApiUrl = $PROTOCOL.$DOMAIN."/api/create/mail.php";

        $subject = "[PASSWORD] Password Reset";

        $mailpostfields = [
            "recipient_address" => $userMail,
            "subject" => $subject,
            "alternative_body" => "Your password reset link is: ".$PROTOCOL.$DOMAIN."/password/reset.php?token=$resToken",
            "context" => 2,
            "mail_object" => [
                "reset_link" => "/password/reset.php?token=$resToken",
            ]
        ];

        $finalpost = http_build_query($mailpostfields);

        $req2 = curl_init();
        curl_setopt($req2, CURLOPT_URL, $emailApiUrl);
        curl_setopt($req2, CURLOPT_POST, true);
        curl_setopt($req2, CURLOPT_POSTFIELDS, $finalpost);
        curl_setopt($req2, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($req2, CURLOPT_SSL_VERIFYPEER, FALSE);
        $response2 = curl_exec($req2);
        $reserr2 = curl_error($req2);
        $rescode2 = curl_getinfo($req2, CURLINFO_HTTP_CODE);
        if(!$response2){
            error_log('Email Error '.$rescode2 . $reserr2);
        }
        curl_close($req2);

        $_SESSION["userErrCode"] = "RESET_PASSWORD_DONE";
        $_SESSION["userErrMsg"] = "If there is an account associated with this email, you will receive an email.";
        http_response_code(200);
        header("refresh:0;url=/signup.php?signup=success");
    }
?>