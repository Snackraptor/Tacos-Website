<?php

//REST API
//Allow javascript to access data
header("Access-Control-Allow-Origin: *");

//connect to db
require_once '../taco-database.php';
$conn = db_connect();

$sql = "SELECT * FROM tacos ORDER BY title";

$cmd = $conn -> prepare($sql);
$cmd -> execute();
$tacos = $cmd -> fetchAll(PDO::FETCH_ASSOC);

function insert_image_urls($object) {
    if (isset($object['photo'])) {
        //The URL must be updated before uploading to FTP
        // LINK for LOCAL: http://localhost/website1/uploads/  --- https://lamp.computerstudi.es/~Lionel200390096/COMP%201006/Website1/uploads/
       $object['photo'] = "https://lamp.computerstudi.es/~Lionel200390096/COMP%201006/Website1/uploads/" . $object['photo'];
    } else {
        $object['photo'] = null;
    }
    return $object;
}

$tacos2 = array_map('insert_image_urls', $tacos);

echo json_encode($tacos2);

?>