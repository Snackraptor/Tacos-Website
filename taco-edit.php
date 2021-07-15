<?php

session_start();
require_once 'taco-validations.php';
require_login();

//connect to db
require_once 'taco-database.php';
$conn = db_connect();

?>

<?php

include_once 'shared/top-taco.php';

//if (POST)

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    //Saving inputs into variables
    $title = trim(filter_var($_POST['title'], FILTER_SANITIZE_STRING));
    $filling = trim(filter_var($_POST['filling'], FILTER_SANITIZE_STRING));
    $salsa = $_POST['salsa'] ?? '';
    $tortilla = trim(filter_var($_POST['tortilla'], FILTER_SANITIZE_STRING));
    $id = trim(filter_var($_POST['taco_id'], FILTER_SANITIZE_NUMBER_INT));

    //Running update statement
    $sql = "UPDATE tacos SET title=:title,";
    $sql .= "filling=:filling, salsa=:salsa, tortilla=:tortilla ";
    $sql .= "WHERE taco_id=:id";

    //Creating a command object and filling parameters with form  values
    $cmd = $conn->prepare($sql);
    $cmd -> bindParam(':title', $title, PDO::PARAM_STR, 50);
    $cmd -> bindParam(':filling', $filling, PDO::PARAM_STR, 20);
    $cmd -> bindParam(':salsa', $salsa, PDO::PARAM_STR, 35);
    $cmd -> bindParam(':tortilla', $tortilla, PDO::PARAM_STR, 30);
    $cmd -> bindParam(':id', $id, PDO::PARAM_INT);

      // execute the command
      $cmd -> execute();

      header("Location: tacos-list.php");
    
    //Else if (GET)
} else if($_SERVER['REQUEST_METHOD'] == 'GET'){
    $id = filter_var($_GET['taco_id'], FILTER_SANITIZE_NUMBER_INT);

    $sql = "SELECT * FROM tacos WHERE taco_id=" . $id;
    $tacos = db_queryOne($sql, $conn);

    $title = $tacos['title'];
    $filling = $tacos['filling'];
    $salsa = $tacos['salsa'];
    $tortilla = $tacos['tortilla'];

}

?>

<!-- value="<?php// echo $title; ?>" -->

<h1 class="text-center mt-5">Edit Taco</h1>

<div class="row mt-5 justify-content-center">
    <form class="col-6 mb-5" action="taco-edit.php" method="POST">
        <div class="row mb-4">
            <label class="col-2 col-form-label fs-4" for="title">Taco Name</label>
            <div class="col-10">
                <input autofocus required class="form-control form-control-lg" value="<?php echo $title; ?>" type="text"
                    name="title">
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

                    foreach ($fillings as $eachfilling) {

                        echo "<option " . (($eachfilling["filling"] == strtolower($filling)) ? 'selected' : ' ') . " value =" . ucfirst($eachfilling["filling"]) . ">" . ucfirst($eachfilling["filling"]) . "</option>";

                    }
                    
                    ?>
                </select>
            </div>
        </div>

        <div class="row mb-4">
        <label class="col-2 col-form-label fs-4" for="salsa">Salsa Flavor</label>
            <div class="col-10">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="salsa" value="Mild Salsa Verde (Green)"
                        id="flexCheckChecked" checked>
                    <label class="form-check-label" for="salsa">
                        Mild Salsa Verde (Green)
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="salsa" value="Hot Salsa Verde (Green)"
                        id="flexCheckDefault">
                    <label class="form-check-label" for="salsa">
                        Hot Salsa Verde (Green)
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="salsa" value="Burning Salsa Rojo (Red)"
                        id="flexCheckDefault">
                    <label class="form-check-label" for="salsa">
                        Burning Salsa Rojo (Red)
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="salsa" value="Tangy Mango Salsa (Yellow)"
                        id="flexCheckDefault">
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
    <input readonly class="form-control form-control-lg" value="<?php echo $id; ?>" type="hidden" name="taco_id">
    <button class="btn btn-success btn-lg">Update Taco</button>
</div>

<?php

include_once 'shared/footer-taco.php';

?>