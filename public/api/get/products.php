<?php
    $SERVERROOT = $_SERVER["DOCUMENT_ROOT"];
    $PROJECTROOT = $_SERVER["DOCUMENT_ROOT"] . '/..';
    require_once $PROJECTROOT . "/internal/db.php";
    if($_SERVER["REQUEST_METHOD"] == "GET"){
        $getProdSQL = "SELECT prod_id, prod_name, prod_img_url, prod_price, prod_stock FROM products";
        $prodRes = mysqli_query($conn, $getProdSQL);
        if(!is_bool($prodRes)){
            $outputProdArr = array();
            $prodArr = mysqli_fetch_all($prodRes);
            $prodArr = array_values($prodArr);
            foreach($prodArr as $currProd){
                $imgUrl = $currProd[2];
                if($currProd[2] == null){
                    $imgUrl = null;
                }
                array_push($outputProdArr, array_values(array(
                    "id" => $currProd[0],
                    "name" => $currProd[1],
                    "imageURL" => $imgUrl,
                    "price" => $currProd[3],
                    "stock" => $currProd[4],
                )));
            }
        } else {
            $prodArr = array("0" => "Error");
            header('X-PHP-Response-Code: 500', true, 500);
            die();
        }
        
        if(!isset($included) || !$included){
            header("Content-Type: application/json;");
            echo json_encode(array("data" => $outputProdArr), JSON_PRETTY_PRINT);
            die();
        }
    }
    else {
        header('X-PHP-Response-Code: 405', true, 405);
        die();
    }
?>