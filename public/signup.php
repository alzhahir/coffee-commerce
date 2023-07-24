<?php
session_start();
include('../internal/htmlhead.php');
include('../internal/header.php');
$pageTitle = "Ahvelo Coffee - Account";
?>
<div class="px-3 pb-5">
    <div class="row d-flex flex-wrap align-items-center justify-content-center">
        <div class="alert mb-0 alert-info mx-2">
            <span class="fw-bold">
                Forgot your password? <a href="/password/request.php">Reset here</a>.
            </span>
        </div>
    </div>
    <div class="row d-flex flex-wrap align-items-center justify-content-center h-100">
        <?php 
            $_SESSION["backPage"] = $_SERVER["PHP_SELF"];
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
            if(isset($_GET["signup"])){
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
        <div class="col pb-3">
            <h3 class="fw-black">SIGN UP</h3>
            <p>Sign up for the HEARTVELO membership now! Please fill in this form to continue. Please note that gender and date of birth are permanent and cannot be edited later.</p>
            <form id="signupForm" action="/api/auth/signup.php" method="post">
                <div class="form-floating mb-3">
                    <input class="form-control" name="email" type="email" placeholder="Email Address" required/>
                    <label for="emailAddress">Email Address</label>
                </div>
                <div class="form-floating mb-3">
                    <input class="form-control" name="password" type="password" placeholder="Password" required/>
                    <label for="password">Password</label>
                </div>
                <div class="form-floating mb-3">
                    <input class="form-control" name="confirmPassword" type="password" placeholder="Confirm Password" required/>
                    <label for="password">Confirm Password</label>
                </div>
                <div class="form-floating mb-3">
                    <input class="form-control" name="name" type="text" placeholder="Name" required/>
                    <label for="name">Name</label>
                </div>
                <div class="form-floating mb-3">
                    <input class="form-control" name="dob" type="date" placeholder="Date of Birth" required/>
                    <label for="dob">Date of Birth</label>
                </div>
                <div class="form-floating mb-3">
                    <select class="form-select" name="gender" aria-label="Gender">
                        <option value="0">Male</option>
                        <option value="1">Female</option>
                        <option value="2">Prefer not to say</option>
                    </select>
                    <label for="gender">Gender</label>
                </div>
                <div class="form-floating mb-3">
                    <input class="form-control number" name="telephone" type="text" placeholder="Telephone" onkeydown='{(evt) => ["e", "E", "-"].includes(evt.key) && evt.preventDefault()}' required/>
                    <label for="telephone">Telephone</label>
                </div>
                <!--The code below is left as is to enable the usage of doSignUp.php as a some sort of an API to allow other
                forms to reuse the same code. (cant leave the role POST as null)-->
                <div class="form-floating mb-3" hidden disabled readonly>
                    <select id="userRole" class="form-select" name="role" aria-label="Role">
                        <option value="0">Customer</option>
                    </select>
                    <label for="role">Role</label>
                </div>
                <div class="d-grid">
                    <button class="btn btn-primary btn-lg ahvbutton" id="signUpButton" type="submit">Sign Up</button>
                </div>
            </form>
        </div>
        <div class="d-flex flex-column col-auto flex-wrap align-items-center justify-content-center sgfd-parent">
            <div class="sgfd"></div>
        </div>
        <div class="col py-3 pb-5">
            <h3 class="fw-black">SIGN IN</h3>
            <p>Alternatively, sign in if you have a HEARTVELO membership account.</p>
            <form id="signupLoginForm" action="/api/auth/login.php?errorType=error" method="post">
                <div class="form-floating mb-2">
                    <input class="form-control" name="signInEmail" type="email" placeholder="Email Address" required/>
                    <label for="emailAddress">Email Address</label>
                </div>
                <div class="form-floating mb-2">
                    <input class="form-control" name="signInPassword" type="password" placeholder="Password" required/>
                    <label for="password">Password</label>
                </div>
            </form>
            <div class="d-grid">
                <button class="btn btn-primary btn-lg ahvbutton" form="signupLoginForm" id="signInButton" type="submit">Sign In</button>
            </div>
        </div>
    </div>
</div>
<script>
    document.querySelector(".number").addEventListener("keypress", function (evt) {
        if (evt.which != 8 && evt.which != 0 && evt.which < 48 || evt.which > 57)
        {
            evt.preventDefault();
        }
    });
</script>
<?php
include('../internal/footer.php');
?>