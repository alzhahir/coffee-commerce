<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    error_reporting(E_ALL);

    $ROOTPATH = $_SERVER["DOCUMENT_ROOT"] . '/..';
    require_once $ROOTPATH . "/internal/db.php";

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST['id'])){
            $notifId = $_POST['id'];
        } else {
            http_response_code(400);
            die();
        }

        $updateReadSQL = "UPDATE notifications SET notif_read = ? WHERE notif_id = ?";
        if($stmt=mysqli_prepare($conn, $updateReadSQL)){
            mysqli_stmt_bind_param($stmt, 'ii', $notif_read, $notif_id);

            $notif_read = 1;
            $notif_id = $notifId;
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
    } else {
        http_response_code(405);
        die();
    }

?>