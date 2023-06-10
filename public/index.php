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
                    <!--img src="..." class="d-block w-100" alt="..."-->
                    <div class='d-block w-100' role="img" aria-label="Placeholder: First slide" preserveAspectRatio="xMidYMid slice" focusable="false">
                        <img src="https://api.alzhahir.com/static/images/stulectro/gallery/01.png">
                    </div>
                    <!--svg class="bd-placeholder-img bd-placeholder-img-lg d-block w-100" width="800" height="400" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: First slide" preserveAspectRatio="xMidYMid slice" focusable="false">
                        <title>Placeholder</title>
                        <rect width="100%" height="100%" fill="#777"></rect>
                        <text x="50%" y="50%" fill="#555" dy=".3em">First slide</text>
                    </svg-->
                </div>
                <div class="carousel-item">
                    <!--img src="..." class="d-block w-100" alt="..."-->
                    <div class='d-block w-100' role="img" aria-label="Placeholder: First slide" preserveAspectRatio="xMidYMid slice" focusable="false">
                        <img src="https://api.alzhahir.com/static/images/stulectro/gallery/02.png">
                    </div>
                    <!--svg class="bd-placeholder-img bd-placeholder-img-lg d-block w-100" width="800" height="400" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: First slide" preserveAspectRatio="xMidYMid slice" focusable="false">
                        <title>Placeholder</title>
                        <rect width="100%" height="100%" fill="#777"></rect>
                        <text x="50%" y="50%" fill="#555" dy=".3em">Second slide</text>
                    </svg-->
                </div>
                <div class="carousel-item">
                    <!--img src="..." class="d-block w-100" alt="..."-->
                    <div class='d-block w-100' role="img" aria-label="Placeholder: First slide" preserveAspectRatio="xMidYMid slice" focusable="false">
                        <img src="https://api.alzhahir.com/static/images/stulectro/gallery/03.png">
                    </div>
                    <!--svg class="bd-placeholder-img bd-placeholder-img-lg d-block w-100" width="800" height="400" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: First slide" preserveAspectRatio="xMidYMid slice" focusable="false">
                        <title>Placeholder</title>
                        <rect width="100%" height="100%" fill="#777"></rect>
                        <text x="50%" y="50%" fill="#555" dy=".3em">Third slide</text>
                    </svg-->
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
        <div class="w-100 fw-black row p-2">BESTSELLERS</div>
        <div id="prodcat" class="row flex-row flex-nowrap" style="overflow-x:scroll; white-space: nowrap; float: none; position:relative; touch-action:pan-x;">
            <?php
                include($PROJECTROOT . "/internal/productgalleryobject.php");
            ?>
        </div>
        <div class="catgradb overflow-visible" style="bottom:-5%;left:-5px;position:absolute;display:none;">
            <button id="leftbutton" class="btn btn-primary rounded-circle align-items-center justify-content-center p-0 ahvbutton border-0 shadow" style="height:48px;width:48px;">
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
        <div class="catgrad overflow-visible" style="bottom:-5%;right:-5px;position:absolute;display:none;">
            <svg class="bd-placeholder-img bd-placeholder-img-lg" width="25" height="350" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: First slide" preserveAspectRatio="xMidYMid slice" focusable="false">
                <!--title>Placeholder</title-->
                <!--rect class="catgrad" width="100%" height="100%" fill="#000000"></rect-->
                <!--text x="50%" y="50%" fill="#FFFFFF" dy=".3em">First slide</text-->
            </svg>
            <button id="rightbutton" class="btn btn-primary rounded-circle align-items-center justify-content-center p-0 ahvbutton border-0 shadow" style="height:48px;width:48px;">
                <span class="material-symbols-outlined text-center align-middle mb-0" style="color:white; font-size:32px;">
                    navigate_next
                </span>
            </button>
        </div>
    </div>
</div>

<script>
    $(window).on("load", function(){
        if($('#prodcat')[0].clientWidth < $('#prodcat')[0].scrollWidth){
            $('.catgrad').fadeIn(100);
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
</script>
<?php
include($PROJECTROOT . '/internal/footer.php');
?>