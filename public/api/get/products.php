<?php
    require_once "../../../internal/db.php";
    if($_SERVER["REQUEST_METHOD"] == "GET"){
        $getProdSQL = "SELECT prod_id, prod_name, prod_price, prod_stock FROM products";
        $prodRes = mysqli_query($conn, $getProdSQL);
        if(!is_bool($prodRes)){
            $outputProdId = array();
            $outputProdName = array();
            $outputProdPrice = array();
            $outputProdStock = array();
            $outputProdArr = array();
            $prodArr = mysqli_fetch_all($prodRes);
            $prodArr = array_values($prodArr);
            foreach($prodArr as $currProd){
                array_push($outputProdId, $currProd[0]);
                array_push($outputProdName, $currProd[1]);
                array_push($outputProdPrice, $currProd[1]);
                array_push($outputProdStock, $currProd[1]);
            }
            $outputProdArr = array(
                "prodId" => $outputProdId,
                "prodName" => $outputProdName,
                "prodPrice" => $outputProdPrice,
                "prodStock" => $outputProdStock,
            );
        } else {
            $prodArr = array("0" => "Error");
            header('X-PHP-Response-Code: 500', true, 500);
            die();
        }

        header("Content-Type: application/json");
        echo json_encode($outputProdArr);
        die();
    }
    else {
        header('X-PHP-Response-Code: 403', true, 500);
        die();
    }
?>