<?php
session_start();
include('../internal/htmlhead.php');
include('../internal/header.php');
?>
<div class="px-3 pb-3">
    <h3 class="fw-black">FREQUENTLY ASKED QUESTIONS</h3>
    <p>Here, you can find several frequently asked questions about the Ahvelo Coffee online store.</p>
    <div class="mb-2">
        <p class="mb-0">
            <button class="border border-danger-subtle bg-white rounded-4 px-2 py-2 collapsible-icn-btn" type="button" data-bs-toggle="collapse" data-bs-target="#faq1" aria-expanded="false" aria-controls="faq1">
                <span class="align-middle material-symbols-outlined collapsible-icn" style="font-size:24px;">chevron_right</span>
                <span class="pe-2">How much time does it take to prepare my order?</span>
            </button>
        </p>
        <div class="collapse rounded-4 pt-0 mt-0" id="faq1">
            <div class="card border border-danger-subtle rounded-4 card-body">
                It depends on your order size and payment method, but a small online order (1 cup) will take around 15 minutes to be prepared after we confirm your payment.
            </div>
        </div>
    </div>
    <div class="mb-2">
        <p class="mb-0">
            <button class="border border-danger-subtle bg-white rounded-4 px-2 py-2 collapsible-icn-btn" type="button" data-bs-toggle="collapse" data-bs-target="#faq2" aria-expanded="false" aria-controls="faq2">
                <span class="align-middle material-symbols-outlined collapsible-icn" style="font-size:24px;">chevron_right</span>
                <span class="pe-2">For orders with payment at the counter, when will the order be prepared?</span>
            </button>
        </p>
        <div class="collapse rounded-4 pt-0 mt-0" id="faq2">
            <div class="card border border-danger-subtle rounded-4 card-body">
                After payment is made at the counter, we will proceed to prepare the order.
            </div>
        </div>
    </div>
    <div class="mb-2">
        <p class="mb-0">
            <button class="border border-danger-subtle bg-white rounded-4 px-2 py-2 collapsible-icn-btn" type="button" data-bs-toggle="collapse" data-bs-target="#faq3" aria-expanded="false" aria-controls="faq3">
                <span class="align-middle material-symbols-outlined collapsible-icn" style="font-size:24px;">chevron_right</span>
                <span class="pe-2">I would like a refund of my purchase. How do I start the refund process?</span>
            </button>
        </p>
        <div class="collapse rounded-4 pt-0 mt-0" id="faq3">
            <div class="card border border-danger-subtle rounded-4 card-body">
                Please enquire about the refund directly on-site with our staff member.
            </div>
        </div>
    </div>
</div>
<?php
include('../internal/footer.php');
?>