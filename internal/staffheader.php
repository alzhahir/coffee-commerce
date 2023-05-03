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
#form-floating,::before{
    pointer-events:none;
    background-color:transparent!important;
}
.avdrpd{
    min-width:50vw;
}
.avnav{
    display:inline;
}
.avside{
    display:none;
}
@media only screen and (max-width: 580px) {
    .avdrpd{
        min-width:100vw;
    }
}
@media only screen and (max-width: 824px) {
    .avnav{
        display:none!important;
    }
    .avside{
        display:block;
    }
}
.sgfd-parent{
    width:10px;
    height:70%;
    margin:0px;
}
.sgfd{
    opacity: 20%;
    background-color:black;
    width:1px;
    height:100%;
    margin: 5px 0px 5px 0px;
}
@media only screen and (max-width: 768px) {
    .sgfd-parent{
        width:100%;
        height:30px;
    }
   .sgfd{
        width:100%;
        height:1px;
        margin: 10px 0px 10px 0px;
    }
}

.ahvnavbut{
    color:white;
    background-color: #00326B!important;
    border-radius:30px;
    transition-duration: 0.1s;
    border:0px;
}
.ahvnavbut:hover{
    background-color: #002147!important;
}
.ahvnavbuthover{
    background-color: #002147!important;
}
.ahvnavbut:active{
    transition-duration: 0s;
    background-color: #0050AB!important;
}

.ahvbutton{
    color:white;
    background-color: #FA3F3F!important;
    border-radius:30px;
    transition-duration: 0.1s;
    border:0px;
}
.ahvbutton:hover{
    background-color: #D02A2A!important;
}
.ahvbutton:active{
    transition-duration: 0s;
    background-color: #FF6E6E!important;
}

.ahvpc{
    background-color: #D02A2A!important;
}

.ahvsc{
    background-color: #FA3F3F!important;
}

#prodcat::-webkit-scrollbar {
  display: none;
}

#prodcat {
  -ms-overflow-style: none;  /* IE and Edge */
  scrollbar-width: none;  /* Firefox */
}

.carousel-inner > .item > img {
  width: 100%;
}

.catgrad {
    background: rgb(255,255,255);
    background: linear-gradient(270deg, rgba(255,255,255,1) 0%, rgba(255,255,255,0) 100%);
}
.catgradb {
    background: rgb(255,255,255);
    background: linear-gradient(90deg, rgba(255,255,255,1) 0%, rgba(255,255,255,0) 100%);
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
    background-color: #002147!important;
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

<div class="shadow text-light<?php if(!($_SERVER["PHP_SELF"] == "/index.php" || $_SERVER["PHP_SELF"] == "/login.php")){echo " mb-4";} ?> container-fluid" style="background-color:#00326b;">
    <header class="row d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-2">
        <div class="container d-flex flex-row align-items-center justify-content-start col mb-md-0">
            <button class="pe-2 navbar-toggler avside" type="button" data-bs-toggle="collapse" data-bs-target="#navbarmain" style="width:48px; height:48px;">
                <span class="material-symbols-outlined" style="font-size:32px;">
                    menu
                </span>
            </button>
            <a href="/staff/" class="ps-1 ms-1 mb-0 flex-wrap align-items-center text-light text-decoration-none row">
                <!--svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use></svg-->
                <!--img src="https://saringc19.uitm.edu.my/statics/LogoUiTM.png" class="" height="50px" alt="UiTM Logo"-->
                <div class="m-0 p-0 h3 col mb-0 fw-black text-light text-decoration-none d-flex flex-wrap align-items-center">AHVELO&nbsp;</div>
                <div class="m-0 p-0 h3 col mb-0 fw-light text-light text-decoration-none d-flex flex-wrap align-items-center">STAFF</div>
            </a>
        </div>
        <div class="d-flex flex-row align-items-center justify-content-center col-sm-6 avnav">
            <div class="row navbarh">
                <?php
                    if(isset($_SESSION["uid"])){
                        $url = $_SESSION["utype"];
                        $shortName = strtok($_SESSION["name"], " ");
                        ?>
                        <a class="col btn ahvnavbut" href="/<?php echo $url ?>/index.php">Home</a>
                        <?php
                    } else {
                        ?>
                        <a class="col btn ahvnavbut" href="/staff/">Home</a>
                        <?php
                    }
                ?>
                <a class="col btn ahvnavbut" href="/staff/products/">Products</a>
                <a class="col btn ahvnavbut" href="/staff/orders/">Orders</a>
            </div>
        </div>
        <div class="col d-flex flex-row text-end justify-content-end">
            <div class="dropdown flex-column d-flex text-end" id="cartdrp">
                <button class="border-0 btn-lg align-middle navbar-toggler p-2" type="button" id="dropdownCartButton" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
                    <span class="align-middle material-symbols-outlined" style="font-size:32px;">shopping_cart</span>
                </button>
                <div class="overflow-hidden rounded-5 p-3 dropdown-menu shadow avdrpd" aria-labelledby="dropdownCartButton" id="drpcart" style="width:50vw;">
                    <div class="container px-3 py-2">
                        <h4 class="fw-black">YOUR CART</h4>
                        <?php include "notimp.php" ?>
                    </div>
                </div>
            </div>
            <div class="dropdown flex-column d-flex text-end" id="logindrp">
                <button class="border-0 btn-lg align-middle navbar-toggler p-2" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
                    <span class="align-middle material-symbols-outlined" style="font-size:32px;">account_circle</span>
                </button>
                <div class="overflow-hidden rounded-5 p-3 dropdown-menu shadow avdrpd" aria-labelledby="dropdownMenuButton" id="drpmenu">
                    <?php
                        if(!isset($_SESSION["uid"])){
                    ?>
                    <div class="container px-3 py-2">
                        <h4 class="fw-black">SIGN IN</h4>
                        <?php 
                            $_SESSION["backPage"] = $_SERVER["PHP_SELF"];
                            //check if $_GET isset
                            if(isset($_GET["autherror"])){
                                //error exists
                                echo "<div class=\"alert alert-danger\">";
                                if(isset($_SESSION["userErrMsg"])){
                                    //get err msg
                                    $errMsg = $_SESSION["userErrMsg"];
                                    $errCode = $_SESSION["userErrCode"];
                                    echo "<p class=\"my-0 fw-semibold\"style=\"text-align: justify; text-justify: inter-word;\">$errMsg</p>";
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
                        <p>Please enter the email and password to continue.</p>
                        <form id="drpLoginForm" action="/api/auth/login.php?errorType=autherror" method="post">
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
                        <button class="btn btn-primary ahvbutton" form="drpLoginForm" id="drpSignInButton" type="submit">Sign In</button>
                    </div>
                    <div class="dropdown-divider"></div>
                    <div class="container px-3 py-2">
                        Don't have any account? <a href="/signup.php">Sign up</a> now!
                    </div>
                    <?php
                        } else {
                            $url = $_SESSION["utype"];
                            $shortName = strtok($_SESSION["name"], " ");
                    ?>
                    <div class="container px-3 py-2">
                        <label class="px-2">Welcome, <a class="text-decoration-none" href="/<?php echo $url ?>/index.php"><?php echo $shortName ?></a>!</label>
                        <button type="button" class="btn btn-danger" onclick="location.href='/api/auth/signout.php';">Logout</button>
                    </div>
                    <?php
                        }
                    ?>
                </div>
            </div>
        </div>
        <div class="collapse navbar-collapse p-0" id="navbarmain">
            <ul class="nav navbar-nav col-12 col-md-auto mb-2 justify-content-center mb-md-0 my-2">
                <li><a href="/staff/" class="nav-link px-3">Home</a></li>
                <?php
                    if(isset($_SESSION["uid"])){
                        echo '<li><a href="/api/auth/signout.php" class="nav-link px-3">Logout</a></li>';
                    } else {
                        echo '<li><a href="/signup.php" class="nav-link px-3">Sign Up</a></li>';
                    }
                ?>
                <li><a href="/staff/products/" class="nav-link px-3">Products</a></li>
                <li><a href="/staff/orders/" class="nav-link px-3">Orders</a></li>
            </ul>
        </div>
    </header>
</div>

<script type="text/javascript">
    //onload window jquery
    $(window).on('load', function(){
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        if(urlParams.has('autherror')){
            if ($('#logindrp').find('#drpmenu').is(":hidden")){
                $('#dropdownMenuButton').dropdown('toggle');
            }
        }
        var current = window.location.pathname;
        if(current != '/'){
            $('.ahvnavbut').each(function(){
                var $this = $(this);
                // if the current path is like this link, make it active
                if($this.attr('href').indexOf(current) !== -1){
                    $this.addClass('ahvnavbuthover');
                }
            })
        } else {
            $('#home').addClass('ahvnavbuthover')
        }
        <?php
            if(isset($_GET["modalerror"])){
                //error exists
                echo "$('#loginModal').modal('show');";
            }
        ?>
    })

    $('#dropdownMenuButton').click(function() {
        if ($('.avdrpd').is(":visible") && screen.width < 580){
            $('body').css('overflow', 'hidden');
        } else {
            $('body').css('overflow', 'auto');
        }
    });

    $('#dropdownCartButton').click(function() {
        if ($('.avdrpd').is(":visible") && screen.width < 580){
            $('body').css('overflow', 'hidden');
        } else {
            $('body').css('overflow', 'auto');
        }
    });

    $('.navbar-toggler').on('hidden.bs.dropdown', function() {
        if ($('.avdrpd').is(":hidden")){
            $('body').css('overflow', 'auto');
        } else {
            $('body').css('overflow', 'hidden');
        }
    });

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
        let url = new URL(window.location.href);
        url.searchParams.delete('error');
        url.searchParams.delete('signup');
        url.searchParams.delete('autherror');
        window.history.pushState({}, document.title, url);
    });
</script>
