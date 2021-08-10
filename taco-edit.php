<?php

session_start();
require_once 'taco-validations.php';
require_login();

//connect to db
require_once 'taco-database.php';
$conn = db_connect();

?>

<?php
$title_tag = "Edit Taco";
include_once 'shared/top-taco.php';

$errors = [];

//if (POST)
if($_SERVER['REQUEST_METHOD'] == 'POST') {

    //Saving inputs into variables
    $title = trim(filter_var($_POST['title'], FILTER_SANITIZE_STRING));
    $filling = trim(filter_var($_POST['filling'], FILTER_SANITIZE_STRING));
    $salsa = trim(filter_var($_POST['salsa'], FILTER_SANITIZE_STRING));
    $tortilla = trim(filter_var($_POST['tortilla'], FILTER_SANITIZE_STRING));
    $id = trim(filter_var($_POST['taco_id'], FILTER_SANITIZE_NUMBER_INT));

    //Img file input
    $name = $_FILES['photo']['name'];
    $tmp_name = $_FILES['photo']['tmp_name'];
    $type = mime_content_type($tmp_name);
    $size = $_FILES['photo']['size'];

    //Error checking
    $edit_taco = [];
    $edit_taco['title'] = $title;
    $edit_taco['filling'] = $filling;
    $edit_taco['salsa'] = $salsa;
    $edit_taco['tortilla'] = $tortilla;
    $edit_taco['type'] = $type;
    $edit_taco['size'] = $size;
    
    //Validating the inputs
    $errors = validate_taco($edit_taco);

    //Running update statement
    if (empty($errors)){
    try{

        $pic = substr(session_id(), 2, 7) . $name;
        move_uploaded_file($tmp_name, "uploads/" . $pic);

        $sql = "UPDATE tacos SET title=:title,";
        $sql .= "filling=:filling, salsa=:salsa, tortilla=:tortilla, photo=:photo ";
        $sql .= "WHERE taco_id=:id";

        //Creating a command object and filling parameters with form  values
        $cmd = $conn->prepare($sql);
        $cmd -> bindParam(':title', $title, PDO::PARAM_STR, 50);
        $cmd -> bindParam(':filling', $filling, PDO::PARAM_STR, 20);
        $cmd -> bindParam(':salsa', $salsa, PDO::PARAM_STR, 35);
        $cmd -> bindParam(':tortilla', $tortilla, PDO::PARAM_STR, 30);
        $cmd -> bindParam(':id', $id, PDO::PARAM_INT);
        $cmd -> bindParam(':photo', $pic, PDO::PARAM_STR, 100);

        // execute the command
        $cmd -> execute();

      header("Location: tacos-list.php?t=3&msg=Taco");
      exit;
    } catch(Exception $e){
        header("Location: taco-error.php");
        exit;
    }
}
    
    //Else if (GET)
} else if($_SERVER['REQUEST_METHOD'] == 'GET'){
    $id = filter_var($_GET['taco_id'], FILTER_SANITIZE_NUMBER_INT);

    $sql = "SELECT * FROM tacos WHERE taco_id=" . $id;
    $tacos = db_queryOne($sql, $conn);

    $title = $tacos['title'];
    $filling = $tacos['filling'];
    $salsa = $tacos['salsa'];
    $tortilla = $tacos['tortilla'];
    $pic = $tacos['photo'];

}

?>

<h1 class="text-center mt-5">Edit Taco</h1>

<div class="row mt-5 ms-1">
    <form novalidate class="row justify-content-center mb-5" method="POST" enctype="multipart/form-data">
        <div class="col-12 col-md-6">

            <div class="row mb-4">
                <div class="col">
                    <div class="form-floating mb-3">
                        <input autofocus required title="Please enter a valid name with no numbers or symbols."
                            class="<?= (isset($errors['title']) ? 'is-invalid ' : ''); ?> form-control form-control-lg"
                            type="text" name="title" placeholder="Title" value="<?= $title ?? ''; ?>">
                        <label class="col-form-label" for="title">Taco Name</label>
                        <p class="text-danger"><?= $errors['title'] ?? ''; ?></p>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col">
                    <div class="form-floating">
                        <select name="filling" id="filling" class="form-select form-select-lg" style="height:70px;">
                            <!-- <option value="Steak">Steak</option> -->
                            <?php
                        $sql = "SELECT filling FROM fillings ORDER BY filling";
                        $fillings = db_queryAll($sql, $conn);
                        
                        foreach ($fillings as $eachfilling) {
                            echo "<option " . (($eachfilling["filling"] == strtolower($filling)) ? 'selected' : ' ') . " value =" . ucfirst($eachfilling["filling"]) . ">" . ucfirst($eachfilling["filling"]) . "</option>";
                        }
                        ?>
                        </select>
                        <label class="col-form-label" for="filling">Taco Filling</label>
                    </div>
                </div>
            </div>

            <!-- Edit Salsa -->
            <div class="row mb-4">
                <div class="col">
                    <label class="col-2 col-form-label fs-4" for="salsa">Salsa Flavor</label>
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

            <!-- Tortilla edit -->
            <div class="row mb-4">
                <div class="col">
                    <label class="col-2 col-form-label fs-4" for="tortilla">Tortilla Type</label>
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
        </div>

        <div class="col-12 col-sm-3 mb-5">
            <div class="card">
                <img id="cover" src="<?= (isset($pic)) ? ("./uploads/" . $pic) : "https://dummyimage.com/300x225" ?>"
                    class="card-img-top" alt="taco cover">

                <div class="card-body">
                    <input id="choosefile" type="file" name="photo" class="form-control">
                </div>
                <p class="px-3 pb-2 text-danger"><?= $errors['photo'] ?? ''; ?></p>

            </div>
        </div>

        <div class="row justify-contnet-center col-12 col-md-9">
            <input readonly class="form-control form-control-lg" value="<?php echo $id; ?>" type="hidden"
                name="taco_id">
            <button class="btn btn-success btn-lg">Update Taco</button>
        </div>

        <!-- Javascript entered here to process images -->
<script>
function handleFileSelect(evt) {
    const reader = new FileReader();

    reader.addEventListener('load', (e) => {
        cover.src = e.target.result;
        console.log(e.target.result);
    })

    reader.readAsDataURL(evt.target.files[0]);
}

choosefile.addEventListener('change', handleFileSelect);
</script>

<?php

$t = filter_var($_GET['t'] ?? '', FILTER_SANITIZE_STRING);
$msg = filter_var($_GET['msg'] ?? '', FILTER_SANITIZE_STRING);
display_toast($t, $msg);

include_once 'shared/footer-taco.php';

?>