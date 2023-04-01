<?php

//header content

?>

<script>
    $(function(){
        $('a').each(function(){
            if ($(this).prop('href') == window.location.href) {
                $(this).addClass('active'); $(this).parents('li').addClass('active');
            }
        });
    });
</script>

<style>
.ahvpc{
    background-color: #D02A2A!important;
}

.ahvsc{
    background-color: #FA3F3F!important;
}

.carousel-inner > .item > img {
  width: 100%;
}

.catgrad {
    background: rgb(255,255,255);
    background: linear-gradient(270deg, rgba(255,255,255,1) 0%, rgba(255,255,255,0) 100%);
}

@import url('https://fonts.googleapis.com/css2?family=League+Spartan:&display=swap');
body{
    font-family: 'League Spartan', sans-serif;
}

.fw-black {
    font-weight: 900;
}

#navbarmain .active {
    color:            #FFFFFF;
    background-color: #FA3F3F!important;
}

.material-symbols-outlined {
    -webkit-user-select: none; /* Safari */
    -ms-user-select: none; /* IE 10 and IE 11 */
    user-select: none; /* Standard syntax */
    font-variation-settings:
        'FILL' 0,
        'wght' 400,
        'GRAD' 0,
        'opsz' 48
}
</style>

<div class="shadow text-light<?php if(!($_SERVER["PHP_SELF"] == "/index.php" || $_SERVER["PHP_SELF"] == "/login.php")){echo " mb-5";} ?> container-fluid" style="background-color:#D02A2A;">
    <header class="row d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3">
        <div class="d-flex align-items-center col mb-md-0">
            <button class="pe-2 navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarmain" style="width:48px; height:48px;">
                <span class="material-symbols-outlined" style="font-size:32px;">
                    menu
                </span>
            </button>
            <a href="/" class="d-flex align-items-center col mb-md-0 text-light text-decoration-none">
                <!--svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use></svg-->
                <!--img src="https://saringc19.uitm.edu.my/statics/LogoUiTM.png" class="" height="50px" alt="UiTM Logo"-->
                <p class="h3 m-0 fw-black">AHVELO COFFEE</p>
            </a>
        </div>
        <div class="col d-flex flex-row text-end justify-content-end">
            <div class="dropdown flex-column d-flex text-end" id="cartdrp">
                <button class="border-0 btn-lg align-middle navbar-toggler" type="button" id="dropdownCartButton" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
                    <span class="align-middle material-symbols-outlined" style="font-size:32px;">shopping_cart</span>
                </button>
                <div class="overflow-hidden rounded-5 p-3 dropdown-menu shadow" aria-labelledby="dropdownCartButton" id="drpcart" style="width:50vw;">
                    <div class="container px-3 py-2">
                        <h3>Your Cart</h3>
                        <?php include "notimp.php" ?>
                    </div>
                </div>
            </div>
            <div class="dropdown flex-column d-flex text-end" id="logindrp">
                <?php
                    if(isset($_SESSION["uid"])){
                        $url = $_SESSION["utype"];
                        $shortName = strtok($_SESSION["name"], " ");
                        echo "<label class=\"px-2\">Welcome, <a class=\"text-decoration-none\" href=/".$url."/>".$shortName."</a>!</label>";
                        echo '<button type="button" class="btn btn-danger" onclick="location.href=\'/doSignOut.php\';">Logout</button>';
                    } else {
                        echo '<button class="border-0 btn-lg align-middle navbar-toggler" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false"><span class="align-middle material-symbols-outlined" style="font-size:32px;">account_circle</span></button>';
                        //echo '<button type="button" class="btn btn-primary mx-1" onclick="location.href=\'/login.php\'">Sign Up</button>';
                    }
                ?>
                <div class="overflow-hidden rounded-5 p-3 dropdown-menu shadow" aria-labelledby="dropdownMenuButton" id="drpmenu" style="min-width:50vw;">
                    <?php 
                        $_SESSION["backPage"] = $_SERVER["PHP_SELF"];
                        //check if $_GET isset
                        if(isset($_GET["error"])){
                            //error exists
                            echo "<div class=\"alert alert-danger my-4\" style=\"margin-left: 13%; margin-right: 13%;\">";
                            if(isset($_SESSION["userErrMsg"])){
                                //get err msg
                                $errMsg = $_SESSION["userErrMsg"];
                                $errCode = $_SESSION["userErrCode"];
                                echo "<h5 style=\"text-align: justify; text-justify: inter-word;\">$errMsg</h5>";
                                echo "<br><p>Error code: $errCode</p>";
                            }
                            echo "</div>";
                        }
                        if(isset($_GET["signup"])){
                            echo "<div class=\"alert alert-success my-4\" style=\"margin-left: 13%; margin-right: 13%;\">";
                            if(isset($_SESSION["userErrMsg"])){
                                //get err msg
                                $errMsg = $_SESSION["userErrMsg"];
                                $errCode = $_SESSION["userErrCode"];
                                echo "<h5 style=\"text-align: justify; text-justify: inter-word;\">$errMsg</h5>";
                            }
                            echo "</div>";
                        }
                    ?>
                    <div class="container px-3 py-2">
                        <h3>Sign In</h3>
                        <p>Please enter the email and password to continue.</p>
                        <style>
                            #form-floating,::before{
                                pointer-events:none;
                                background-color:transparent!important;
                            }
                        </style>
                        <form id="loginForm" action="/doSignIn.php" method="post">
                            <div class="form-floating mb-2">
                                <input class="form-control" name="signInEmail" type="email" placeholder="Email Address" required/>
                                <label for="emailAddress">Email Address</label>
                            </div>
                            <div class="form-floating mb-2">
                                <input class="form-control" name="signInPassword" type="password" placeholder="Password" required/>
                                <label for="password">Password</label>
                            </div>
                        </form>
                        <button type="button" class="btn btn-outline-danger border-0" id="closebtn">Close</button>
                        <button class="btn btn-primary" form="loginForm" id="signInButton" type="submit">Sign In</button>
                    </div>
                    <div class="dropdown-divider"></div>
                    <div class="container px-3 py-2">
                        Don't have any account? <a href="/signup.php">Sign up</a> now!
                    </div>
                </div>
            </div>
        </div>
        <div class="collapse navbar-collapse p-0" id="navbarmain">
            <ul class="nav navbar-nav col-12 col-md-auto mb-2 justify-content-center mb-md-0 my-2">
                <li><a href="/" class="nav-link px-3">Home</a></li>
                <li><a href="/shop.php" class="nav-link px-3">Shop</a></li>
                <?php
                /*
                    if(isset($_SESSION["uid"])){
                        echo '<li><a href="/doSignOut.php" class="nav-link px-2 link-dark">Logout</a></li>';
                    } else {
                        echo '<li><a href="/login.php" class="nav-link px-2 link-dark">Login</a></li>';
                    }
                */
                ?>
                <li><a href="/contact.php" class="nav-link px-3">Contact</a></li>
                <li><a href="/faq.php" class="nav-link px-3">FAQs</a></li>
                <li><a href="/about.php" class="nav-link px-3">About</a></li>
            </ul>
        </div>
    </header>
</div>

<!-- Auth Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-uitm">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Sign In</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php 
                    $_SESSION["backPage"] = $_SERVER["PHP_SELF"];
                    //check if $_GET isset
                    if(isset($_GET["error"])){
                        //error exists
                        echo "<div class=\"alert alert-danger my-4\" style=\"margin-left: 13%; margin-right: 13%;\">";
                        if(isset($_SESSION["userErrMsg"])){
                            //get err msg
                            $errMsg = $_SESSION["userErrMsg"];
                            $errCode = $_SESSION["userErrCode"];
                            echo "<h5 style=\"text-align: justify; text-justify: inter-word;\">$errMsg</h5>";
                            echo "<br><p>Error code: $errCode</p>";
                        }
                        echo "</div>";
                    }
                    if(isset($_GET["signup"])){
                        echo "<div class=\"alert alert-success my-4\" style=\"margin-left: 13%; margin-right: 13%;\">";
                        if(isset($_SESSION["userErrMsg"])){
                            //get err msg
                            $errMsg = $_SESSION["userErrMsg"];
                            $errCode = $_SESSION["userErrCode"];
                            echo "<h5 style=\"text-align: justify; text-justify: inter-word;\">$errMsg</h5>";
                        }
                        echo "</div>";
                    }
                ?>
                <div class="container px-5">
                    <h3>Sign In</h3>
                    <p>Please enter the email and password to continue.</p>
                    <form id="loginForm" action="/doSignIn.php" method="post">
                        <div class="form-floating mb-3">
                            <input class="form-control" name="signInEmail" type="email" placeholder="Email Address" required/>
                            <label for="emailAddress">Email Address</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" name="signInPassword" type="password" placeholder="Password" required/>
                            <label for="password">Password</label>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="background-color: white; color: #7700ff;">Close</button>
                <button class="btn btn-primary" form="loginForm" id="signInButton" type="submit">Sign In</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    //onload window jquery
    $(window).on('load', function(){
        <?php
            if(isset($_GET["error"])){
                //error exists
                echo "$('#loginModal').modal('show');";
            }
        ?>
    })
    $('#loginModal').on('hidden.bs.modal', function(){
        let url = new URL(window.location.href);
        url.searchParams.delete('error');
        url.searchParams.delete('signup');
        window.history.pushState({}, document.title, url);
    })

    $('#closebtn').click(function() {
        //$(this).parents('.dropdown').find('button.dropdown-toggle').dropdown('toggle');
        $("#drpmenu").dropdown("toggle");
        //$("#drpmenu").toggle();
    });
</script>
