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

    $factory = (new Factory)->withServiceAccount($FIREBASE_CREDS_PATH);
    $messaging = $factory->createMessaging();

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST['registrationToken']) && isset($_POST['topic'])){
            $topicVal = $_POST['topic'];
            $registrationToken = $_POST['registrationToken'];
            $res = $messaging->unsubscribeFromAllTopics($registrationToken);
            if(isset($_SESSION['utype']) && $_SESSION['utype'] == 'admin'){
                $topicVals = [$_POST['topic'], 'staff'];
                $res = $messaging->subscribeToTopics($topicVals, $registrationToken);
                $_SESSION['notiftopic'] = $topicVals;
            } else {
                $res = $messaging->subscribeToTopic($topicVal, $registrationToken);
                $_SESSION['notiftopic'] = $topicVal;
            }
            header("Content-Type: application/json");
            echo json_encode([
                'topic'=> $topicVal,
                'registrationToken' => $registrationToken,
                'topicConfirmation' => $res
            ]);
        } else {
            http_response_code(500);
            die();
        }
    } else {
        http_response_code(405);
        die();
    }
?>