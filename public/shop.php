<?php
session_start();
include('../internal/htmlhead.php');
include('../internal/header.php');
?>
<div class="px-3 py-3">
    <div class="px-2">
        <div class="fw-black row px-2 h2">PRODUCTS</div>
        <div>Order now!</div>
        <div id="prodcat" class="d-flex justify-content-center row row-cols-auto w-100 align-items-start">
            <?php
                for($x = 0; $x <= 10; $x++){
                    ?>
                    <div class="col align-items-center justify-content-center align-middle text-center my-3" style="display: inline-block;">
                        <svg class="flex-row bd-placeholder-img bd-placeholder-img-lg rounded-5" width="200" height="200" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: First slide" preserveAspectRatio="xMidYMid slice" focusable="false">
                            <title>Placeholder</title>
                            <rect width="100%" height="100%" fill="#777"></rect>
                            <text x="50%" y="50%" fill="#555" dy=".3em">First slide</text>
                        </svg>
                        <div class="flex-row fw-normal fs-4 py-2">Test</div>
                        <button class="btn btn-primary ahvbutton flex-row fw-normal rounded-pill fs-4 align-middle text-center border-0 pe-2 py-2">
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
    </div>
</div>
<?php
include('../internal/footer.php');
?>