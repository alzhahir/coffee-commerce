<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    error_reporting(E_ALL);
    //ini_set('display_errors', 1);

    $ROOTPATH = $_SERVER["DOCUMENT_ROOT"] . '/..';
    $FIREBASE_CREDS_PATH = $ROOTPATH . '/firebase-creds.json';
    require $ROOTPATH . '/vendor/autoload.php';

    use Kreait\Firebase\Factory;
    use Kreait\Firebase\Messaging\CloudMessage;
    use Kreait\Firebase\Messaging\Notification;
    use Kreait\Firebase\Exception\Messaging\InvalidMessage;
    use GuzzleHttp\MessageFormatter;
    use Monolog\Logger;
    use Monolog\Handler\StreamHandler;

    $httpLogger = new Logger('firebase_http_logs');
    $httpLogger->pushHandler(new StreamHandler($ROOTPATH.'/logs/firebase.log', Monolog\Level::Info));

    $factory = (new Factory)->withServiceAccount($FIREBASE_CREDS_PATH);
    // Without further arguments, requests and responses will be logged with basic
    // request and response information. Successful responses will be logged with
    // the 'info' log level, failures (Status code >= 400) with 'notice'
    $factory = $factory->withHttpLogger($httpLogger);
    $messaging = $factory->createMessaging();

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $title = 'Error!';
        $body = 'This is the default message';
        $imageUrl = 'http://lorempixel.com/400/200/';
        $topicVal = "employees";

        if(isset($_POST['title']) && isset($_POST['body']) && $_POST['topic']){
            $title = $_POST['title'];
            $body = $_POST['body'];
            $imageUrl = 'https://img.icons8.com/fluency/96/services.png';
            $topicVal = $_POST['topic'];
        }

        $notification = Notification::fromArray([
            'title' => $title,
            'body' => $body,
            'image' => $imageUrl,
        ]);

        $message = CloudMessage::withTarget('topic', $topicVal)
            ->withNotification($notification)
            ->withData(['key' => 'value']);

        try {
            $messaging->send($message, $validateOnly = true);
        } catch (InvalidMessage $e) {
            print_r($e->errors());
        }

        $messaging->send($message);
    } else {
        http_response_code(405);
        die();
    }
?>