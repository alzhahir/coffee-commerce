<?php
    $SERVERROOT = $_SERVER["DOCUMENT_ROOT"];
    $PROJECTROOT = $_SERVER["DOCUMENT_ROOT"] . '/..';
    require_once $PROJECTROOT . "/internal/db.php";
    if($_SERVER["REQUEST_METHOD"] == "GET"){
        $getAll = "WHERE is_listed = 1";
        if(isset($_GET['showall']) && $_GET['showall'] == 'true'){
            $getAll = "";
        }
        $getCatSQL = "SELECT cat_id, cat_name, cat_image FROM categories ".$getAll;
        $catRes = mysqli_query($conn, $getCatSQL);
        if(!is_bool($catRes)){
            $outputCatArr = array();
            $catArr = mysqli_fetch_all($catRes);
            $catArr = array_values($catArr);
            foreach($catArr as $currCat){
                $imgUrl = $currCat[2];
                if($currCat[2] == null){
                    $imgUrl = null;
                }
                if(!isset($included) || !$included){
                    array_push($outputCatArr, array_values(array(
                        "id" => $currCat[0],
                        "name" => $currCat[1],
                        "imageURL" => $imgUrl,
                    )));
                } else {
                    array_push($outputCatArr, array_values(array(
                        "id" => $currCat[0],
                        "name" => $currCat[1],
                        "imageURL" => $imgUrl,
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
            echo json_encode(array("data" => $outputCatArr), JSON_PRETTY_PRINT);
            die();
        }
    }
    else {
        header('X-PHP-Response-Code: 405', true, 405);
        die();
    }
?>