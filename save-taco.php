<?php

//connect to db
require_once 'taco-database.php';
$conn = db_connect();

?>

<?php

include_once 'shared/top-taco.php';


?>


<?php

// save form inputs into variables
$title = trim(filter_var($_POST['title'], FILTER_SANITIZE_STRING));
$filling = trim(filter_var($_POST['filling'], FILTER_SANITIZE_STRING));
$salsa = $_POST['salsa'] ?? '';
$tortilla = trim(filter_var($_POST['tortilla'], FILTER_SANITIZE_STRING));

$is_form_valid = true;

//Checking for valid inputs

if(empty(trim($title))){
    echo "Please enter a proper title.";
    $is_form_valid = false;
}

if(empty(trim($filling))){
    echo "Please enter a proper filling for your taco.";
    $is_form_valid = false;
}

if(empty(trim($salsa))){
    echo "Please select a salsa for your taco.";
    $is_form_valid = false;
}

if(empty(trim($tortilla))){
    echo "Please enter a proper tortilla for your taco.";
    $is_form_valid = false;
}

if($is_form_valid){

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

    //disconnect from the db
    $conn = null;

} catch(Exception $e){
    header("Location: taco-error.php");
}

// show message
echo "Taco Saved!";

}

?>


<?php

include_once 'shared/footer-taco.php';

?>