<?php

//header content

?>
<style>
.ahvnavbut{
    color:white;
    background-color: #D02A2A!important;
    border-radius:30px;
    transition-duration: 0.1s;
    border:0px;
}
.ahvnavbut:hover{
    background-color: #FA3F3F!important;
}
.ahvnavbuthover{
    background-color: #FA3F3F!important;
}
.ahvnavbut:active{
    transition-duration: 0s;
    background-color: #FF6E6E!important;
}
#navbarmain .active {
    color:            #FFFFFF;
    background-color: #FA3F3F!important;
}
</style>

<div class="shadow text-light<?php if(!($_SERVER["PHP_SELF"] == "/index.php" || $_SERVER["PHP_SELF"] == "/login.php")){echo " mb-4";} ?> container-fluid" style="background-color:#D02A2A;">
    <header class="row d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-2">
        <div class="d-flex flex-row align-items-center justify-content-start col mb-md-0">
            <button class="pe-2 navbar-toggler avside" type="button" data-bs-toggle="collapse" data-bs-target="#navbarmain" style="width:48px; height:48px;">
                <span class="material-symbols-outlined" style="font-size:32px;">
                    menu
                </span>
            </button>
            <a href="/" class="mb-0 flex-wrap align-items-center text-light text-decoration-none">
                <!--svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use></svg-->
                <!--img src="https://saringc19.uitm.edu.my/statics/LogoUiTM.png" class="" height="50px" alt="UiTM Logo"-->
                <p class="h3 col mb-0 fw-black text-light text-decoration-none d-flex flex-wrap align-items-center">AHVELO</p>
            </a>
        </div>
        <div class="d-flex flex-row align-items-center justify-content-center col-sm-6 avnav">
            <div class="row navbarh">
                <a class="col btn ahvnavbut" id="home" href="/">Home</a>
                <a class="col btn ahvnavbut" href="/shop.php">Shop</a>
                <?php
                    if(isset($_SESSION["uid"])){
                        $url = $_SESSION["utype"];
                        $shortName = strtok($_SESSION["name"], " ");
                        ?>
                        <a class="col btn ahvnavbut" href="/<?php echo $url ?>/index.php">Account</a>
                        <?php
                    } else {
                        ?>
                        <a class="col btn ahvnavbut" href="/signup.php">Account</a>
                        <?php
                    }
                ?>
                <a class="col btn ahvnavbut" href="/about.php">About</a>
                <a class="col btn ahvnavbut" href="/faq.php">FAQs</a>
                <a class="col btn ahvnavbut" href="/contact.php">Contact</a>
            </div>
        </div>
        <div class="col d-flex flex-row text-end justify-content-end">
            <div class="dropdown flex-column d-flex text-end" id="cartdrp">
                <button class="border-0 btn-lg align-middle navbar-toggler p-2" type="button" id="dropdownCartButton" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
                    <span class="align-middle material-symbols-outlined" id="cartIconLabel" style="font-size:32px;">shopping_cart</span>
                </button>
                <div class="overflow-hidden rounded-5 p-3 dropdown-menu shadow avdrpd" aria-labelledby="dropdownCartButton" id="drpcart" style="width:50vw;">
                    <div class="container px-3 py-2">
                        <h4 class="fw-black">YOUR (MINI) CART</h4>
                        <?php 
                            if(isset($_SESSION['cust_id'])){
                                include "minicart.php";
                            } else {
                                ?>
                                <p class="fw-medium">Your Cart is only available for registed users! Login now to use the cart!</p>
                                <?php
                            }
                        ?>
                    </div>
                </div>
            </div>
            <div class="dropdown flex-column d-flex text-end" id="logindrp">
                <button class="border-0 btn-lg align-middle navbar-toggler p-2" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
                    <span class="align-middle material-symbols-outlined" id="menuIconLabel" style="font-size:32px;">account_circle</span>
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
                        Don't have an account? <a href="/signup.php">Sign up</a> now!
                    </div>
                    <?php
                        } else {
                            $url = $_SESSION["utype"];
                            $shortName = strtok($_SESSION["name"], " ");
                    ?>
                    <div class="containter px-3 py-2">
                        <div class="row">
                            <label class="col fw-black fs-5 px-2 my-auto">WELCOME, <a class="text-decoration-none" href="/<?php echo $url; ?>/index.php"><?php echo strtoupper($shortName); ?></a>!</label>
                            <button type="button" class="col col-auto btn btn-danger ahvbutton" onclick="location.href='/api/auth/signout.php';">Logout</button>
                        </div>
                    </div>
                    <?php
                        }
                    ?>
                </div>
            </div>
        </div>
        <div class="collapse navbar-collapse p-0" id="navbarmain">
            <ul class="nav navbar-nav col-12 col-md-auto mb-2 justify-content-center mb-md-0 my-2">
                <li><a href="/" class="nav-link px-3">Home</a></li>
                <li><a href="/shop.php" class="nav-link px-3">Shop</a></li>
                <?php
                    if(isset($_SESSION["uid"])){
                        echo '<li><a href="/api/auth/signout.php" class="nav-link px-3">Logout</a></li>';
                    } else {
                        echo '<li><a href="/signup.php" class="nav-link px-3">Sign Up</a></li>';
                    }
                ?>
                <li><a href="/contact.php" class="nav-link px-3">Contact</a></li>
                <li><a href="/faq.php" class="nav-link px-3">FAQs</a></li>
                <li><a href="/about.php" class="nav-link px-3">About</a></li>
            </ul>
        </div>
    </header>
</div>

<!-- Modal -->
<div class="modal fade" id="loginRequiredModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="loginRequiredLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-4 fw-black" id="loginRequiredLabel">LOGIN TO CONTINUE</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="fw-bold">To use this function, please login or create an account.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary ahvbutton" data-bs-dismiss="modal">Okay</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for confirm cart item del -->
<div class="modal fade" id="confirmCartDel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="confirmCDelLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-4 fw-black" id="confirmCDelLabel">REMOVE ITEM</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="fw-bold">Do you wish to remove this item from the cart?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger rounded-pill" data-bs-dismiss="modal">CANCEL</button>
                <button type="button" class="btn btn-danger ahvbutton" id="confirmCartDelBtn">CONFIRM</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal to check if cart is empty -->
<div class="modal fade" id="itemRequiredModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="itemRequiredLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-4 fw-black" id="itemRequiredLabel">EMPTY CART</h1>
                <button type="button" class="btn-close itmreqclose" <?php //data-bs-dismiss="modal" ?> aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="fw-bold">To proceed, add any item to Your Cart.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary ahvbutton itmreqclose" <?php //data-bs-dismiss="modal" ?> id="itemRequiredBtn">Okay</button>
            </div>
        </div>
    </div>
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
</script>
