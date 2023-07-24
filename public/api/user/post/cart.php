<?php
    session_start();
    $ROOTPATH = $_SERVER["DOCUMENT_ROOT"] . '/..';
    include($ROOTPATH . '/internal/custcontrol.php');
    require_once $ROOTPATH . "/internal/db.php";

    $backPage = $_SESSION["backPage"];

    if(!isset($_SESSION["backPage"])){
        //backPage is not set, defaulting to index.php
        $backPage = "/index.php";
    }

    error_reporting(E_ALL);
    //ini_set('display_errors', 1);

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST["value"])){
            $productId = $_POST["value"];
            $custId = $_SESSION["cust_id"];
            $prodQty = 1;
            $prodTemp = 1;
        } else {
            http_response_code(400);
            die();
        }

        if(isset($_POST["temperature"])){
            $prodTemp = $_POST["temperature"];
        }

        if(isset($_POST["quantity"])){
            $prodQty = $_POST["quantity"];
        }

        $testCartSQL = "SELECT * FROM carts WHERE cust_id = $custId";
        $testCartRes = mysqli_query($conn, $testCartSQL);
        if(!is_bool($testCartRes)){
            if(mysqli_num_rows($testCartRes) != 0){
                $testCartArr = mysqli_fetch_all($testCartRes);
                $testCartArr = array_values($testCartArr);
                foreach($testCartArr as $currCart){
                    $caid = $currCart[0];
                }
            }
        } else {
            http_response_code(500);
            die();
        }

        if(!isset($caid)){
            $addCartSQL = "INSERT INTO carts (cart_date, cust_id) VALUES (?, ?)";
            if ($stmt=mysqli_prepare($conn, $addCartSQL)){
                mysqli_stmt_bind_param($stmt, "ss", $cart_date, $cust_id);

                $cart_date = date('Y-m-d');
                $cust_id = $custId;

                if(mysqli_stmt_execute($stmt)){
                    //
                } else {
                    mysqli_stmt_close($stmt);
                    http_response_code(500);
                    die();
                }

                mysqli_stmt_close($stmt);
            }

            $getCartSQL = "SELECT cart_id FROM carts WHERE cust_id = $custId";
            $cartRes = mysqli_query($conn, $getCartSQL);
            if(!is_bool($cartRes)){
                $cartArr = mysqli_fetch_all($cartRes);
                $cartArr = array_values($cartArr);
                foreach($cartArr as $currCart){
                    $caid = $currCart[0];
                }
            } else {
                http_response_code(500);
                die();
            }
        }

        $testItmSQL = "SELECT * FROM cart_items WHERE prod_id = $productId AND cart_id = $caid AND cart_itm_temp = $prodTemp";
        $itmRes = mysqli_query($conn, $testItmSQL);
        if(!is_bool($itmRes)){
            if(mysqli_num_rows($itmRes) < 1){
                $addCartItmSQL = "INSERT INTO cart_items (cart_id, prod_id, cart_itm_temp, cart_item_qty) VALUES (?, ?, ?, ?)";
                if ($stmt=mysqli_prepare($conn, $addCartItmSQL)){
                    mysqli_stmt_bind_param($stmt, "iiii", $cart_id, $prod_id, $cart_itm_temp, $cart_item_qty);

                    $cart_id = $caid;
                    $prod_id = $productId;
                    $cart_itm_temp = $prodTemp;
                    $cart_item_qty = $prodQty;

                    if(mysqli_stmt_execute($stmt)){
                        mysqli_stmt_close($stmt);
                        http_response_code(200);
                        exit();
                    } else {
                        mysqli_stmt_close($stmt);
                        http_response_code(500);
                        die();
                    }
                }
            } else {
                $getQtySQL = "SELECT cart_item_qty FROM cart_items WHERE prod_id = $productId AND cart_id = $caid AND cart_itm_temp = $prodTemp";
                $qtyRes = mysqli_query($conn, $getQtySQL);
                if(!is_bool($qtyRes)){
                    $qtyArr = mysqli_fetch_all($qtyRes);
                    $qtyArr = array_values($qtyArr);
                    foreach($qtyArr as $currItmQty){
                        $currQty = $currItmQty[0];
                    }
                } else {
                    http_response_code(500);
                    die();
                }

                if(isset($_POST['quantity']) && $_POST['quantity'] < 1){
                    $delCartItm = "DELETE FROM cart_items WHERE cart_id = ? AND prod_id = ? AND cart_itm_temp = ?";
                    if ($stmt=mysqli_prepare($conn, $delCartItm)){
                        mysqli_stmt_bind_param($stmt, "iii", $cart_id, $prod_id, $cart_itm_temp);
    
                        $cart_id = $caid;
                        $prod_id = $productId;
                        $cart_itm_temp = $prodTemp;
    
                        if(mysqli_stmt_execute($stmt)){
                            $getCartItm = "SELECT * FROM cart_items WHERE prod_id = $productId AND cart_id = $caid";
                            $getCartItmRes = mysqli_query($conn, $getCartItm);
                            if(!is_bool($getCartItmRes)){
                                $cartItmNum = mysqli_num_rows($getCartItmRes);
                                error_log($cartItmNum);
                                if($cartItmNum < 1){
                                    $delCartSQL = "DELETE FROM carts WHERE cust_id = ?";
                                    if ($stmt=mysqli_prepare($conn, $delCartSQL)){
                                        mysqli_stmt_bind_param($stmt, "s", $cust_id);
                    
                                        $cust_id = $custId;
                    
                                        if(mysqli_stmt_execute($stmt)){
                                            mysqli_stmt_close($stmt);
                                            http_response_code(200);
                                            exit();
                                        } else {
                                            mysqli_stmt_close($stmt);
                                            http_response_code(500);
                                            die();
                                        }
                                    }
                                } else {
                                    mysqli_stmt_close($stmt);
                                    http_response_code(200);
                                    exit();
                                }
                            } else {
                                http_response_code(500);
                                die();
                            }
                        } else {
                            mysqli_stmt_close($stmt);
                            http_response_code(500);
                            die();
                        }
    
                        //mysqli_stmt_close($stmt);
                    }
                } else if(isset($currQty)){
                    $addCartItmSQL = "UPDATE cart_items SET cart_item_qty = ? WHERE prod_id = $productId AND cart_id = $caid AND cart_itm_temp = $prodTemp";
                    if ($stmt=mysqli_prepare($conn, $addCartItmSQL)){
                        mysqli_stmt_bind_param($stmt, "s", $cart_item_qty);

                        $cart_item_qty = $currQty + $prodQty;
                        if(isset($_POST["quantity"])){
                            $prodQty = $_POST["quantity"];
                            $cart_item_qty = $prodQty;
                        }

                        if(mysqli_stmt_execute($stmt)){
                            mysqli_stmt_close($stmt);
                            http_response_code(200);
                            exit();
                        } else {
                            mysqli_stmt_close($stmt);
                            http_response_code(500);
                            die();
                        }
                    }
                } else {
                    http_response_code(500);
                    die();
                }
            }
        } else {
            http_response_code(500);
            die();
        }

        http_response_code(200);
        die();
    }
?>