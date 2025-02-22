<?php
    $PROJECTROOT = $_SERVER["DOCUMENT_ROOT"] . '/..';
    require_once $PROJECTROOT . "/internal/db.php";
    if($_SERVER["REQUEST_METHOD"] == "GET"){
        $getPosSQL = "SELECT pos_id, pos_name FROM positions";
        $posRes = mysqli_query($conn, $getPosSQL);
        if(!is_bool($posRes)){
            $outputPosId = array();
            $outputPosName = array();
            $outputPosArr = array();
            $posArr = mysqli_fetch_all($posRes);
            $posArr = array_values($posArr);
            foreach($posArr as $currPos){
                array_push($outputPosId, $currPos[0]);
                array_push($outputPosName, $currPos[1]);
            }
            $outputPosArr = array(
                "posId" => $outputPosId,
                "posName" => $outputPosName,
            );
        } else {
            $posArr = array("0" => "Error");
            header('X-PHP-Response-Code: 500', true, 500);
            die();
        }

        header("Content-Type: application/json");
        echo json_encode($outputPosArr);
        die();
    }
    else {
        header('X-PHP-Response-Code: 405', true, 405);
        die();
    }
?>