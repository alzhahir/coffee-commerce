<?php
session_start();
$ROOTPATH = $_SERVER["DOCUMENT_ROOT"] . '/..';
include($ROOTPATH . '/internal/admincontrol.php');
include($ROOTPATH . '/internal/htmlhead.php');
include($ROOTPATH . '/internal/adminheader.php');
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
            <h3 class="fw-black">
                CREATE NEW USER
                <a class="btn btn-primary ahvbutton float-end" href="/admin/users/">
                    Go Back
                </a>
            </h3>
            <p>You can use this form to create new users.</p>
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
                <div class="form-floating mb-3">
                    <select id="userRole" class="form-select" name="role" aria-label="Role">
                        <option value="0">Customer</option>
                        <option value="1">Staff</option>
                        <option value="2">Admin</option>
                    </select>
                    <label for="role">Role</label>
                </div>
                <div class="form-floating mb-3" id="posField" style="display: none;">
                    <select class="form-select" name="posid" id="poslist" aria-label="Club">
                        <option value=""></option>
                        <!--Code here-->
                    </select>
                    <label for="posid">Position</label>
                </div>
                <div class="float-start">
                    <button class="btn btn-primary btn-lg ahvbutton" id="signUpButton" type="submit">Sign Up</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="application/javascript">
    var xmlhttp = new XMLHttpRequest();
    var url = "/api/get/positions.php";
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
            for(let i = 0; i < data.posId.length; i++){
                htmlData = htmlData.concat("\n", "<option value=\""+data.posId[i]+"\">"+data.posName[i]+"</option>\n");
            }
            document.getElementById("poslist").innerHTML = htmlData;
        }
    }
    xmlhttp.open("GET", url, true);
    xmlhttp.send();

    var roleSelection = document.getElementById('userRole');
    roleSelection.onchange = function(){
        if(roleSelection.selectedIndex === 1 || roleSelection.selectedIndex === 2) {
            document.getElementById('posField').style.display = "block";
            document.getElementById('poslist').required = true;
        } else {
            document.getElementById('posField').style.display = "none";
            document.getElementById('poslist').required = false;
        }
    }
</script>
<?php
include($ROOTPATH . '/internal/footer.php');
?>