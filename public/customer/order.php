<?php
session_start();
include('../../internal/custcontrol.php');
include('../../internal/htmlhead.php');
include('../../internal/header.php');
$shortName = strtok($_SESSION["name"], " ");

if(isset($_SESSION['latestOrdID'])){
    $orderText = $_SESSION['latestOrdID'];
} else {
    $orderText = "#ERROR";
}

if(isset($_GET['order'])){
    if($_GET['order'] == 'success'){
        ?>
        <div class="px-3 my-auto">
            <div style="margin:auto; text-align:center; width:50%;" class="pb-2">
                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="64" height="64" viewBox="0 0 48 48">
                    <linearGradient id="I9GV0SozQFknxHSR6DCx5a_70yRC8npwT3d_gr1" x1="9.858" x2="38.142" y1="9.858" y2="38.142" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#21ad64"></stop><stop offset="1" stop-color="#088242"></stop></linearGradient><path fill="url(#I9GV0SozQFknxHSR6DCx5a_70yRC8npwT3d_gr1)" d="M44,24c0,11.045-8.955,20-20,20S4,35.045,4,24S12.955,4,24,4S44,12.955,44,24z"></path><path d="M32.172,16.172L22,26.344l-5.172-5.172c-0.781-0.781-2.047-0.781-2.828,0l-1.414,1.414	c-0.781,0.781-0.781,2.047,0,2.828l8,8c0.781,0.781,2.047,0.781,2.828,0l13-13c0.781-0.781,0.781-2.047,0-2.828L35,16.172	C34.219,15.391,32.953,15.391,32.172,16.172z" opacity=".05"></path><path d="M20.939,33.061l-8-8c-0.586-0.586-0.586-1.536,0-2.121l1.414-1.414c0.586-0.586,1.536-0.586,2.121,0	L22,27.051l10.525-10.525c0.586-0.586,1.536-0.586,2.121,0l1.414,1.414c0.586,0.586,0.586,1.536,0,2.121l-13,13	C22.475,33.646,21.525,33.646,20.939,33.061z" opacity=".07"></path><path fill="#fff" d="M21.293,32.707l-8-8c-0.391-0.391-0.391-1.024,0-1.414l1.414-1.414c0.391-0.391,1.024-0.391,1.414,0	L22,27.758l10.879-10.879c0.391-0.391,1.024-0.391,1.414,0l1.414,1.414c0.391,0.391,0.391,1.024,0,1.414l-13,13	C22.317,33.098,21.683,33.098,21.293,32.707z"></path>
                </svg>
            </div>
            <div style="margin:auto; text-align:center; width:50%;" class="align-middle d-flex align-items-center justify-content-center">
                <div class='d-flex justify-content-center align-items-center row ms-1'>
                    <h1 class="fw-black align-middle mb-0">ORDER RECEIVED!</h1>
                    <span class="fs-3 fw-medium align-middle mb-2">Our baristas will prepare your order shortly.</span>
                    <hr>
                    <span class="fs-3 fw-medium align-middle mb-0">Your order number is:</span>
                    <div class="bg-warning rounded-pill mb-4 w-25">
                        <span class="fs-1 fw-black align-middle"><?php echo $orderText ?></span>
                    </div>
                    <hr class="pt-2">
                    <span class="fs-5 align-middle mb-0">Please wait while we confirm your payment and prepare your order. You can track your orders at your account page. If you have any problems with the order you can contact us.</span>
                </div>
            </div>
        </div>
        <?php
    } else if($_GET['order'] == 'fail'){
        ?>
        <div class="px-3 my-auto">
            <div style="margin:auto; text-align:center; width:50%;" class="pb-2">
                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="64" height="64" viewBox="0 0 48 48">
                    <linearGradient id="wRKXFJsqHCxLE9yyOYHkza_fYgQxDaH069W_gr1" x1="9.858" x2="38.142" y1="9.858" y2="38.142" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#f44f5a"></stop><stop offset=".443" stop-color="#ee3d4a"></stop><stop offset="1" stop-color="#e52030"></stop></linearGradient><path fill="url(#wRKXFJsqHCxLE9yyOYHkza_fYgQxDaH069W_gr1)" d="M44,24c0,11.045-8.955,20-20,20S4,35.045,4,24S12.955,4,24,4S44,12.955,44,24z"></path><path d="M33.192,28.95L28.243,24l4.95-4.95c0.781-0.781,0.781-2.047,0-2.828l-1.414-1.414	c-0.781-0.781-2.047-0.781-2.828,0L24,19.757l-4.95-4.95c-0.781-0.781-2.047-0.781-2.828,0l-1.414,1.414	c-0.781,0.781-0.781,2.047,0,2.828l4.95,4.95l-4.95,4.95c-0.781,0.781-0.781,2.047,0,2.828l1.414,1.414	c0.781,0.781,2.047,0.781,2.828,0l4.95-4.95l4.95,4.95c0.781,0.781,2.047,0.781,2.828,0l1.414-1.414	C33.973,30.997,33.973,29.731,33.192,28.95z" opacity=".05"></path><path d="M32.839,29.303L27.536,24l5.303-5.303c0.586-0.586,0.586-1.536,0-2.121l-1.414-1.414	c-0.586-0.586-1.536-0.586-2.121,0L24,20.464l-5.303-5.303c-0.586-0.586-1.536-0.586-2.121,0l-1.414,1.414	c-0.586,0.586-0.586,1.536,0,2.121L20.464,24l-5.303,5.303c-0.586,0.586-0.586,1.536,0,2.121l1.414,1.414	c0.586,0.586,1.536,0.586,2.121,0L24,27.536l5.303,5.303c0.586,0.586,1.536,0.586,2.121,0l1.414-1.414	C33.425,30.839,33.425,29.889,32.839,29.303z" opacity=".07"></path><path fill="#fff" d="M31.071,15.515l1.414,1.414c0.391,0.391,0.391,1.024,0,1.414L18.343,32.485	c-0.391,0.391-1.024,0.391-1.414,0l-1.414-1.414c-0.391-0.391-0.391-1.024,0-1.414l14.142-14.142	C30.047,15.124,30.681,15.124,31.071,15.515z"></path><path fill="#fff" d="M32.485,31.071l-1.414,1.414c-0.391,0.391-1.024,0.391-1.414,0L15.515,18.343	c-0.391-0.391-0.391-1.024,0-1.414l1.414-1.414c0.391-0.391,1.024-0.391,1.414,0l14.142,14.142	C32.876,30.047,32.876,30.681,32.485,31.071z"></path>
                </svg>
            </div>
            <div style="margin:auto; text-align:center; width:50%;" class="align-middle d-flex align-items-center justify-content-center">
                <div class='d-flex justify-content-center align-items-center row ms-1'>
                    <h1 class="fw-black align-middle mb-0">ORDER FAILED!</h1>
                    <span class="fs-3 fw-medium align-middle mb-0">Don't worry, you can try ordering again.</span>
                    <span class="fs-5 align-middle mb-0">For some reason, your payment failed. Your order status is available at your account page. You can try again later, or pay by cash over the counter. If this issue persists even when paying by cash, please contact us.</span>
                </div>
            </div>
        </div>
        <?php
    } else {
        ?>
        <div class="px-3 my-auto">
            <div style="margin:auto; text-align:center; width:50%;" class="pb-2">
                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="64" height="64" viewBox="0 0 48 48">
                    <linearGradient id="sovdt~R4OFNDctTsTX3n7a_jBl6xwooyufg_gr1" x1="30.222" x2="38.085" y1="6.003" y2="22.657" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#f44f5a"></stop><stop offset=".443" stop-color="#ee3d4a"></stop><stop offset="1" stop-color="#e52030"></stop></linearGradient><path fill="url(#sovdt~R4OFNDctTsTX3n7a_jBl6xwooyufg_gr1)" d="M34.616,4.103c-3.671,0.547-6.68,3.416-7.426,7.051c-0.422,2.056-0.114,4.003,0.676,5.678	c-0.009,0.02-0.019,0.036-0.027,0.059l-2.263,5.148c-0.211,0.479,0.296,0.958,0.762,0.72l4.581-2.333	c1.871,1.282,4.248,1.88,6.774,1.418c3.647-0.667,6.562-3.629,7.175-7.285C45.897,8.432,40.726,3.193,34.616,4.103z"></path><path d="M37.623,16.41c-0.217-0.197-0.467-0.349-0.744-0.448c0.578-0.14,1.01-0.646,1.033-1.267l0.249-6.282	c0.015-0.367-0.122-0.73-0.377-0.995C37.529,7.152,37.172,7,36.804,7h-1.608c-0.367,0-0.724,0.151-0.979,0.416	c-0.255,0.265-0.393,0.628-0.379,0.993l0.235,6.284c0.024,0.628,0.465,1.139,1.051,1.272c-0.265,0.097-0.508,0.24-0.721,0.427	c-0.47,0.411-0.719,0.965-0.719,1.6c0,0.609,0.239,1.154,0.692,1.576c0.433,0.403,0.997,0.617,1.63,0.617	c0.637,0,1.199-0.209,1.627-0.606c0.445-0.416,0.681-0.965,0.681-1.587C38.315,17.369,38.075,16.822,37.623,16.41z" opacity=".05"></path><linearGradient id="sovdt~R4OFNDctTsTX3n7b_jBl6xwooyufg_gr2" x1="12.608" x2="19.584" y1="12.608" y2="19.584" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#32bdef"></stop><stop offset="1" stop-color="#1ea2e4"></stop></linearGradient><circle cx="16" cy="16" r="5" fill="url(#sovdt~R4OFNDctTsTX3n7b_jBl6xwooyufg_gr2)"></circle><linearGradient id="sovdt~R4OFNDctTsTX3n7c_jBl6xwooyufg_gr3" x1="13.637" x2="17.678" y1="23.835" y2="44.039" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#32bdef"></stop><stop offset="1" stop-color="#1ea2e4"></stop></linearGradient><path fill="url(#sovdt~R4OFNDctTsTX3n7c_jBl6xwooyufg_gr3)" d="M16,23c-4.971,0-9,4.029-9,9v8c0,1.105,0.895,2,2,2h14c1.105,0,2-0.895,2-2v-8	C25,27.029,20.971,23,16,23z"></path><path d="M35.431,15.5h1.125c0.463,0,0.839-0.362,0.857-0.824l0.249-6.284	c0.009-0.231-0.078-0.461-0.238-0.628C37.262,7.596,37.037,7.5,36.804,7.5h-1.608c-0.232,0-0.458,0.096-0.618,0.263	c-0.161,0.168-0.249,0.396-0.239,0.628l0.235,6.283C34.591,15.138,34.968,15.5,35.431,15.5z" opacity=".07"></path><path d="M37.286,16.779c-0.669-0.611-1.855-0.62-2.553-0.011c-0.358,0.313-0.548,0.737-0.548,1.224	c0,0.467,0.185,0.886,0.533,1.21c0.344,0.321,0.777,0.483,1.29,0.483c0.516,0,0.948-0.158,1.286-0.473	c0.341-0.318,0.521-0.74,0.521-1.221C37.815,17.514,37.632,17.095,37.286,16.779z" opacity=".07"></path><path fill="#fff" d="M36.007,19.186c-0.383,0-0.699-0.116-0.948-0.349c-0.249-0.232-0.374-0.513-0.374-0.844 c0-0.345,0.126-0.628,0.377-0.848c0.251-0.22,0.566-0.33,0.945-0.33c0.383,0,0.697,0.111,0.941,0.334 c0.244,0.223,0.366,0.504,0.366,0.844c0,0.345-0.121,0.63-0.363,0.855C36.71,19.073,36.395,19.186,36.007,19.186z M37.162,8.372 l-0.248,6.284C36.906,14.848,36.748,15,36.556,15h-1.125c-0.193,0-0.35-0.152-0.358-0.345l-0.235-6.284 C34.831,8.169,34.993,8,35.196,8h1.608C37.007,8,37.17,8.169,37.162,8.372z"></path>
                </svg>
            </div>
            <div style="margin:auto; text-align:center; width:50%;" class="align-middle d-flex align-items-center justify-content-center">
                <div class='d-flex justify-content-center align-items-center row ms-1'>
                    <h1 class="fw-black align-middle mb-0">YOU DISCOVERED A BUG!</h1>
                    <span class="fs-4 align-middle mb-0">Or perhaps you accessed this page manually.</span>
                </div>
            </div>
        </div>
        <?php
        //echo "<script>$(document).ready(function(){showItemRequiredModal()})</script>";
    }
} else {
    ?>
    <div class="px-3 my-auto">
        <div style="margin:auto; text-align:center; width:50%;">
            <span class="material-symbols-outlined" style="margin:auto;display:inline-block;font-size:96px;">
                unknown_document
            </span>
            <p class="h3 fw-medium user-select-none">The server is experiencing some issues. Please try again later.</p>
            <a href="/" class="btn btn-outline-danger">RETURN HOME</a>
        </div>
    </div>
    <?php
}
?>

<?php
include('../../internal/footer.php');
?>