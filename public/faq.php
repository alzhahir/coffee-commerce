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
                <span class="pe-auto">How long does it take to prepare my order?</span>
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
                <span class="pe-2">When will my order be prepared?</span>
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
                <span class="pe-2">I would like a refund of my purchase.</span>
            </button>
        </p>
        <div class="collapse rounded-4 pt-0 mt-0" id="faq3">
            <div class="card border border-danger-subtle rounded-4 card-body">
                Please enquire about the refund directly on-site with our staff member.
            </div>
        </div>
    </div>
    <div class="mb-2">
        <p class="mb-0">
            <button class="border border-danger-subtle bg-white rounded-4 px-2 py-2 collapsible-icn-btn" type="button" data-bs-toggle="collapse" data-bs-target="#faq4" aria-expanded="false" aria-controls="faq4">
                <span class="align-middle material-symbols-outlined collapsible-icn" style="font-size:24px;">chevron_right</span>
                <span class="pe-2">How do I view my past purchases?</span>
            </button>
        </p>
        <div class="collapse rounded-4 pt-0 mt-0" id="faq4">
            <div class="card border border-danger-subtle rounded-4 card-body">
                You can log into Your Account portal and selecting the "Your Orders" tab at the top.
            </div>
        </div>
    </div>
    <div class="mb-2">
        <p class="mb-0">
            <button class="border border-danger-subtle bg-white rounded-4 px-2 py-2 collapsible-icn-btn" type="button" data-bs-toggle="collapse" data-bs-target="#faq5" aria-expanded="false" aria-controls="faq5">
                <span class="align-middle material-symbols-outlined collapsible-icn" style="font-size:24px;">chevron_right</span>
                <span class="pe-2">Can I print a receipt for my past purchases?</span>
            </button>
        </p>
        <div class="collapse rounded-4 pt-0 mt-0" id="faq5">
            <div class="card border border-danger-subtle rounded-4 card-body">
                Sure! Here are the steps to print a receipt:
                <ul>
                    <li>Log into your account portal and navigate to the "Your Orders" tab.</li>
                    <li>Select an item to view the order details and then tap or click on the print button.</li>
                </ul>
                It is advised to do this on a higher resolution monitor such as a PC since it may not print all the details.
            </div>
        </div>
    </div>
    <div class="mb-2">
        <p class="mb-0">
            <button class="border border-danger-subtle bg-white rounded-4 px-2 py-2 collapsible-icn-btn" type="button" data-bs-toggle="collapse" data-bs-target="#faq6" aria-expanded="false" aria-controls="faq6">
                <span class="align-middle material-symbols-outlined collapsible-icn" style="font-size:24px;">chevron_right</span>
                <span class="pe-2">What should I do? I forgot my password!</span>
            </button>
        </p>
        <div class="collapse rounded-4 pt-0 mt-0" id="faq6">
            <div class="card border border-danger-subtle rounded-4 card-body">
                Press the account button on the navigation bar to open up the login dropdown. Here, you can press the "RESET PASSWORD" button to initiate the password reset process.
            </div>
        </div>
    </div>
    <div class="mb-2">
        <p class="mb-0">
            <button class="border border-danger-subtle bg-white rounded-4 px-2 py-2 collapsible-icn-btn" type="button" data-bs-toggle="collapse" data-bs-target="#faq7" aria-expanded="false" aria-controls="faq7">
                <span class="align-middle material-symbols-outlined collapsible-icn" style="font-size:24px;">chevron_right</span>
                <span class="pe-2">I selected the wrong payment method!</span>
            </button>
        </p>
        <div class="collapse rounded-4 pt-0 mt-0" id="faq7">
            <div class="card border border-danger-subtle rounded-4 card-body">
                If you accidentally selected cash payment method when you're trying to use the online payment methods, don't worry! We offer cashless payments on-site via QRPay! <br><br> If you accidentally chose Stripe, you can just re-order since the Stripe payment will automatically expire after 30 minutes.
            </div>
        </div>
    </div>
    <div class="mb-2">
        <p class="mb-0">
            <button class="border border-danger-subtle bg-white rounded-4 px-2 py-2 collapsible-icn-btn" type="button" data-bs-toggle="collapse" data-bs-target="#faq8" aria-expanded="false" aria-controls="faq8">
                <span class="align-middle material-symbols-outlined collapsible-icn" style="font-size:24px;">chevron_right</span>
                <span class="pe-2">Where is the shop located again?</span>
            </button>
        </p>
        <div class="collapse rounded-4 pt-0 mt-0" id="faq8">
            <div class="card border border-danger-subtle rounded-4 card-body">
                <span>
                    You may visit <a href="/contact.php">this page</a> for more information about our address and location.
                </span>
            </div>
        </div>
    </div>
</div>
<?php
include('../internal/footer.php');
?>