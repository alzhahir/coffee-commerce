<?php
    $ROOTPATH = $_SERVER["DOCUMENT_ROOT"] . '/..';
    session_start();
    error_reporting(E_ALL);
    $creds = parse_ini_file($ROOTPATH."/.ini");
    $DOMAIN = $_SERVER['HTTP_HOST'];
    $PROTOCOL = $_SERVER['HTTPS'] ? 'https://' : 'http://';
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

    require $ROOTPATH . '/vendor/autoload.php';

    //require_once $ROOTPATH . '/internal/stripe-php/init.php';
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
        echo json_encode([
            'error' => 'INVALID_PAYLOAD',
            'description' => 'Payload is invalid'
        ]);
        http_response_code(400);
        exit();
    } catch(\Stripe\Exception\SignatureVerificationException $e) {
        // Invalid signature
        echo json_encode([
            'error' => 'INVALID_SIGNATURE',
            'description' => 'Signature invalid. Stripe Signature header:'.$sig_header
        ]);
        http_response_code(400);
        exit();
    }

    // Handle the event
    switch ($event->type) {
        case 'charge.failed':
            $charge = $event->data->object;
            $orderId = $event->data->object->metadata['order_id'];
            $statusText = 'Failed';
            break;
        case 'charge.succeeded':
            $charge = $event->data->object;
            $orderId = $event->data->object->metadata['order_id'];
            $statusText = 'Paid';
            break;
        case 'checkout.session.async_payment_failed':
            $session = $event->data->object;
            $orderId = $event->data->object->metadata['order_id'];
            $statusText = 'Failed';
            break;
        case 'checkout.session.async_payment_succeeded':
            $session = $event->data->object;
            $orderId = $event->data->object->metadata['order_id'];
            $statusText = 'Paid';
            break;
        case 'checkout.session.completed':
            $session = $event->data->object;
            $orderId = $event->data->object->metadata['order_id'];
            $statusText = 'Paid';
            break;
        case 'checkout.session.expired':
            $session = $event->data->object;
            $orderId = $event->data->object->metadata['order_id'];
            $statusText = 'Failed';
            break;
        // ... handle other event types
        default:
        echo 'Received unknown event type ' . $event->type;
    }
    if(!isset($statusText)){
        echo json_encode([
            'error' => 'STAT_TXT_NOT_SET',
            'description' => 'Status text not set'
        ]);
        http_response_code(500);
    }
    if(!isset($orderId) || !is_numeric($orderId)){
        echo json_encode([
            'error' => 'ORDER_ID_FAIL',
            'description' => 'Order ID check failed'
        ]);
        http_response_code(500);
    }

    $getPaymentSQL = "SELECT payment_id, cust_id FROM orders WHERE order_id = $orderId";
    $getPaymentRes = mysqli_query($conn, $getPaymentSQL);
    if(!is_bool($getPaymentRes)){
        $currPaymentArr = mysqli_fetch_all($getPaymentRes);
        $currPaymentArr = array_values($currPaymentArr);
        foreach($currPaymentArr as $currPayment){
            $payId = $currPayment[0];
            $custId = $currPayment[1];
        }
    }

    if(!isset($payId)){
        echo json_encode([
            'error' => 'PAY_ID_ERR',
            'description' => 'Failed to retrieve Payment ID'
        ]);
        http_response_code(500);
    }

    $updPaymentSQL = "UPDATE payments SET payment_txn_url = ? WHERE payment_id = ?";
    if($stmt=mysqli_prepare($conn, $updPaymentSQL)){
        mysqli_stmt_bind_param($stmt, "si", $payment_txn_url, $payment_id);

        $payment_txn_url = NULL;
        $payment_id = $payId;

        if(mysqli_stmt_execute($stmt)){
            //
        } else {
            mysqli_stmt_close($stmt);
            echo json_encode([
                'error' => 'DB_ERROR',
                'description' => 'Database error'
            ]);
            http_response_code(500);
            die();
        }

        mysqli_stmt_close($stmt);
    } else {
        echo json_encode([
            'error' => 'DB_BIND_ERROR',
            'description' => 'Database error'
        ]);
        http_response_code(500);
        die();
    }

    $updateOrderSQL = "UPDATE orders SET order_status = ? WHERE order_id = ?";
    if($stmt=mysqli_prepare($conn, $updateOrderSQL)){
        mysqli_stmt_bind_param($stmt, 'si', $order_status, $order_id);

        $order_status = $statusText;
        $order_id = $orderId;
        if(!mysqli_stmt_execute($stmt)){
            mysqli_stmt_close($stmt);
            echo json_encode([
                'error' => 'DB_ERROR',
                'description' => 'Database error'
            ]);
            http_response_code(500);
            die();
        }

        mysqli_stmt_close($stmt);
    }

    $addTrackingSQL = "INSERT INTO trackings (track_desc, order_id) VALUES (?, ?)";
    if($stmt=mysqli_prepare($conn, $addTrackingSQL)){
        mysqli_stmt_bind_param($stmt, "si", $track_desc, $order_id);

        $track_desc = "Order $orderId status changed to $statusText";
        $order_id = $orderId;

        if(!mysqli_stmt_execute($stmt)){
            mysqli_stmt_close($stmt);
            echo json_encode([
                'error' => 'DB_ERROR',
                'description' => 'Database error'
            ]);
            http_response_code(500);
            die();
        }
        mysqli_stmt_close($stmt);
    } else {
        echo json_encode([
            'error' => 'DB_BIND_ERROR',
            'description' => 'Database error'
        ]);
        http_response_code(500);
        die();
    }

    $notifApiUrl = $PROTOCOL.$DOMAIN."/api/notification/post/message.php";

    $title = "Order $statusText";
    $body = "Your order, order $orderId had changed status to $statusText";
    $imageUrl = 'https://img.icons8.com/fluency/96/cup.png';
    $topicVal = "cust".$custId; //get customer topic
    $redir = "/customer/index.php";

    $postfields = [
        "title" => $title,
        "body" => $body,
        "topic" => $topicVal,
        "imgurl" => $imageUrl,
        "redirurl" => $redir
    ];

    $req = curl_init();
    curl_setopt($req, CURLOPT_URL, $notifApiUrl);
    curl_setopt($req, CURLOPT_POST, true);
    curl_setopt($req, CURLOPT_POSTFIELDS, $postfields);
    curl_setopt($req, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($req, CURLOPT_SSL_VERIFYPEER, FALSE);
    $response = curl_exec($req);
    $reserr = curl_error($req);
    $rescode = curl_getinfo($req, CURLINFO_HTTP_CODE);
    if(!$response){
        //
    }
    curl_close ($req);

    $title = "Order $orderId";
    $body = "Order $orderId had changed status to $statusText";
    $imageUrl = 'https://img.icons8.com/fluency/96/cup.png';
    $topicVal = "staff";
    $redir = "/staff/orders/index.php";

    $postfields = [
        "title" => $title,
        "body" => $body,
        "topic" => $topicVal,
        "imgurl" => $imageUrl,
        "redirurl" => $redir
    ];

    $req = curl_init();
    curl_setopt($req, CURLOPT_URL, $notifApiUrl);
    curl_setopt($req, CURLOPT_POST, true);
    curl_setopt($req, CURLOPT_POSTFIELDS, $postfields);
    curl_setopt($req, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($req, CURLOPT_SSL_VERIFYPEER, FALSE);
    $response = curl_exec($req);
    $reserr = curl_error($req);
    $rescode = curl_getinfo($req, CURLINFO_HTTP_CODE);
    if(!$response){
        //
    }
    curl_close ($req);

    http_response_code(200);
?>