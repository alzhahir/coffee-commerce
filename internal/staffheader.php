<?php

//header content

?>
<style>
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
#navbarmain .active {
    color:            #FFFFFF;
    background-color: #002147!important;
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
                        if($_SESSION["utype"] == "admin"){
                            $url = "staff";
                        }
                        $shortName = strtok($_SESSION["name"], " ");
                        ?>
                        <a class="col btn ahvnavbut" href="/<?php echo $url ?>/index.php">Home</a>
                        <?php
                    } else {
                        ?>
                        <a class="col btn ahvnavbut" href="/staff/index.php">Home</a>
                        <?php
                    }
                ?>
                <a class="col btn ahvnavbut" href="/staff/products/index.php">Products</a>
                <a class="col btn ahvnavbut" href="/staff/orders/index.php">Orders</a>
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
                        <div id="notifContent" class='overflow-y-auto' style="max-height:512px!important;">
                            No unread notifications.
                        </div>
                    </div>
                </div>
            </div>
            <div class="dropdown flex-column d-flex text-end" id="logindrp">
                <button class="border-0 btn-lg align-middle navbar-toggler p-2" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
                    <span class="align-middle material-symbols-outlined" id="menuIconLabel" style="font-size:32px;">account_circle</span>
                    <?php
                        if($_SESSION['utype'] == 'admin'){
                            ?>
                                <span class="badge rounded-pill bg-secondary">
                                    ADMIN
                                    <span class="visually-hidden">Admin Mode</span>
                                </span>
                            <?php
                        }
                    ?>
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
                    <div class="container px-3 py-2">
                        <div class="row">
                            <label class="col px-2 fw-black fs-5 my-auto">WELCOME, <a class="text-decoration-none" href="/<?php echo $url; ?>/index.php"><?php echo strtoupper($shortName); ?></a>!</label>
                            <button type="button" class="col col-auto btn btn-danger ahvbutton" onclick="location.href='/api/auth/signout.php';">Logout</button>
                        </div>
                        <?php
                            if($_SESSION['utype'] == 'admin'){
                                ?>
                                <hr>
                                <div class="row">
                                    <span class="col col-lg-auto px-2">You are an administrator.</span>
                                </div>
                                <div class="row">
                                    <span class="col pe-auto px-2 my-auto">You can switch to Admin dashboard.</span>
                                    <button type="button" class="col col-auto border-0 btn" onclick="location.href='/admin/index.php';">
                                        <span class="align-middle material-symbols-outlined" style="font-size:24px;">switch_account</span>
                                        SWITCH
                                    </button>
                                </div>
                                <?php
                            }
                        ?>
                    </div>
                    <?php
                        }
                    ?>
                </div>
            </div>
        </div>
        <div class="collapse navbar-collapse p-0" id="navbarmain">
            <ul class="nav navbar-nav col-12 col-md-auto mb-2 justify-content-center mb-md-0 my-2">
                <?php
                    if(isset($_SESSION["uid"])){
                        $url = $_SESSION["utype"];
                        if($_SESSION["utype"] == "admin"){
                            $url = "staff";
                        }
                        $shortName = strtok($_SESSION["name"], " ");
                        ?>
                        <li><a href="/<?php echo $url ?>/index.php" class="nav-link px-3">Home</a></li>
                        <?php
                    } else {
                        ?>
                        <li><a href="/staff/index.php" class="nav-link px-3">Home</a></li>
                        <?php
                    }

                    if(isset($_SESSION["uid"])){
                        echo '<li><a href="/api/auth/signout.php" class="nav-link px-3">Logout</a></li>';
                    } else {
                        echo '<li><a href="/signup.php" class="nav-link px-3">Sign Up</a></li>';
                    }
                ?>
                <li><a href="/staff/products/index.php" class="nav-link px-3">Products</a></li>
                <li><a href="/staff/orders/index.php" class="nav-link px-3">Orders</a></li>
            </ul>
        </div>
    </header>
</div>

<script type="text/javascript">
    function getRegToken(){
        console.log('Requesting permission...');
        Notification.requestPermission().then((permission) => {
            if (permission === 'granted') {
            console.log('Notification permission granted.');
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
                topic: '<?php echo $_SESSION['utype'] ?>'
            },
            success: function(res){
                console.log('success', res)
            },
            error: function(){
                console.log('error', res)
            }
        })
    } else {
        // Show permission request UI
        console.log('No registration token available. Request permission to generate one.');
        getRegToken();
    }
    }).catch((err) => {
        console.log('An error occurred while retrieving token. ', err);
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
        //
        $.ajax('/api/notification/get/messages.php?read=0&topic=<?php echo $_SESSION['utype'] ?>', {
            type: 'GET',
            success: function(res){
                if(res.data.length > 0){
                    if($('#notifBadge').is(':hidden')){
                        $('#notifBadge').show();
                    }
                    $('#notifContent').empty();
                    console.log('success', res)
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
