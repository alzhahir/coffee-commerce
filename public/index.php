<?php
session_start();
include('../internal/htmlhead.php');
include('../internal/header.php');
?>
<div class="px-3 py-3">
    <div class="py-2 px-2">
        <div id="carouselExampleRide" class="overflow-hidden rounded-5 carousel slide" data-bs-ride="true">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <!--img src="..." class="d-block w-100" alt="..."-->
                    <svg class="bd-placeholder-img bd-placeholder-img-lg d-block w-100" width="800" height="400" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: First slide" preserveAspectRatio="xMidYMid slice" focusable="false">
                        <title>Placeholder</title>
                        <rect width="100%" height="100%" fill="#777"></rect>
                        <text x="50%" y="50%" fill="#555" dy=".3em">First slide</text>
                    </svg>
                </div>
                <div class="carousel-item">
                    <!--img src="..." class="d-block w-100" alt="..."-->
                    <svg class="bd-placeholder-img bd-placeholder-img-lg d-block w-100" width="800" height="400" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: First slide" preserveAspectRatio="xMidYMid slice" focusable="false">
                        <title>Placeholder</title>
                        <rect width="100%" height="100%" fill="#777"></rect>
                        <text x="50%" y="50%" fill="#555" dy=".3em">Second slide</text>
                    </svg>
                </div>
                <div class="carousel-item">
                    <!--img src="..." class="d-block w-100" alt="..."-->
                    <svg class="bd-placeholder-img bd-placeholder-img-lg d-block w-100" width="800" height="400" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: First slide" preserveAspectRatio="xMidYMid slice" focusable="false">
                        <title>Placeholder</title>
                        <rect width="100%" height="100%" fill="#777"></rect>
                        <text x="50%" y="50%" fill="#555" dy=".3em">Third slide</text>
                    </svg>
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
        <div class="fw-black row p-2">BESTSELLERS</div>
        <div id="prodcat" class="row flex-row flex-nowrap" style="overflow-x:scroll; white-space: nowrap; float: none; position:relative; touch-action:pan-x;">
            <?php
                for($x = 0; $x <= 10; $x++){
                    ?>
                    <div class="col w-100 align-items-center justify-content-center align-middle text-center" style="display: inline-block;">
                        <svg class="flex-row bd-placeholder-img bd-placeholder-img-lg d-block rounded-5" width="200" height="200" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: First slide" preserveAspectRatio="xMidYMid slice" focusable="false">
                            <title>Placeholder</title>
                            <rect width="100%" height="100%" fill="#777"></rect>
                            <text x="50%" y="50%" fill="#555" dy=".3em">First slide</text>
                        </svg>
                        <div id="prodNameLabel" class="flex-row fw-bold fs-4 pt-2">ProductName</div>
                        <div id="prodPriceLabel" class="flex-row fw-normal fs-4 pb-2">#PRICE</div>
                        <button class="btn btn-primary ahvbutton flex-row fw-normal rounded-pill fs-4 align-middle text-center border-0 px-4 py-2">
                            <span class="material-symbols-outlined align-middle text-center px-0">
                                add_shopping_cart
                            </span>
                            Add to Cart
                        </button>
                    </div>
                <?php
                }
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
        <div class="catgrad overflow-visible" style="bottom:-5%;right:-5px;position:absolute;">
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
include('../internal/footer.php');
?>