<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $SERVERROOT = $_SERVER["DOCUMENT_ROOT"];
    $PROJECTROOT = $_SERVER["DOCUMENT_ROOT"] . '/..';
    if(!isset($_SESSION["uid"])){
        http_response_code(401);
        include($SERVERROOT . "/error/401.php");
        die();
    }
    if(!isset($_SESSION["cust_id"])){
        http_response_code(403);
        include($SERVERROOT . "/error/403.php");
        die();
    }
    require_once $PROJECTROOT . "/internal/db.php";

    if($_SERVER["REQUEST_METHOD"] == "GET"){
        $cid = $_SESSION["cust_id"];
        $getCartSQL = "SELECT cart_id, cart_date FROM carts WHERE cust_id = $cid";
        $cartRes = mysqli_query($conn, $getCartSQL);
        $cartNum = mysqli_num_rows($cartRes);
        $noCart = false;
        if($cartNum < 1){
            $noCart = true;
            if(!isset($included) || !$included){
                $newOutputArr = array(
                    "dateCreated" => null,
                    "data" => [],
                    "isEmpty" => true,
                );
                header("Content-Type: application/json;");
                echo json_encode($newOutputArr, JSON_PRETTY_PRINT);
                die();
            }
        } else {
            if(!is_bool($cartRes)){
                $outputCartArr = array();
                $cartArr = mysqli_fetch_all($cartRes);
                $cartArr = array_values($cartArr);
                foreach($cartArr as $currCart){
                    $caid = $currCart[0];
                    $getCartItmSQL = "SELECT prod_id, cart_item_qty, cart_itm_temp FROM cart_items WHERE cart_id = $caid";
                    $cartItmRes = mysqli_query($conn, $getCartItmSQL);
                    if(!is_bool($cartItmRes)){
                        $outputItmArr = array();
                        $cartItmArr = mysqli_fetch_all($cartItmRes);
                        $cartItmArr = array_values($cartItmArr);
                        $isEmpty = false;
                        if(count($cartItmArr) === 0){
                            $isEmpty = true;
                        }
                        foreach($cartItmArr as $currItm){
                            array_push($outputItmArr, array_values(array(
                                "id" => $currItm[0],
                                "qty" => $currItm[1],
                                "tmp" => $currItm[2],
                            )));
                        }
                    } else {
                        $cartArr = array("0" => "Error");
                        header('X-PHP-Response-Code: 500', true, 500);
                        die();
                    }
                    array_push($outputCartArr, array_values(array(
                        $currCart[0],
                        $currCart[1],
                        $outputItmArr,
                    )));
                }
            } else {
                $cartArr = array("0" => "Error");
                header('X-PHP-Response-Code: 500', true, 500);
                die();
            }

            if(!isset($included) || !$included){
                $included = true;
                include($SERVERROOT . '/api/get/products.php');
                $included = false;
                $newItmArr = array();
                $newOutputArr = array();
                foreach($outputItmArr as $currItm){
                    foreach($outputProdArr as $currProd){
                        if($currItm[0] == $currProd[0]){
                            switch($currItm[2]){
                                case 1:
                                    $currItmTemp = "Hot";
                                    $currTempPrice = 0;
                                    break;
                                case 2:
                                    $currItmTemp = 'Cold <span class="badge rounded-pill bg-danger align-middle">
                                    +RM 1.00
                                    <span class="visually-hidden">Admin Mode</span>
                                </span>';
                                    $currTempPrice = 1;
                                    break;
                                default:
                                    $currItmTemp = "null";
                                    $currTempPrice = 0;
                                    break;
                            }
                            array_push($newItmArr, array_values(array(
                                "id" => $currItm[0],
                                "name" => $currProd[1],
                                "temperature" => $currItmTemp,
                                "quantity" => $currItm[1],
                                "price" => number_format($currProd[3], 2),
                                "subtotal" => number_format((($currProd[3] + $currTempPrice) * $currItm[1]), 2)
                            )));
                        }
                    }
                }
                foreach($cartArr as $currCart){
                    $newOutputArr = array(
                        "dateCreated" => $currCart[1],
                        "data" => $newItmArr,
                        "isEmpty" => $isEmpty,
                    );
                }
                header("Content-Type: application/json;");
                echo json_encode($newOutputArr, JSON_PRETTY_PRINT);
                die();
            }
        }
    }
    else {
        header('X-PHP-Response-Code: 405', true, 405);
        die();
    }
?>