<?php
    $SERVERROOT = $_SERVER["DOCUMENT_ROOT"];
    $PROJECTROOT = $_SERVER["DOCUMENT_ROOT"] . '/..';
    require_once $PROJECTROOT . "/internal/db.php";
    if($_SERVER["REQUEST_METHOD"] == "GET"){
        $getProdSQL = "SELECT prod_id, prod_name, prod_img_url, prod_price, prod_stock FROM products";
        $prodRes = mysqli_query($conn, $getProdSQL);
        if(!is_bool($prodRes)){
            $outputProdId = array();
            $outputProdName = array();
            $outputProdImg = array();
            $outputProdPrice = array();
            $outputProdStock = array();
            $outputProdArr = array();
            $prodArr = mysqli_fetch_all($prodRes);
            $prodArr = array_values($prodArr);
            foreach($prodArr as $currProd){
                array_push($outputProdId, $currProd[0]);
                array_push($outputProdName, $currProd[1]);
                array_push($outputProdImg, $currProd[2]);
                array_push($outputProdPrice, $currProd[3]);
                array_push($outputProdStock, $currProd[4]);
            }
            $outputProdArr = array(
                "id" => $outputProdId,
                "name" => $outputProdName,
                "imageURL" => $outputProdImg,
                "price" => $outputProdPrice,
                "stock" => $outputProdStock,
            );
        } else {
            $prodArr = array("0" => "Error");
            header('X-PHP-Response-Code: 500', true, 500);
            die();
        }
        
        if(!isset($included) || !$included){
            header("Content-Type: application/json;");
            echo json_encode($outputProdArr, JSON_PRETTY_PRINT);
            die();
        }
    }
    else {
        header('X-PHP-Response-Code: 405', true, 405);
        die();
    }
?>