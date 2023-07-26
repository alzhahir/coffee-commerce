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
            <div class="dropdown flex-column d-flex text-end" id="notifdrp">
                <button class="border-0 btn-lg align-middle navbar-toggler p-2 position-relative" type="button" id="dropdownNotifButton" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
                    <span class="position-absolute translate-middle rounded-circle bg-warning text-dark align-middle" id="notifBadge" style="top:35%;left:65%;padding:0.35rem!important;display:none;">
                        <span class="visually-hidden">unread messages</span>
                    </span>
                    <span class="align-middle material-symbols-outlined" id="notifIconLabel" style="font-size:32px;">notifications</span>
                </button>
                <div class="overflow-hidden rounded-5 p-3 dropdown-menu shadow avdrpd" aria-labelledby="dropdownNotifButton" id="drpnotif" style="width:50vw;">
                    <div class="container px-3 py-2">
                        <h4 class="fw-black">NOTIFICATIONS</h4>
                        <?php
                        if(isset($_SESSION['uid'])){
                            ?>
                            <div id="notifContent" class='overflow-y-auto' style="max-height:512px!important;">
                                No unread notifications.
                            </div>
                            <?php
                        } else {
                            ?>
                            <div id="notifContent" class='overflow-y-auto' style="max-height:512px!important;">
                                You must be logged in to receive notifications.
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="dropdown flex-column d-flex text-end" id="cartdrp">
                <?php
                $itemNum = 0;
                $custId = "";
                if(isset($_SESSION['cust_id'])){
                    $outputCartArr = null;
                    $custId = $_SESSION['cust_id'];
                    $PROJECTROOT = $_SERVER["DOCUMENT_ROOT"] . '/..';
                    $included = true;
                    include($PROJECTROOT . '/public/api/user/get/cart.php');
                    $included = false;
                    if(isset($outputCartArr)){
                        if(isset($outputCartArr[0][2])){
                            $itemNum = sizeof($outputCartArr[0][2]);
                        }
                    }
                }
                if($itemNum > 0){
                ?>
                <button class="border-0 btn-lg align-middle navbar-toggler p-2 position-relative" type="button" id="dropdownCartButton" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
                    <span class="position-absolute translate-middle badge rounded-pill bg-light text-dark align-middle" style="top:25%;left:75%;">
                        <span class="text-center align-middle my-auto"><?php echo $itemNum ?></span>
                        <span class="visually-hidden">unread messages</span>
                    </span>
                    <span class="align-middle material-symbols-outlined" id="cartIconLabel" style="font-size:32px;">shopping_cart</span>
                </button>
                <?php
                } else {
                    ?>
                    <button class="border-0 btn-lg align-middle navbar-toggler p-2" type="button" id="dropdownCartButton" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
                        <span class="align-middle material-symbols-outlined" id="cartIconLabel" style="font-size:32px;">shopping_cart</span>
                    </button>
                    <?php
                }
                ?>
                <div class="overflow-hidden rounded-5 p-3 dropdown-menu shadow avdrpd" aria-labelledby="dropdownCartButton" id="drpcart" style="width:50vw;">
                    <div class="container px-3 py-2">
                        <h4 class="fw-black">YOUR (MINI) CART</h4>
                        <?php 
                            if(isset($_SESSION['cust_id'])){
                                include "minicart.php";
                            } else {
                                ?>
                                <p class="fw-medium mb-0">Your Cart is only available for registed users! Login now to use the cart!</p>
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
                        <h4 class="fw-black">
                            SIGN IN
                            <a class="btn btn-primary ahvbutton float-end" href="/password/request.php">RESET PASSWORD</a>
                        </h4>
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
                <li><a href="/about.php" class="nav-link px-3">About</a></li>
                <li><a href="/faq.php" class="nav-link px-3">FAQs</a></li>
                <li><a href="/contact.php" class="nav-link px-3">Contact</a></li>
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

<!-- MODAL FOR PRODUCT CUSTOMIZATIONS -->
<div class="modal fade" id="productCartModal" tabindex="-1" aria-labelledby="editProduct" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fw-black">CUSTOMIZE</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="col pb-3">
                    <p>Customize your order.</p>
                    <form id="prodCartForm" method="post">
                        <div class="form-floating mb-3" hidden>
                            <input id="prodId" class="form-control" name="value" type="text" placeholder="Product ID" required/>
                            <label for="value">Product ID</label>
                        </div>
                        <!--div class="form-floating mb-3">
                            <input id="cartQty" class="form-control" name="quantity" type="text" placeholder="Quantity" required/>
                            <label for="quantity">Quantity</label>
                        </div-->
                        <div class="mb-3">
                            <label class="form-label d-block">Temperature</label>
                            <div class="form-check form-check-inline">
                                <input id="hotProd" class="form-check-input" type="radio" name="temperature" value='1' required/>
                                <label class="form-check-label" for="hotProd">Hot</label>
                            </div>
                            <div class="form-check form-check-inline align-middle">
                                <input id="coldProd" class="form-check-input" type="radio" name="temperature" value='2'/>
                                <label class="form-check-label align-middle" for="coldProd">
                                    <span class="mb-0 pb-0">Cold</span>
                                    <span class="badge rounded-pill bg-danger align-middle">
                                        +RM 1.00
                                        <span class="visually-hidden">Admin Mode</span>
                                    </span>
                                </label>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary border-0 rounded-pill" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-primary ahvbutton" form="prodCartForm" id="postCart" type="submit">Add to cart</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function getRegToken(userAction){
        console.log('Requesting permission...');
        Notification.requestPermission().then((permission) => {
            if (permission === 'granted') {
                console.log('Notification permission granted.');
                if(userAction){
                    notifContent.innerHTML = ""
                    location.reload();
                }
            } else {
                notifContent.innerHTML = "Notification permission was not granted. Please grant the permission to receive notification. <button type='button' class='btn btn-primary ahvbutton' id='getNotifPerm'>Ask for permission</>"
            }
        })
    }

    const firebaseConfig = {
        apiKey: "AIzaSyBYu-HeucZacAKoAJHgwAzNYYjSKhhxZYw",
        authDomain: "mdvpnzone.firebaseapp.com",
        projectId: "mdvpnzone",
        storageBucket: "mdvpnzone.appspot.com",
        messagingSenderId: "429146314022",
        appId: "1:429146314022:web:030e8efdfaaf8caa285de7",
        measurementId: "G-ZQSPFKPBLL"
    };

    firebase.initializeApp(firebaseConfig);

    const messaging = firebase.messaging();
    messaging.getToken({vapidKey: 'BDNYjgph3oScPyWzOmYVug-x3Nkon-9OKp4bd9Us6cc6SW0uAdDn-U2CSWxiniSlMvBiAexRPXOzKc5mlfew2cU'})
    .then((currentToken) => {
    if (currentToken) {
        // Send the token to your server and update the UI if necessary
        // ...
        $.ajax('/api/notification/post/token.php', {
            type: 'POST',
            data: {
                registrationToken: currentToken,
                topic: '<?php echo 'cust'.$custId ?>'
            },
            success: function(res){
                //console.log('success', res)
            },
            error: function(){
                console.log('error', res)
            }
        })
    } else {
        // Show permission request UI
        console.log('No registration token available. Request permission to generate one.');
        getRegToken(false);
    }
    }).catch((err) => {
        console.log('An error occurred while retrieving token. ', err);
        notifContent.innerHTML = "Notification permission is not granted. Please grant the permission to receive notification. <button type='button' class='btn btn-primary ahvbutton' id='getNotifPerm'>Ask for permission</>"

    // ...
    });

    messaging.onMessage((payload) => {
        console.log('Message received. ', payload);
        // ...
        const toastElList = document.querySelectorAll('#toastNewNotif')
        const toastList = [...toastElList].map(toastEl => new bootstrap.Toast(toastEl, {autohide:true, animation:true, delay:5000}))
        toastList.forEach(toast => toast.show());
        if($('#notifBadge').is(':hidden')){
            $('#notifBadge').show();
        }
        $('#notifContent').append("<div id='notif"+payload.data.id+"' class='my-2 border border-1 mx-auto py-3 rounded-4 position-relative'><input onclick='closeNotif(this.dataset.value)' data-value="+payload.data.id+" type=\"button\" class=\"my-2 mx-2 btn-notif-close position-absolute top-0 end-0 btn-close\" aria-label=\"Close\"></input><div class='row me-2 my-2 ms-1' onclick='window.location=\""+payload.data.redirect+"\";'><img width='64px' height='64px' src="+payload.notification.image+" class='col col-auto'></img><div class='col'><span class='row fs-4 fw-bold'>"+payload.notification.title+"</span><span class='row'>"+payload.notification.body+"</span></div></div></div>");
    });

    function getNotifications(){
        $.ajax('/api/notification/get/messages.php?read=0&topic=<?php echo 'cust'.$custId ?>', {
            type: 'GET',
            success: function(res){
                if(res.data.length > 0){
                    if($('#notifBadge').is(':hidden')){
                        $('#notifBadge').show();
                    }
                    $('#notifContent').empty();
                    //console.log('success', res)
                    for (let i = 0; i < res.data.length; i++) {
                        element = res.data[i];
                        $('#notifContent').append("<div id='notif"+element[0]+"' class='my-2 border border-1 mx-auto py-3 rounded-4 position-relative'><input onclick='closeNotif(this.dataset.value)' data-value="+element[0]+" type=\"button\" class=\"my-2 mx-2 btn-notif-close position-absolute top-0 end-0 btn-close\" aria-label=\"Close\"></input><div class='row me-2 my-2 ms-1' onclick='window.location=\""+element[4]+"\";'><img width='64px' height='64px' src="+element[3]+" class='col col-auto'></img><div class='col'><span class='row fs-4 fw-bold'>"+element[1]+"</span><span class='row'>"+element[2]+"</span></div></div></div>");
                    }
                }
            },
            error: function(){
                console.log('error', res)
            }
        })
    }

    //onload window jquery
    $(window).on('load', function(){
        if($('#notifContent').is(':empty')){
            $('#notifContent').prepend('All notifications dismissed.')
        }

        getNotifications();

        setInterval(getNotifications(), 10000);

        $('#getNotifPerm').on('click', function(){
            getRegToken(true);
        })

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
