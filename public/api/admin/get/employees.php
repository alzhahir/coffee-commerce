<?php
    $ROOTPATH = $_SERVER["DOCUMENT_ROOT"] . '/..';
    include($ROOTPATH . '/internal/admincontrol.php');
    require_once $ROOTPATH . "/internal/db.php";
    if($_SERVER["REQUEST_METHOD"] == "GET"){
        $getEmpSQL = "SELECT u.usr_id, e.emp_name, u.user_email, e.emp_gender FROM users AS u INNER JOIN employees AS e ON u.user_id=e.user_id";
        $empRes = mysqli_query($conn, $getEmpSQL);
        if(!is_bool($empRes)){
            $outputEmpId = array();
            $outputEmpName = array();
            $outputEmpEmail = array();
            $outputEmpGender = array();
            $outputEmpArr = array();
            $empArr = mysqli_fetch_all($empRes);
            $empArr = array_values($empArr);
            foreach($empArr as $currEmp){
                array_push($outputEmpId, $currEmp[0]);
                array_push($outputEmpName, $currEmp[1]);
                array_push($outputEmpEmail, $currEmp[2]);
                if($currEmp[3] == 0){
                    array_push($outputEmpGender, "Male");
                } else {
                    array_push($outputEmpGender, "Female");
                }
            }
            $outputEmpArr = array(
                "empId" => $outputEmpId,
                "empName" => $outputEmpName,
                "empEmail" => $outputEmpEmail,
                "empGender" => $outputEmpGender,
            );
        } else {
            $empArr = array("0" => "Error");
            header('X-PHP-Response-Code: 500', true, 500);
            die();
        }

        header("Content-Type: application/json");
        echo json_encode($outputEmpArr);
        die();
    }
    else {
        header('X-PHP-Response-Code: 405', true, 405);
        die();
    }
?>