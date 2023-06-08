<?php
    $ROOTPATH = $_SERVER["DOCUMENT_ROOT"] . '/..';
    session_start();
    $creds = parse_ini_file($ROOTPATH."/.ini");
    $STRIPE_API_KEY = $creds['secret_key'];
    $STRIPE_ENDPOINT_SECRET = $creds['endpoint_secret'];
    // webhook.php
    //
    // Use this sample code to handle webhook events in your integration.
    //
    // 1) Paste this code into a new file (webhook.php)
    //
    // 2) Install dependencies
    //   composer require stripe/stripe-php
    //
    // 3) Run the server on http://localhost:4242
    //   php -S localhost:4242

    //require 'vendor/autoload.php';

    require_once $ROOTPATH . '/internal/stripe-php/init.php';
    require_once $ROOTPATH . "/internal/db.php";

    // The library needs to be configured with your account's secret key.
    // Ensure the key is kept out of any version control system you might be using.
    $stripe = new \Stripe\StripeClient($STRIPE_API_KEY);

    // This is your Stripe CLI webhook secret for testing your endpoint locally.
    $endpoint_secret = $STRIPE_ENDPOINT_SECRET;

    $payload = @file_get_contents('php://input');
    $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
    $event = null;

    try {
        $event = \Stripe\Webhook::constructEvent(
        $payload, $sig_header, $endpoint_secret
        );
    } catch(\UnexpectedValueException $e) {
        // Invalid payload
        http_response_code(400);
        exit();
    } catch(\Stripe\Exception\SignatureVerificationException $e) {
        // Invalid signature
        http_response_code(400);
        exit();
    }

    // Handle the event
    switch ($event->type) {
        case 'charge.failed':
            $charge = $event->data->object;
            $orderId = $event->data->metadata->order_id;
            $statusText = 'Failed';
            break;
        case 'charge.succeeded':
            $charge = $event->data->object;
            $orderId = $event->data->metadata->order_id;
            $statusText = 'Paid';
            break;
        case 'checkout.session.async_payment_failed':
            $session = $event->data->object;
            $orderId = $event->data->metadata->order_id;
            $statusText = 'Failed';
            break;
        case 'checkout.session.async_payment_succeeded':
            $session = $event->data->object;
            $orderId = $event->data->metadata->order_id;
            $statusText = 'Paid';
            break;
        case 'checkout.session.completed':
            $session = $event->data->object;
            $orderId = $event->data->metadata->order_id;
            $statusText = 'Paid';
            break;
        case 'checkout.session.expired':
            $session = $event->data->object;
            $orderId = $event->data->metadata->order_id;
            $statusText = 'Failed';
            break;
        // ... handle other event types
        default:
        echo 'Received unknown event type ' . $event->type;
    }
    if(!isset($statusText)){
        http_response_code(500);
    }
    if(!isset($orderId) || !is_numeric($orderId)){
        http_response_code(500);
    }
    $updateOrderSQL = "UPDATE orders SET order_status = ? WHERE order_id = ?";
    if($stmt=mysqli_prepare($conn, $updateOrderSQL)){
        mysqli_stmt_bind_param($stmt, 'si', $order_status, $order_id);

        $order_status = $statusText;
        $order_id = $orderId;
        if(!mysqli_stmt_execute($stmt)){
            mysqli_stmt_close($stmt);
            http_response_code(500);
            die();
        }

        mysqli_stmt_close($stmt);
    }
    http_response_code(200);
?>