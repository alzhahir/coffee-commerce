<?php
$SERVERROOT = $_SERVER["DOCUMENT_ROOT"];
$PROJECTROOT = $_SERVER["DOCUMENT_ROOT"] . '/..';
$ROOTPATH = $_SERVER["DOCUMENT_ROOT"] . '/..';
require_once $ROOTPATH . "/internal/db.php";
$pageTitle = "Ahvelo Coffee - Reset Password";
if(!isset($_GET['token'])){
    include_once($PROJECTROOT . '/public/error/401.php');
    exit();
}
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
//check token validity
$reset_token = $_GET['token'];

$getCustInfoSQL = "SELECT token_exp, user_email FROM password_resets WHERE reset_token = (?)";
if ($stmt=mysqli_prepare($conn, $getCustInfoSQL)){
    mysqli_stmt_bind_param($stmt, "s", $r_token);

    $r_token = $reset_token;

    if(mysqli_stmt_execute($stmt)){
        $resetArray = mysqli_fetch_array(mysqli_stmt_get_result($stmt));
        $userEmail = $resetArray["user_email"];
        $expDate = $resetArray['token_exp'];
        //echo "SUCCESS QUERY USERS TABLE!<br>";
    } else {
        $_SESSION["userErrCode"] = "MYSQL_ERROR";
        $_SESSION["userErrMsg"] = "MySQL error encountered: ".mysqli_error($conn)." Please contact the administrator if you believe that this should not happen.";
        header("refresh:0;url=$backPage?$errorType");
        //echo "MYSQL ERROR QUERY USERS TABLE! ".mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
}

$_SESSION['mail'] = $userEmail;

if($expDate <= strtotime('now')){
    include_once($PROJECTROOT . '/public/error/404.php');
    exit();
}

include($PROJECTROOT . '/internal/htmlhead.php');
include($PROJECTROOT . '/internal/header.php');
?>
<div class="px-3 pb-3">
    <div class="px-2">
        <?php 
            $_SESSION["backPage"] = '/signup.php';
            //check if $_GET isset
            if(isset($_GET["error"])){
                //error exists
                echo "<div class=\"alert alert-danger\">";
                if(isset($_SESSION["userErrMsg"])){
                    //get err msg
                    $errMsg = $_SESSION["userErrMsg"];
                    $errCode = $_SESSION["userErrCode"];
                    echo "<h5 class=\"my-0 fw-semibold\" style=\"text-align: justify; text-justify: inter-word;\">$errMsg</h5>";
                    echo "<p class=\"my-0 fst-italic fw-light\">Error code: $errCode</p>";
                }
                echo "</div>";
            }
            if(isset($_GET["reset"])){
                echo "<div class=\"alert alert-success\">";
                if(isset($_SESSION["userErrMsg"])){
                    //get err msg
                    $errMsg = $_SESSION["userErrMsg"];
                    $errCode = $_SESSION["userErrCode"];
                    echo "<h5 class=\"my-0 fw-semibold\" style=\"text-align: justify; text-justify: inter-word;\">$errMsg</h5>";
                }
                echo "</div>";
            }
        ?>
        <div class="fw-black row px-2 h2">RESET PASSWORD</div>
        <div class="mb-3 fs-5">You have requested for a password reset.</div>
        <form id="resetPassForm" action="/api/update/password.php" method="post">
            <div class="form-floating mb-3">
                <input class="form-control" name="password" type="password" placeholder="Password" required/>
                <label for="password">Password</label>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control" name="confirmPassword" type="password" placeholder="Confirm Password" required/>
                <label for="password">Confirm Password</label>
            </div>
        </form>
        <button class="float-end btn btn-primary ahvbutton" form="resetPassForm" type="submit">Reset Password</button>
    </div>
</div>
<?php
include($PROJECTROOT . '/internal/footer.php');
?>