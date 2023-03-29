<?php

//header content

?>

<div class="px-5 shadow bg-white <?php if(!($_SERVER["PHP_SELF"] == "/index.php" || $_SERVER["PHP_SELF"] == "/login.php")){echo "mb-5";} ?>">
    <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3">
        <a href="/" class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">
            <!--svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use></svg-->
            <img src="https://saringc19.uitm.edu.my/statics/LogoUiTM.png" class="" height="50px" alt="UiTM Logo">
            <p class="h6 ps-3">Ahvelo Coffee</p>
        </a>

        <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
            <li><a href="/" class="nav-link px-2 link-secondary">Home</a></li>
            <li><a href="/clubs/index.php" class="nav-link px-2 link-dark">Shop</a></li>
            <?php
            /*
                if(isset($_SESSION["uid"])){
                    echo '<li><a href="/doSignOut.php" class="nav-link px-2 link-dark">Logout</a></li>';
                } else {
                    echo '<li><a href="/login.php" class="nav-link px-2 link-dark">Login</a></li>';
                }
            */
            ?>
            <li><a href="/contact.php" class="nav-link px-2 link-dark">Contact</a></li>
            <li><a href="/faq.php" class="nav-link px-2 link-dark">FAQs</a></li>
            <li><a href="/about.php" class="nav-link px-2 link-dark">About</a></li>
        </ul>

        <div class="col-md-3 text-end">
            <?php
                if(isset($_SESSION["uid"])){
                    $url = $_SESSION["utype"];
                    $shortName = strtok($_SESSION["name"], " ");
                    echo "<label class=\"px-2\">Welcome, <a class=\"text-decoration-none\" href=/".$url."/>".$shortName."</a>!</label>";
                    echo '<button type="button" class="btn btn-danger" onclick="location.href=\'/doSignOut.php\';">Logout</button>';
                } else {
                    echo '<button type="button" class="btn btn-primary mx-1" data-bs-toggle="modal" data-bs-target="#loginModal">Sign In</button>';
                    echo '<button type="button" class="btn btn-primary mx-1" onclick="location.href=\'/login.php\'">Sign Up</button>';
                }
            ?>
        </div>
    </header>
</div>
