<?php
session_start();
include('../internal/htmlhead.php');
include('../internal/header.php');
?>
<div class="px-3">
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
            if(isset($_GET["success"])){
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
            <p>Sign up for the HEARTVELO membership now! Please fill in this form to continue.</p>
            <form id="signupForm" action="doSignUp.php" method="post">
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
                <div class="form-floating mb-3">
                    <select class="form-select" name="role" aria-label="Role">
                        <option value="0">Customer</option>
                        <option value="1">Staff</option>
                        <option value="2">Admin</option>
                    </select>
                    <label for="role">Role</label>
                </div>
                <div class="form-floating mb-3" id="clubField" style="display: none;">
                    <select class="form-select" name="clubid" id="clublist" aria-label="Club" required>
                        <option value=""></option>
                        <!--Code here-->
                    </select>
                    <label for="clubid">Club</label>
                </div>
                <div class="d-grid">
                    <button class="btn btn-primary btn-lg ahvbutton" id="signUpButton" type="submit">Sign Up</button>
                </div>
            </form>
        </div>
        <div class="d-flex flex-column col-auto flex-wrap align-items-center justify-content-center sgfd-parent">
            <div class="sgfd"></div>
        </div>
        <div class="col py-3">
            <h3 class="fw-black">SIGN IN</h3>
            <p>Alternatively, sign in if you have a HEARTVELO membership account.</p>
            <form id="signupLoginForm" action="/api/auth/login.php" method="post">
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
<script type="application/javascript">
    var xmlhttp = new XMLHttpRequest();
    var url = "/clubs/getClubId.php";
    document.querySelector(".number").addEventListener("keypress", function (evt) {
        if (evt.which != 8 && evt.which != 0 && evt.which < 48 || evt.which > 57)
        {
            evt.preventDefault();
        }
    });

    xmlhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            var data = JSON.parse(this.responseText);
            var htmlData = "<option value=\"\"></option>";
            for(let i = 0; i < data.clubId.length; i++){
                htmlData = htmlData.concat("\n", "<option value=\""+data.clubId[i]+"\">"+data.clubName[i]+"</option>\n");
            }
            document.getElementById("clublist").innerHTML = htmlData;
        }
    }
    xmlhttp.open("GET", url, true);
    xmlhttp.send();

    var roleSelection = document.getElementById('userRole');
    roleSelection.onchange = function(){
        if(roleSelection.selectedIndex === 1) {
            document.getElementById('courseId').style.display = "none";
            document.getElementById('courseCode').required = false;
            document.getElementById('courseCode').innerText = null;
            document.getElementById('clubField').style.display = "block";
            document.getElementById('clublist').required = true;
        } else if(roleSelection.selectedIndex === 4) {
            document.getElementById('clubField').style.display = "none";
            document.getElementById('clublist').required = false;
            document.getElementById('courseId').style.display = "block";
            document.getElementById('courseCode').required = true;
        } else {
            document.getElementById('clubField').style.display = "none";
            document.getElementById('clublist').required = false;
            document.getElementById('courseId').style.display = "none";
            document.getElementById('courseCode').required = false;
            document.getElementById('courseCode').innerText = null;
        }
    }
</script>
<?php
include('../internal/footer.php');
?>