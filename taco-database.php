<?php
require_once 'db_cred.php';

function db_queryAll($sql, $conn, $word_list = []) {
    try{
        //run query and store the results
        $cmd = $conn->prepare($sql);
        $cmd -> execute($word_list);
        $tacos = $cmd->fetchAll();
        return $tacos;
    }catch(Exception $e){
        //mail('lionel.pineda@mygeorgian.ca', 'PDO Error', $e);
        header("Location: taco-error.php");
    }
    
}


function db_queryOne($sql, $conn) {
    try{
        //run query and store the results
        $cmd = $conn->prepare($sql);
        $cmd -> execute();
        $tacos = $cmd->fetch();
        return $tacos;
    }catch (Exception $e){
        header("Location: taco-error.php");
    }
}

function db_connect() {

    $conn = new PDO('mysql:host=' . DB_SERVER . ';dbname=' . DB_USER, DB_NAME, DB_PASS);
    $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $conn;

}

function db_disconnect($conn){
    if (isset($conn)){
        //disconnect
        $conn = null;
    }
}

?>