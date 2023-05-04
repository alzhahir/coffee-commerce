<?php
    $PROJECTROOT = $_SERVER["DOCUMENT_ROOT"] . '/..';
    require_once $PROJECTROOT . "/internal/db.php";
    if($_SERVER["REQUEST_METHOD"] == "GET"){
        $getCustSQL = "SELECT c.cust_id, c.cust_name, u.user_email, c.cust_gender FROM users AS u INNER JOIN customers AS c ON u.user_id=c.user_id";
        $custRes = mysqli_query($conn, $getCustSQL);
        if(!is_bool($custRes)){
            $outputCustId = array();
            $outputCustName = array();
            $outputCustEmail = array();
            $outputCustGender = array();
            $outputCustArr = array();
            $custArr = mysqli_fetch_all($custRes);
            $custArr = array_values($custArr);
            foreach($custArr as $currCust){
                array_push($outputCustId, $currCust[0]);
                array_push($outputCustName, $currCust[1]);
                array_push($outputCustEmail, $currCust[2]);
                if($currCust[3] == 0){
                    array_push($outputCustGender, "Male");
                } else {
                    array_push($outputCustGender, "Female");
                }
            }
            $outputCustArr = array(
                "custId" => $outputCustId,
                "custName" => $outputCustName,
                "custEmail" => $outputCustEmail,
                "custGender" => $outputCustGender,
            );
        } else {
            $custArr = array("0" => "Error");
            header('X-PHP-Response-Code: 500', true, 500);
            die();
        }

        header("Content-Type: application/json");
        echo json_encode($outputCustArr);
        die();
    }
    else {
        header('X-PHP-Response-Code: 405', true, 405);
        die();
    }
?>