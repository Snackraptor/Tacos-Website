<?php

//connect to db
require_once 'taco-database.php';
$conn = db_connect();

?>

<?php

include_once 'shared/top-taco.php';

$sql = "SELECT * FROM tacos";
$tacos = db_queryAll($sql, $conn);

?>

</div>
<h1 class="text-center mt-5">Add Custom Taco</h1>

<div class="row mt-5 justify-content-center">
    <form class="col-6 mb-5" action="save-taco.php" method="POST">
        <div class="row mb-4">
            <label class="col-2 col-form-label fs-4" for="title">Taco Name</label>
            <div class="col-10">
                <input required title="Please enter a valid name with no numbers or symbols."
                    class="form-control form-control-lg" type="text" name="title">
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
            <button class="btn btn-warning btn-lg">Submit</button>
        </div>
    </form>

    <?php

include_once 'shared/footer-taco.php';

?>