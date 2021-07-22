<?php

session_start();
require_once 'taco-validations.php';
require_login();

//connect to db
require_once 'taco-database.php';
$conn = db_connect();

$title_tag = "Taco 404";
include_once 'shared/top-taco.php';

?>

<main class="container">
    <div class="row">
        <div class="col">
            <h1 class="mt-5 pt-5">There's Nothing Here</h1>
            <p>Unfortunately the page has not been found. It may have been relocated or renamed.</p>
            <a href="tacos-home.php" class="btn btn-outline-primary">Back to Homepage</a>
        </div>
        <div class="col">
            <img src="img/404.png" alt="404 error">
        </div>
    </div>
</main>


<?php

include_once 'shared/footer-taco.php';

?>