<?php

session_start();
require_once 'taco-validations.php';
require_login();

//connect to db
require_once 'taco-database.php';
$conn = db_connect();

?>

<?php

// IF this page is fetched via a GET
// Then dispaly record with confirmation button

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    $id = filter_var($_GET['taco_id'], FILTER_SANITIZE_NUMBER_INT);

    $sql = "SELECT * FROM tacos WHERE taco_id=" . $id;
    $tacos = db_queryOne($sql, $conn);

    $title = $tacos['title'];
    $filling = $tacos['filling'];
    $salsa = $tacos['salsa'];
    $tortilla = $tacos['tortilla'];
    
    $title_tag = "Delete Taco";
    include_once 'shared/top-taco.php';

?>

<h1 class="text-center mt-5">Are you sure you want to delete this taco?</h1>

<div class="row mt-5 justify-content-center">
    <form class="col-6 mb-5" method="POST">
        <div class="row mb-4">
            <label class="col-2 col-form-label fs-4" for="title">Taco Name</label>
            <div class="col-10">
                <input readonly class="form-control form-control-lg" value="<?php echo $title; ?>" type="text"
                    name="title">
            </div>
        </div>

        <div class="row mb-4">
            <label class="col-2 col-form-label fs-4" for="filling">Select Your Filling</label>
            <div class="col-10">
                <input readonly class="form-control form-control-lg" value="<?php echo $filling; ?>" type="text"
                    name="filling">
                </select>
            </div>
        </div>

        <div class="row mb-4">
            <label class="col-2 col-form-label fs-4" for="salsa">Salsa Flavor</label>
            <div class="col-10">
                <input readonly class="form-control form-control-lg" value="<?php echo $salsa; ?>" type="text"
                    name="salsa">
            </div>
        </div>

        <div class="row mb-4">
            <label class="col-2 col-form-label fs-4" for="tortilla">Tortilla Type</label>
            <div class="col-10">
                <input readonly class="form-control form-control-lg" value="<?php echo $tortilla; ?>" type="text"
                    name="tortilla">
            </div>
        </div>

        <div class="d-grid">
            <input readonly class="form-control form-control-lg" value="<?php echo $id; ?>" type="hidden"
                name="taco_id">
            <button class="btn btn-danger btn-lg">Delete forever</button>
        </div>
</div>

<?php
} else if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $id = filter_var($_POST['taco_id'], FILTER_SANITIZE_NUMBER_INT);

    // If this page is fetched via a POST
    // then go ahead and actually delete the record 
    
    $sql = "DELETE FROM tacos WHERE taco_id=" . $id;
    
    $cmd = $conn->prepare($sql);
    $cmd -> execute();
    
    header("Location: tacos-list.php?t=2&msg=Taco");
}

?>