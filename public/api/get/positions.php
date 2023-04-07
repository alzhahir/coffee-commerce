<?php
    require_once "../../../internal/db.php";

    if($_SERVER["REQUEST_METHOD"] == "GET"){
        //get clublist
        $getPosSQL = "SELECT pos_id, pos_name FROM positions";
        $posRes = mysqli_query($conn, $getPosSQL);
        if(!is_bool($clubRes)){
            $outputPosId = array();
            $outputPosName = array();
            $outputPosArr = array();
            $posArr = mysqli_fetch_all($posRes);
            $posArr = array_values($posArr);
            foreach($clubArr as $currPos){
                array_push($outputPosId, $currPos[0]);
                array_push($outputPosName, $currPos[1]);
            }
            $outputPosArr = array(
                "clubId" => $outputPosId,
                "clubName" => $outputPosName,
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
        header('X-PHP-Response-Code: 500', true, 500);
        die();
    }
?>