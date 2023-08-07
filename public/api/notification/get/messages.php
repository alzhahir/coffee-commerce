<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    error_reporting(E_ALL);
    //ini_set('display_errors', 1);

    $ROOTPATH = $_SERVER["DOCUMENT_ROOT"] . '/..';
    require $ROOTPATH . '/internal/db.php';

    if($_SERVER["REQUEST_METHOD"] == "GET"){
        if(isset($_GET['topic']) && !isset($_GET['read'])){
            //topic
            $topic = $_GET['topic'];
            $getNotifSQL = "SELECT notif_id, notif_title, notif_message, notif_imgurl, notif_redirurl FROM notifications WHERE notif_topic = '$topic' ORDER BY notif_id DESC";
        } else if(isset($_GET['read']) && !isset($_GET['topic'])){
            //read
            $read = $_GET['read'];
            $getNotifSQL = "SELECT notif_id, notif_title, notif_message, notif_imgurl, notif_redirurl FROM notifications WHERE notif_read = '$read' ORDER BY notif_id DESC";
        } else if(isset($_GET['topic']) && isset($_GET['read'])){
            //topic and read
            $topic = $_GET['topic'];
            $read = $_GET['read'];
            $getNotifSQL = "SELECT notif_id, notif_title, notif_message, notif_imgurl, notif_redirurl FROM notifications WHERE notif_topic = '$topic' AND notif_read = '$read' ORDER BY notif_id DESC";
        } else {
            //no vals
            $getNotifSQL = "SELECT notif_id, notif_title, notif_message, notif_imgurl, notif_redirurl FROM notifications ORDER BY notif_id DESC";
        }
        $notifRes = mysqli_query($conn, $getNotifSQL);
        if(!is_bool($notifRes)){
            $outputNotifArr = array();
            $notifArr = mysqli_fetch_all($notifRes);
            $notifArr = array_values($notifArr);
            foreach($notifArr as $currNotif){
                array_push($outputNotifArr, [
                    $currNotif[0],
                    $currNotif[1],
                    $currNotif[2],
                    $currNotif[3],
                    $currNotif[4],
                ]);
            }
            $outputArr = [
                "data" => $outputNotifArr
            ];
        }
        header("Content-Type: application/json;");
        echo json_encode($outputArr, JSON_PRETTY_PRINT);
        die();
    } else {
        header('X-PHP-Response-Code: 405', true, 405);
        die();
    }

?>