<?php
$SERVERROOT = $_SERVER["DOCUMENT_ROOT"];
$PROJECTROOT = $_SERVER["DOCUMENT_ROOT"] . '/..';
session_start();
include($PROJECTROOT . '/internal/htmlhead.php');
include($PROJECTROOT . '/internal/header.php');
?>
<div class="px-3 py-3">
    <div class="py-2 px-2">
        <div id="carouselExampleRide" class="overflow-hidden rounded-5 carousel slide" data-bs-ride="true">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class='d-block w-100' role="img" aria-label="Placeholder: First slide" preserveAspectRatio="xMidYMid slice" focusable="false">
                        <img class="img-fluid" height="400" src="https://app.alzhahir.com/static/images/ahvelo/gallery/01.png">
                    </div>
                </div>
                <div class="carousel-item">
                    <div class='d-block w-100' role="img" aria-label="Placeholder: First slide" preserveAspectRatio="xMidYMid slice" focusable="false">
                        <img class="img-fluid" height="400" src="https://app.alzhahir.com/static/images/ahvelo/gallery/02.png">
                    </div>
                </div>
                <div class="carousel-item">
                    <div class='d-block w-100' role="img" aria-label="Placeholder: First slide" preserveAspectRatio="xMidYMid slice" focusable="false">
                        <img class="img-fluid" height="400" src="https://app.alzhahir.com/static/images/ahvelo/gallery/03.png">
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleRide" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleRide" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
    <div id="prodlist" class="container-fluid h2 px-2 d-flex flex-wrap justify-content-md-between" style="position:relative; overflow:overflow;">
        <div class="w-100 fw-black row p-2" style="z-index:1;">BESTSELLERS</div>
        <div id="prodcat" class="row user-select-none flex-row flex-nowrap" style="overflow-x:scroll; white-space: nowrap; float: none; position:relative; touch-action:auto;">
            <?php
                include($PROJECTROOT . "/internal/productgalleryobject.php");
            ?>
        </div>
        <div class="pe-none user-select-none h-100 catgradb overflow-visible" style="bottom:-5%;left:-5px;position:absolute;display:none;">
            <button id="leftbutton" class="pe-auto btn btn-primary rounded-circle align-items-center justify-content-center p-0 ahvbutton border-0 shadow" style="height:48px;width:48px;">
                <span class="material-symbols-outlined text-center align-middle mb-0" style="color:white; font-size:32px;">
                    navigate_before
                </span>
            </button>
            <svg class="bd-placeholder-img bd-placeholder-img-lg" width="25" height="350" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: First slide" preserveAspectRatio="xMidYMid slice" focusable="false">
                <!--title>Placeholder</title-->
                <!--rect class="catgrad" width="100%" height="100%" fill="#000000"></rect-->
                <!--text x="50%" y="50%" fill="#FFFFFF" dy=".3em">First slide</text-->
            </svg>
        </div>
        <div class="pe-none user-select-none h-100 catgrad overflow-visible" style="bottom:-5%;right:-5px;position:absolute;display:none;">
            <svg class="bd-placeholder-img bd-placeholder-img-lg" width="25" height="350" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: First slide" preserveAspectRatio="xMidYMid slice" focusable="false">
                <!--title>Placeholder</title-->
                <!--rect class="catgrad" width="100%" height="100%" fill="#000000"></rect-->
                <!--text x="50%" y="50%" fill="#FFFFFF" dy=".3em">First slide</text-->
            </svg>
            <button id="rightbutton" class="pe-auto btn btn-primary rounded-circle align-items-center justify-content-center p-0 ahvbutton border-0 shadow" style="height:48px;width:48px;">
                <span class="material-symbols-outlined text-center align-middle mb-0" style="color:white; font-size:32px;">
                    navigate_next
                </span>
            </button>
        </div>
    </div>
    <div id="catlist" class="pt-3 container-fluid h2 px-2 d-flex flex-wrap justify-content-md-between" style="position:relative; overflow:overflow;">
        <div class="w-100 fw-black row p-2" style="z-index:1;">CATEGORIES</div>
        <div id="catcat" class="row user-select-none flex-row flex-nowrap" style="overflow-x:scroll; white-space: nowrap; float: none; position:relative; touch-action:auto;">
            <?php
                include($PROJECTROOT . "/internal/categorygalleryobject.php");
            ?>
        </div>
        <div class="pe-none user-select-none h-100 catgradb2 overflow-visible" style="bottom:-5%;left:-5px;position:absolute;display:none;">
            <button id="cleftbutton" class="pe-auto btn btn-primary rounded-circle align-items-center justify-content-center p-0 ahvbutton border-0 shadow" style="height:48px;width:48px;">
                <span class="material-symbols-outlined text-center align-middle mb-0" style="color:white; font-size:32px;">
                    navigate_before
                </span>
            </button>
            <svg class="bd-placeholder-img bd-placeholder-img-lg" width="25" height="350" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: First slide" preserveAspectRatio="xMidYMid slice" focusable="false">
                <!--title>Placeholder</title-->
                <!--rect class="catgrad" width="100%" height="100%" fill="#000000"></rect-->
                <!--text x="50%" y="50%" fill="#FFFFFF" dy=".3em">First slide</text-->
            </svg>
        </div>
        <div class="pe-none user-select-none h-100 catgrad2 overflow-visible" style="bottom:-5%;right:-5px;position:absolute;display:none;">
            <svg class="bd-placeholder-img bd-placeholder-img-lg" width="25" height="350" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: First slide" preserveAspectRatio="xMidYMid slice" focusable="false">
                <!--title>Placeholder</title-->
                <!--rect class="catgrad" width="100%" height="100%" fill="#000000"></rect-->
                <!--text x="50%" y="50%" fill="#FFFFFF" dy=".3em">First slide</text-->
            </svg>
            <button id="crightbutton" class="pe-auto btn btn-primary rounded-circle align-items-center justify-content-center p-0 ahvbutton border-0 shadow" style="height:48px;width:48px;">
                <span class="material-symbols-outlined text-center align-middle mb-0" style="color:white; font-size:32px;">
                    navigate_next
                </span>
            </button>
        </div>
    </div>
</div>

<script>
    $(window).on('resize', function(){
        if($('#prodcat')[0].clientWidth < $('#prodcat')[0].scrollWidth){
            $('.catgrad').fadeIn(100);
        } else {
            $('.catgrad').fadeOut(100);
        }
        if($('#catcat')[0].clientWidth < $('#catcat')[0].scrollWidth){
            $('.catgrad2').fadeIn(100);
        } else {
            $('.catgrad2').fadeOut(100);
        }
    });
    $(window).on("load", function(){
        if($('#prodcat')[0].clientWidth < $('#prodcat')[0].scrollWidth){
            $('.catgrad').fadeIn(100);
        }
        if($('#catcat')[0].clientWidth < $('#catcat')[0].scrollWidth){
            $('.catgrad2').fadeIn(100);
        }
    });
    $.fn.hasVerticalScrollBar = function () {
        return this[0].clientHeight < this[0].scrollHeight;
    }

    $.fn.hasHorizontalScrollBar = function () {
        return this[0].clientWidth < this[0].scrollWidth;
    }
    //padding-right:100px;
    $('#prodcat').scroll(function(){
        if($('#prodcat').scrollLeft() <= 0){
            $('.catgradb').fadeOut(100);
        }
        if($('#prodcat').scrollLeft() > 0){
            $('.catgradb').fadeIn(100);
        }
        if($('#prodcat').scrollLeft() >= $('#prodcat')[0].scrollWidth - $('#prodcat')[0].clientWidth - 5){
            $('.catgrad').fadeOut(100);
        }
        if($('#prodcat').scrollLeft() < $('#prodcat')[0].scrollWidth - $('#prodcat')[0].clientWidth - 5){
            $('.catgrad').fadeIn(100);
        }
    })

    //padding-right:100px;
    $('#catcat').scroll(function(){
        if($('#catcat').scrollLeft() <= 0){
            $('.catgradb2').fadeOut(100);
        }
        if($('#catcat').scrollLeft() > 0){
            $('.catgradb2').fadeIn(100);
        }
        if($('#catcat').scrollLeft() >= $('#catcat')[0].scrollWidth - $('#catcat')[0].clientWidth - 5){
            $('.catgrad2').fadeOut(100);
        }
        if($('#catcat').scrollLeft() < $('#catcat')[0].scrollWidth - $('#catcat')[0].clientWidth - 5){
            $('.catgrad2').fadeIn(100);
        }
    })

    if($('#prodcat').hasHorizontalScrollBar()){
        $('#rightbutton').click(function() {
            event.preventDefault();
            $('#prodcat').animate({
                scrollLeft: "+=500px"
            }, "slow");
        });
        $('#leftbutton').click(function() {
            event.preventDefault();
            $('#prodcat').animate({
                scrollLeft: "-=500px"
            }, "slow");
        });
    };

    if($('#catcat').hasHorizontalScrollBar()){
        $('#crightbutton').click(function() {
            event.preventDefault();
            $('#catcat').animate({
                scrollLeft: "+=500px"
            }, "slow");
        });
        $('#cleftbutton').click(function() {
            event.preventDefault();
            $('#catcat').animate({
                scrollLeft: "-=500px"
            }, "slow");
        });
    };
</script>
<?php
include($PROJECTROOT . '/internal/footer.php');
?>