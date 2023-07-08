<?php
    $ROOTPATH = $_SERVER["DOCUMENT_ROOT"] . '/..';
    include($ROOTPATH . '/internal/admincontrol.php');
    require_once $ROOTPATH . "/internal/db.php";
    if($_SERVER["REQUEST_METHOD"] == "GET"){
        if(isset($_GET['type'])){
            switch($_GET['type']){
                case 'employees':
                    $getEmpSQL = "SELECT u.user_id, e.emp_id, e.emp_name, u.user_email, e.emp_gender FROM users AS u INNER JOIN employees AS e ON u.user_id=e.user_id";
                    $empRes = mysqli_query($conn, $getEmpSQL);
                    if(!is_bool($empRes)){
                        $outputEmpArr = array();
                        $empArr = mysqli_fetch_all($empRes);
                        $empArr = array_values($empArr);
                        foreach($empArr as $currEmp){
                            if($currEmp[4] == 0){
                                $empGender = "Male";
                            } else {
                                $empGender = "Female";
                            }
                            array_push($outputEmpArr, array_values([
                                "userId" => $currEmp[0],
                                "empId" => $currEmp[1],
                                "empName" => $currEmp[2],
                                "empEmail" => $currEmp[3],
                                "empGender" => $empGender,
                            ]));
                        }
                        $outputArr = [
                            "data" => $outputEmpArr,
                        ];
                    }
                    break;
                case 'admin':
                    $getAdmSQL = "SELECT u.user_id, e.emp_id, e.emp_name, u.user_email, e.emp_gender FROM users AS u INNER JOIN employees AS e ON u.user_id=e.user_id WHERE u.user_type = 2";
                    $admRes = mysqli_query($conn, $getAdmSQL);
                    if(!is_bool($admRes)){
                        $outputAdmArr = array();
                        $admArr = mysqli_fetch_all($admRes);
                        $admArr = array_values($admArr);
                        foreach($admArr as $currAdm){
                            if($currAdm[4] == 0){
                                $admGender = "Male";
                            } else {
                                $admGender = "Female";
                            }
                            array_push($outputAdmArr, array_values([
                                "userId" => $currAdm[0],
                                "empId" => $currAdm[1],
                                "empName" => $currAdm[2],
                                "empEmail" => $currAdm[3],
                                "empGender" => $admGender,
                            ]));
                        }
                        $outputArr = [
                            "data" => $outputAdmArr,
                        ];
                    }
                    break;
                case 'staff':
                    $getStaSQL = "SELECT u.user_id, e.emp_id, e.emp_name, u.user_email, e.emp_gender FROM users AS u INNER JOIN employees AS e ON u.user_id=e.user_id WHERE u.user_type = 1";
                    $staRes = mysqli_query($conn, $getStaSQL);
                    if(!is_bool($staRes)){
                        $outputStaArr = array();
                        $staArr = mysqli_fetch_all($staRes);
                        $staArr = array_values($staArr);
                        foreach($staArr as $currSta){
                            if($currSta[4] == 0){
                                $staGender = "Male";
                            } else {
                                $staGender = "Female";
                            }
                            array_push($outputStaArr, array_values([
                                "userId" => $currSta[0],
                                "empId" => $currSta[1],
                                "empName" => $currSta[2],
                                "empEmail" => $currSta[3],
                                "empGender" => $staGender,
                            ]));
                        }
                        $outputArr = [
                            "data" => $outputStaArr,
                        ];
                    }
                    break;
                case 'customer':
                    $getCustSQL = "SELECT u.user_id, c.cust_id, c.cust_name, u.user_email, c.cust_gender FROM users AS u INNER JOIN customers AS c ON u.user_id=c.user_id";
                    $custRes = mysqli_query($conn, $getCustSQL);
                    if(!is_bool($custRes)){
                        $outputCustArr = array();
                        $custArr = mysqli_fetch_all($custRes);
                        $custArr = array_values($custArr);
                        foreach($custArr as $currCust){
                            $custGender = null;
                            if($currCust[4] == 0){
                                $custGender = "Male";
                            } else {
                                $custGender = "Female";
                            }
                            array_push($outputCustArr, array_values([
                                "userId" => $currCust[0],
                                "custId" => $currCust[1],
                                "custName" => $currCust[2],
                                "custEmail" => $currCust[3],
                                "custGender" => $custGender,
                            ]));
                        }
                        $outputArr = [
                            'data' => $outputCustArr,
                        ];
                    } else {
                        $custArr = array("0" => "Error");
                        header('X-PHP-Response-Code: 500', true, 500);
                        die();
                    }
                    break;
                default:
                    $outputArr = [
                        "data" => ['0'],
                    ];
                    break;
            }
        } else {
            $getUserSQL = "SELECT user_id, user_email, user_type FROM users";
            $usrRes = mysqli_query($conn, $getUserSQL);
            if(!is_bool($usrRes)){
                $outputUsrArr = array();
                $usrArr = mysqli_fetch_all($usrRes);
                $usrArr = array_values($usrArr);
                foreach($usrArr as $currUsr){
                    $roleSQL = null;
                    switch($currUsr[2]){
                        case 0:
                            $roleSQL = "SELECT cust_id, cust_name, cust_gender FROM customers WHERE user_id = $currUsr[0]";
                            break;
                        case 1:
                        case 2:
                            $roleSQL = "SELECT emp_id, emp_name, emp_gender FROM employees WHERE user_id = $currUsr[0]";
                            break;
                        default:
                            break;
                    }
                    if(isset($roleSQL)){
                        $roleRes = mysqli_query($conn, $roleSQL);
                        if(!is_bool($roleRes)){
                            $roleArr = mysqli_fetch_all($roleRes);
                            $roleArr = array_values($roleArr);
                            foreach($roleArr as $thisRole){
                                $roleId = $thisRole[0];
                                $roleName = $thisRole[1];
                                $roleGender = null;
                                switch($thisRole[2]){
                                    case 0:
                                        $roleGender = "Male";
                                        break;
                                    case 1:
                                        $roleGender = "Female";
                                        break;
                                    default:
                                        break;
                                }
                            }
                        }
                        array_push($outputUsrArr, array_values([
                            "uid" => $currUsr[0],
                            "roleId" => $roleId,
                            "name" => $roleName,
                            "email" => $currUsr[1],
                            "gender" => $roleGender,
                        ]));
                    } else {
                        $outputUsrArr = [
                            '0'
                        ];
                    }
                }
                $outputArr = [
                    "data" => $outputUsrArr,
                ];
            } else {
                $empArr = array("0" => "Error");
                header('X-PHP-Response-Code: 500', true, 500);
                die();
            }
        }
        
        header("Content-Type: application/json");
        echo json_encode($outputArr);
        die();
    }
    else {
        header('X-PHP-Response-Code: 405', true, 405);
        die();
    }
?>