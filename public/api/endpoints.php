<?php
//use this page to store useful variables for global API use
$SERVERROOT = $_SERVER["DOCUMENT_ROOT"]; //server root, /public/
$PROJECTROOT = $_SERVER["DOCUMENT_ROOT"] . '/..';
$isApiPage = true;
//http_response_code(401);
//include($SERVERROOT . "/error/401.php");
include($PROJECTROOT . "/internal/htmlhead.php");
include($PROJECTROOT . "/internal/apiheader.php");
?>
<div class="px-3">
    <div class="h3 fw-black">
        AHVELO COFFEE API ENDPOINTS
    </div>
    <div class="mb-2">
        Ahvelo Coffee API consists of several endpoints. Basic structure is <code>/SUBJECT/METHOD/OBJECT.php</code>. Listed below are the subject endpoints and methods available.
    </div>
    <div class="mb-2">
        <p class="mb-0">
            <button class="border border-danger-subtle bg-white rounded-4 px-2 py-2 collapsible-icn-btn" type="button" data-bs-toggle="collapse" data-bs-target="#faq1" aria-expanded="false" aria-controls="faq1">
                <span class="align-middle material-symbols-outlined collapsible-icn" style="font-size:24px;">chevron_right</span>
                <span class="pe-2"><code>/admin/</code> endpoint</span>
            </button>
        </p>
        <div class="collapse rounded-4 pt-0 mt-0" id="faq1">
            <div class="card border border-danger-subtle rounded-4 card-body">
                <span class="fw-bold">Methods available:</span>
                <span><code>/create/, /get/, /update/</code></span><br>
                <span class="fw-bold"><code>/create/</code> implementations:</span>
                <span><code>/product.php</code></span><br>
                <span class="fw-bold"><code>/get/</code> implementations:</span>
                <span><code>/employees.php, /users.php</code></span><br>
                <span class="fw-bold"><code>/update/</code> implementations:</span>
                <span><code>/products.php</code></span>
            </div>
        </div>
    </div>
    <div class="mb-2">
        <p class="mb-0">
            <button class="border border-danger-subtle bg-white rounded-4 px-2 py-2 collapsible-icn-btn" type="button" data-bs-toggle="collapse" data-bs-target="#faq2" aria-expanded="false" aria-controls="faq2">
                <span class="align-middle material-symbols-outlined collapsible-icn" style="font-size:24px;">chevron_right</span>
                <span class="pe-2"><code>/staff/</code> endpoint</span>
            </button>
        </p>
        <div class="collapse rounded-4 pt-0 mt-0" id="faq2">
            <div class="card border border-danger-subtle rounded-4 card-body">
                <span class="fw-bold">Methods available:</span>
                <span><code>/create/, /get/, /update/</code></span><br>
                <span class="fw-bold"><code>/create/</code> implementations:</span>
                <span><code>/product.php</code></span><br>
                <span class="fw-bold"><code>/get/</code> implementations:</span>
                <span><code>/employees.php, /users.php</code></span><br>
                <span class="fw-bold"><code>/update/</code> implementations:</span>
                <span><code>/products.php</code></span>
            </div>
        </div>
    </div>
    <div class="mb-2">
        There is an exception with this convention. The endpoint structure <code>/METHOD/OBJECT.php</code> is also used for general objects which do not require any subject in context.
        In addition, the endpoint with a <code>/SUBJECT/METHOD.php</code> structure also exists since no object is needed. Listed below are the two endpoints in question.
    </div>
    <div class="mb-2">
        <p class="mb-0">
            <button class="border border-danger-subtle bg-white rounded-4 px-2 py-2 collapsible-icn-btn" type="button" data-bs-toggle="collapse" data-bs-target="#spe1" aria-expanded="false" aria-controls="spe1">
                <span class="align-middle material-symbols-outlined collapsible-icn" style="font-size:24px;">chevron_right</span>
                <span class="pe-2"><code>/get/</code> method endpoint</span>
            </button>
        </p>
        <div class="collapse rounded-4 pt-0 mt-0" id="spe1">
            <div class="card border border-danger-subtle rounded-4 card-body">
                Please enquire about the refund directly on-site with our staff member.
            </div>
        </div>
    </div>
    <div class="mb-2">
        <p class="mb-0">
            <button class="border border-danger-subtle bg-white rounded-4 px-2 py-2 collapsible-icn-btn" type="button" data-bs-toggle="collapse" data-bs-target="#spe2" aria-expanded="false" aria-controls="spe2">
                <span class="align-middle material-symbols-outlined collapsible-icn" style="font-size:24px;">chevron_right</span>
                <span class="pe-2"><code>/payment/</code> subject endpoint</span>
            </button>
        </p>
        <div class="collapse rounded-4 pt-0 mt-0" id="spe2">
            <div class="card border border-danger-subtle rounded-4 card-body">
                Please enquire about the refund directly on-site with our staff member.
            </div>
        </div>
    </div>
</div>
<?php
include($PROJECTROOT . "/internal/footer.php")
?>