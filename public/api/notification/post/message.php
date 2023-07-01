<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    error_reporting(E_ALL);
    //ini_set('display_errors', 1);

    $ROOTPATH = $_SERVER["DOCUMENT_ROOT"] . '/..';
    $FIREBASE_CREDS_PATH = $ROOTPATH . '/firebase-creds.json';
    require $ROOTPATH . '/vendor/autoload.php';
    require $ROOTPATH . '/internal/db.php';

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
        $imageUrl = 'https://img.icons8.com/fluency/96/services.png';
        $topicVal = "employees";
        $redir = "#";

        if(isset($_POST['title']) && isset($_POST['body']) && $_POST['topic']){
            $title = $_POST['title'];
            $body = $_POST['body'];
            $topicVal = $_POST['topic'];
        }

        if(isset($_POST['imgurl'])){
            $imageUrl = $_POST['imgurl'];
        }

        if(isset($_POST['redirurl'])){
            $redir = $_POST['redirurl'];
        }

        $addNotifSQL = "INSERT INTO notifications (notif_title, notif_message, notif_imgurl, notif_redirurl, notif_topic) VALUES (?, ?, ? ,? ,?)";
        if($stmt=mysqli_prepare($conn, $addNotifSQL)){
            mysqli_stmt_bind_param($stmt, "sssss", $notif_title, $notif_message, $notif_imgurl, $notif_redirurl, $notif_topic);

            $notif_title = $title;
            $notif_message = $body;
            $notif_imgurl = $imageUrl;
            $notif_redirurl = $redir;
            $notif_topic = $topicVal;

            if(!mysqli_stmt_execute($stmt)){
                mysqli_stmt_close($stmt);
                http_response_code(500);
                die();
            }
            mysqli_stmt_close($stmt);
        } else {
            http_response_code(500);
            die();
        }

        $notifId = mysqli_insert_id($conn);

        $notification = Notification::fromArray([
            'title' => $title,
            'body' => $body,
            'image' => $imageUrl,
        ]);

        $message = CloudMessage::withTarget('topic', $topicVal)
            ->withNotification($notification)
            ->withData([
                'redirect' => $redir,
                'id' => $notifId,
                'click_action' => '/'
        ]);

        try {
            $messaging->send($message, $validateOnly = true);
        } catch (InvalidMessage $e) {
            print_r($e->errors());
        }

        $messaging->send($message);
        http_response_code(200);
        die();
    } else {
        http_response_code(405);
        die();
    }
?>