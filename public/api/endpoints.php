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
            <button class="border border-danger-subtle bg-white rounded-4 px-2 py-2 collapsible-icn-btn" type="button" data-bs-toggle="collapse" data-bs-target="#endpoint1" aria-expanded="false" aria-controls="endpoint1">
                <span class="align-middle material-symbols-outlined collapsible-icn" style="font-size:24px;">chevron_right</span>
                <span class="pe-2"><code>/admin</code> endpoint</span>
            </button>
        </p>
        <div class="collapse rounded-4 pt-0 mt-0" id="endpoint1">
            <div class="card border border-danger-subtle rounded-4 card-body">
                <span class="fw-bold">Methods available:</span>
                <span><code>/create, /delete, /get, /update</code></span><br>
                <span class="fw-bold"><code>/create</code> implementations:</span>
                <span><code>/categories.php, /product.php</code></span><br>
                <span class="fw-bold"><code>/delete</code> implementations:</span>
                <span><code>/category.php, /product.php, /user.php</code></span><br>
                <span class="fw-bold"><code>/get</code> implementations:</span>
                <span><code>/employees.php, /users.php</code></span><br>
                <span class="fw-bold"><code>/update/</code> implementations:</span>
                <span><code>/categories.php, /products.php, /users.php</code></span>
            </div>
        </div>
    </div>
    <div class="mb-2">
        <p class="mb-0">
            <button class="border border-danger-subtle bg-white rounded-4 px-2 py-2 collapsible-icn-btn" type="button" data-bs-toggle="collapse" data-bs-target="#endpoint2" aria-expanded="false" aria-controls="endpoint2">
                <span class="align-middle material-symbols-outlined collapsible-icn" style="font-size:24px;">chevron_right</span>
                <span class="pe-2"><code>/notification</code> endpoint</span>
            </button>
        </p>
        <div class="collapse rounded-4 pt-0 mt-0" id="endpoint2">
            <div class="card border border-danger-subtle rounded-4 card-body">
                <span class="fw-bold">Methods available:</span>
                <span><code>/get/, /post/, /update/</code></span><br>
                <span class="fw-bold"><code>/get</code> implementations:</span>
                <span><code>/messages.php</code></span><br>
                <span class="fw-bold"><code>/post</code> implementations:</span>
                <span><code>/message.php, /token.php</code></span><br>
                <span class="fw-bold"><code>/update</code> implementations:</span>
                <span><code>/read.php</code></span>
            </div>
        </div>
    </div>
    <div class="mb-2">
        <p class="mb-0">
            <button class="border border-danger-subtle bg-white rounded-4 px-2 py-2 collapsible-icn-btn" type="button" data-bs-toggle="collapse" data-bs-target="#endpoint3" aria-expanded="false" aria-controls="endpoint3">
                <span class="align-middle material-symbols-outlined collapsible-icn" style="font-size:24px;">chevron_right</span>
                <span class="pe-2"><code>/staff</code> endpoint</span>
            </button>
        </p>
        <div class="collapse rounded-4 pt-0 mt-0" id="endpoint3">
            <div class="card border border-danger-subtle rounded-4 card-body">
                <span class="fw-bold">Methods available:</span>
                <span><code>/get, /update</code></span><br>
                <span class="fw-bold"><code>/get</code> implementations:</span>
                <span><code>/orders.php</code></span><br>
                <span class="fw-bold"><code>/update</code> implementations:</span>
                <span><code>/orders.php, /products.php</code></span>
            </div>
        </div>
    </div>
    <div class="mb-2">
        <p class="mb-0">
            <button class="border border-danger-subtle bg-white rounded-4 px-2 py-2 collapsible-icn-btn" type="button" data-bs-toggle="collapse" data-bs-target="#endpoint4" aria-expanded="false" aria-controls="endpoint4">
                <span class="align-middle material-symbols-outlined collapsible-icn" style="font-size:24px;">chevron_right</span>
                <span class="pe-2"><code>/user</code> endpoint</span>
            </button>
        </p>
        <div class="collapse rounded-4 pt-0 mt-0" id="endpoint4">
            <div class="card border border-danger-subtle rounded-4 card-body">
                <span class="fw-bold">Methods available:</span>
                <span><code>/get/, /post/, /update/</code></span><br>
                <span class="fw-bold"><code>/get</code> implementations:</span>
                <span><code>/cart.php, /orders.php</code></span><br>
                <span class="fw-bold"><code>/post</code> implementations:</span>
                <span><code>/cart.php, /orders.php</code></span><br>
                <span class="fw-bold"><code>/update</code> implementations:</span>
                <span><code>/user.php</code></span>
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
                <span class="pe-2"><code>/auth</code> method endpoint</span>
            </button>
        </p>
        <div class="collapse rounded-4 pt-0 mt-0" id="spe1">
            <div class="card border border-danger-subtle rounded-4 card-body">
                <span class="fw-bold"><code>/auth</code> implementations:</span>
                <span><code>/login.php, /signout.php, /signup.php</code></span><br>
            </div>
        </div>
    </div>
    <div class="mb-2">
        <p class="mb-0">
            <button class="border border-danger-subtle bg-white rounded-4 px-2 py-2 collapsible-icn-btn" type="button" data-bs-toggle="collapse" data-bs-target="#spe2" aria-expanded="false" aria-controls="spe2">
                <span class="align-middle material-symbols-outlined collapsible-icn" style="font-size:24px;">chevron_right</span>
                <span class="pe-2"><code>/create</code> method endpoint</span>
            </button>
        </p>
        <div class="collapse rounded-4 pt-0 mt-0" id="spe2">
            <div class="card border border-danger-subtle rounded-4 card-body">
                <span class="fw-bold"><code>/create</code> implementations:</span>
                <span><code>/mail.php</code></span><br>
            </div>
        </div>
    </div>
    <div class="mb-2">
        <p class="mb-0">
            <button class="border border-danger-subtle bg-white rounded-4 px-2 py-2 collapsible-icn-btn" type="button" data-bs-toggle="collapse" data-bs-target="#spe3" aria-expanded="false" aria-controls="spe3">
                <span class="align-middle material-symbols-outlined collapsible-icn" style="font-size:24px;">chevron_right</span>
                <span class="pe-2"><code>/get</code> method endpoint</span>
            </button>
        </p>
        <div class="collapse rounded-4 pt-0 mt-0" id="spe3">
            <div class="card border border-danger-subtle rounded-4 card-body">
                <span class="fw-bold"><code>/get</code> implementations:</span>
                <span><code>/categories.php, /customers.php, /positions.php, /products.php</code></span><br>
            </div>
        </div>
    </div>
    <div class="mb-2">
        <p class="mb-0">
            <button class="border border-danger-subtle bg-white rounded-4 px-2 py-2 collapsible-icn-btn" type="button" data-bs-toggle="collapse" data-bs-target="#spe4" aria-expanded="false" aria-controls="spe4">
                <span class="align-middle material-symbols-outlined collapsible-icn" style="font-size:24px;">chevron_right</span>
                <span class="pe-2"><code>/request</code> method endpoint</span>
            </button>
        </p>
        <div class="collapse rounded-4 pt-0 mt-0" id="spe4">
            <div class="card border border-danger-subtle rounded-4 card-body">
                <span class="fw-bold"><code>/request</code> implementations:</span>
                <span><code>/password.php</code></span><br>
            </div>
        </div>
    </div>
    <div class="mb-2">
        <p class="mb-0">
            <button class="border border-danger-subtle bg-white rounded-4 px-2 py-2 collapsible-icn-btn" type="button" data-bs-toggle="collapse" data-bs-target="#spe5" aria-expanded="false" aria-controls="spe5">
                <span class="align-middle material-symbols-outlined collapsible-icn" style="font-size:24px;">chevron_right</span>
                <span class="pe-2"><code>/update</code> method endpoint</span>
            </button>
        </p>
        <div class="collapse rounded-4 pt-0 mt-0" id="spe5">
            <div class="card border border-danger-subtle rounded-4 card-body">
                <span class="fw-bold"><code>/update</code> implementations:</span>
                <span><code>/password.php</code></span><br>
            </div>
        </div>
    </div>
    <div class="mb-2">
        <p class="mb-0">
            <button class="border border-danger-subtle bg-white rounded-4 px-2 py-2 collapsible-icn-btn" type="button" data-bs-toggle="collapse" data-bs-target="#spe6" aria-expanded="false" aria-controls="spe6">
                <span class="align-middle material-symbols-outlined collapsible-icn" style="font-size:24px;">chevron_right</span>
                <span class="pe-2"><code>/payment</code> subject endpoint</span>
            </button>
        </p>
        <div class="collapse rounded-4 pt-0 mt-0" id="spe6">
            <div class="card border border-danger-subtle rounded-4 card-body">
                <span class="fw-bold">Methods available:</span>
                <span><code>/update.php</code></span><br>
            </div>
        </div>
    </div>
</div>
<?php
include($PROJECTROOT . "/internal/footer.php")
?>