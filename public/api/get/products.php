<?php
    $SERVERROOT = $_SERVER["DOCUMENT_ROOT"];
    $PROJECTROOT = $_SERVER["DOCUMENT_ROOT"] . '/..';
    require_once $PROJECTROOT . "/internal/db.php";
    if($_SERVER["REQUEST_METHOD"] == "GET"){
        function getCategories(int $catId, mysqli $conn){
            $getCatSQL = "SELECT cat_name FROM categories WHERE cat_id = $catId";
            $catRes = mysqli_query($conn, $getCatSQL);
            if(!is_bool($catRes)){
                $catArr = mysqli_fetch_all($catRes);
                $catArr = array_values($catArr);
                foreach($catArr as $currCat){
                    return $currCat[0];
                }
            } else {
                return null;
            }
        }

        function getCategoryID($catName, mysqli $conn){
            $getCatSQL = "SELECT cat_id FROM categories WHERE cat_name = ?";
            if ($stmt=mysqli_prepare($conn, $getCatSQL)){
                mysqli_stmt_bind_param($stmt, "s", $cat_name);
    
                $cat_name = $catName;
    
                if(mysqli_stmt_execute($stmt)){
                    $usersArray = mysqli_fetch_array(mysqli_stmt_get_result($stmt));
                    if(empty($usersArray["cat_id"]) || !isset($usersArray["cat_id"])){
                        return 0;
                    }
                    return $usersArray["cat_id"];
                    //echo "SUCCESS QUERY USERS TABLE!\n";
                } else {
                    return null;
                }
    
                mysqli_stmt_close($stmt);
            }
        }

        if(!isset($included)){
            $included = false;
            function getStatus(int $var, $included = null){
                if(isset($included)){
                    if($included){
                        return $var;
                    }
                }
                if($var == 1){
                    return "Hot";
                    /*return array(
                        "temp" => '1',
                        "hot" => true,
                        "cold" => false,
                    );*/
                } elseif($var == 2){
                    return "Cold";
                    /*return array(
                        "temp" => '2',
                        "hot" => false,
                        "cold" => true,
                    );*/
                } elseif ($var == 3) {
                    return "Hot, Cold";
                    /*return array(
                        "temp" => '3',
                        "hot" => true,
                        "cold" => true,
                    );*/
                } else {
                    return null;
                }
            };
        }
        $baseSQL = "SELECT prod_id, prod_name, prod_img_url, prod_price, prod_stock, cat_id, prod_temp FROM products";
        $getListedSQL = "is_listed = 1";
        $getUnlistedSQL = "is_listed = 0";
        $getOOSOnly = "prod_stock = 0";
        $getISOnly = "prod_stock > 0";
        $getProdSQL = $baseSQL." WHERE ".$getListedSQL;
        if(isset($_GET['in_stock']) && $_GET['in_stock'] == 'false'){
            $getProdSQL = $baseSQL." WHERE ".$getOOSOnly;
        }
        if(isset($_GET['in_stock']) && $_GET['in_stock'] == 'true'){
            $getProdSQL = $baseSQL." WHERE ".$getISOnly;
        }
        if(isset($_GET['showall']) && $_GET['showall'] == 'true'){
            $getProdSQL = $baseSQL." WHERE ".$getListedSQL;
            if(isset($_GET['in_stock']) && $_GET['in_stock'] == 'false'){
                $getProdSQL = $getProdSQL." AND ".$getOOSOnly;
            }
            if(isset($_GET['in_stock']) && $_GET['in_stock'] == 'true'){
                $getProdSQL = $getProdSQL." AND ".$getISOnly;
            }
        }
        if(isset($_GET['showall']) && $_GET['showall'] == 'false'){
            $getProdSQL = $baseSQL." WHERE ".$getUnlistedSQL;
            if(isset($_GET['in_stock']) && $_GET['in_stock'] == 'false'){
                $getProdSQL = $getProdSQL." AND ".$getOOSOnly;
            }
            if(isset($_GET['in_stock']) && $_GET['in_stock'] == 'true'){
                $getProdSQL = $getProdSQL." AND ".$getISOnly;
            }
        }
        if(isset($_GET["category"])){
            if(ctype_digit($_GET["category"])){
                $catId = $_GET["category"];
                $getProdSQL = $getProdSQL . " AND cat_id = $catId";
            } else {
                $catId = getCategoryID($_GET["category"], $conn);
                $getProdSQL = $getProdSQL . " AND cat_id = $catId";
            }
        }
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
                if(!isset($included) || !$included){
                    array_push($outputProdArr, array_values(array(
                        "id" => $currProd[0],
                        "name" => $currProd[1],
                        "imageURL" => $imgUrl,
                        "price" => $currProd[3],
                        "stock" => $currProd[4],
                        "categoryID" => $currProd[5],
                        "category" => getCategories($currProd[5], $conn),
                        "temp" => getStatus($currProd[6], $included),
                    )));
                } else {
                    array_push($outputProdArr, array_values(array(
                        "id" => $currProd[0],
                        "name" => $currProd[1],
                        "imageURL" => $imgUrl,
                        "price" => $currProd[3],
                        "stock" => $currProd[4],
                        "temp" => $currProd[6],
                        "category" => $currProd[5],
                    )));
                }
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