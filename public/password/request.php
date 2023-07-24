<?php
$SERVERROOT = $_SERVER["DOCUMENT_ROOT"];
$PROJECTROOT = $_SERVER["DOCUMENT_ROOT"] . '/..';
$pageTitle = "Ahvelo Coffee - Request Password Reset";
session_start();
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
        <div class="fw-black row px-2 h2">REQUEST RESET PASSWORD</div>
        <div class="mb-3 fs-5">Do you want to request for a password reset link?</div>
        <div class="ms-0 ps-0 container">
            <form id="reqPassForm" action="/api/request/password.php" method="post">
                <div class="mb-3">Please enter the account email address. We will deliver a password reset link to this address, if an account associated with this address is found.</div>
                <div class="form-floating mb-3">
                    <input class="form-control" name="email" type="text" placeholder="Email" required/>
                    <label for="email">E-mail</label>
                </div>
            </form>
            <button class="float-end btn btn-primary ahvbutton" form="reqPassForm" type="submit">Request Password Reset</button>
        </div>
    </div>
</div>
<?php
include($PROJECTROOT . '/internal/footer.php');
?>