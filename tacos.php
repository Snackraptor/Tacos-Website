<?php

session_start();
require_once 'taco-validations.php';
require_login();

//connect to db
require_once 'taco-database.php';
$conn = db_connect();

$errors = [];

if($_SERVER['REQUEST_METHOD']=='POST'){
    //Getting form inputs
    $title = trim(filter_var($_POST['title'], FILTER_SANITIZE_STRING));
    $filling = trim(filter_var($_POST['filling'], FILTER_SANITIZE_STRING));
    $salsa = trim(filter_var($_POST['salsa'], FILTER_SANITIZE_STRING));
    $torilla = trim(filter_var($_POST['tortilla'], FILTER_SANITIZE_STRING));
    
    //Creating an associative array on the user input
    $new_taco = [];
    $new_taco['title'] = $title;
    $new_taco['filling'] = $filling;
    $new_taco['salsa'] = $salsa;
    $new_taco['tortilla'] = $tortilla;

    //Validating inputs
    $errors = validate_taco($new_taco);

    if(empty($errors)){
    try{
        // set up the SQL insert command
        $sql = "INSERT INTO tacos(title, filling, salsa, tortilla) VALUES (:title, :filling, :salsa, :tortilla)";
    
        // create a commmand object and fill the parameters with the form values
        $cmd = $conn->prepare($sql);
        $cmd -> bindParam(':title', $title, PDO::PARAM_STR, 50);
        $cmd -> bindParam(':filling', $filling, PDO::PARAM_STR, 20);
        $cmd -> bindParam(':salsa', $salsa, PDO::PARAM_STR, 35);
        $cmd -> bindParam(':tortilla', $tortilla, PDO::PARAM_STR, 30);
    
        // execute the command
        $cmd -> execute();

        header("Location: tacos-list.php");
        exit;
    } catch(Exception $e){
        header("Location: taco-error.php");
        exit;
    }
}
}

?>

<?php
$title_tag = "Add Taco";
include_once 'shared/top-taco.php';

$sql = "SELECT * FROM tacos";
$tacos = db_queryAll($sql, $conn);

?>

</div>
<h1 class="text-center mt-5">Add Custom Taco</h1>

<div class="row mt-5 justify-content-center">
    <form novalidate class="col-6 mb-5" method="POST">
        <div class="row mb-4">
            <label class="col-2 col-form-label fs-4" for="title">Taco Name</label>
            <div class="col-10">
                <input required title="Please enter a valid name with no numbers or symbols."
                    class="<?= (isset($errors['title']) ? 'is-invalid ' : ''); ?> form-control form-control-lg"
                    type="text" name="title" value="<?= $title ?? ''; ?>">
                <p class="text-danger"><?= $errors['title'] ?? ''; ?></p>
            </div>
        </div>

        <div class="row mb-4">
            <label class="col-2 col-form-label fs-4" for="filling">Select Your Filling</label>
            <div class="col-10">
                <select name="filling" id="" class="form-select form-select-lg">
                    <!-- <option value="Steak">Steak</option> -->
                    <?php

                    $sql = "SELECT filling FROM fillings ORDER BY filling";
                    $fillings = db_queryAll($sql, $conn);

                    foreach ($fillings as $filling) {

                        echo "<option value =" . ucfirst($filling["filling"]) . ">" . ucfirst($filling["filling"]) . "</option>";

                    }
                    
                    ?>
                </select>
            </div>
        </div>

        <div class="row mb-4">
            <label class="col-2 col-form-label fs-4" for="salsa">Salsa Flavor</label>
            <div class="col-10">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="salsa" value="Mild Salsa Verde (Green)"
                        id="flexRadioDefault2" checked>
                    <label class="form-check-label" for="salsa">
                        Mild Salsa Verde (Green)
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="salsa" value="Hot Salsa Verde (Green)"
                        id="flexRadioDefault">
                    <label class="form-check-label" for="salsa">
                        Hot Salsa Verde (Green)
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="salsa" value="Burning Salsa Rojo (Red)"
                        id="flexRadioDefault">
                    <label class="form-check-label" for="salsa">
                        Burning Salsa Rojo (Red)
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="salsa" value="Tangy Mango Salsa (Yellow)"
                        id="flexRadioDefault">
                    <label class="form-check-label" for="salsa">
                        Tangy Mango Salsa (Yellow)
                    </label>
                </div>
            </div>
        </div>


        <div class="row mb-4">
            <label class="col-2 col-form-label fs-4" for="tortilla">Tortilla Type</label>
            <div class="col-10">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="tortilla" id="flexRadioDefault2"
                        value="Homemade Corn Tortilla" checked>
                    <label class="form-check-label" for="tortilla">
                        Homemade Corn Tortilla
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="tortilla" id="flexRadioDefault"
                        value="Flour Tortilla">
                    <label class="form-check-label" for="tortilla">
                        Flour Tortilla
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="tortilla" id="flexRadioDefault"
                        value="Hard Shell Corn Tortilla">
                    <label class="form-check-label" for="tortilla">
                        Hard Shell Corn Tortilla
                    </label>
                </div>
            </div>
        </div>

        <div class="d-grid">
            <button class="btn btn-warning btn-lg">Submit</button>
        </div>
    </form>

    <?php

include_once 'shared/footer-taco.php';

?>