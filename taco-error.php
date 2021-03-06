<?php

session_start();
require_once 'taco-validations.php';
require_login();

//connect to db
require_once 'taco-database.php';
$conn = db_connect();

$title_tag = "Taco Error";
include_once 'shared/top-taco.php';

?>

<main class="container">
    <div class="row">
        <div class="col">
            <h1 class="mt-5 pt-5">Our apologies!</h1>
            <p>Something unexpected just happened. Our support team has been notified and will get right on it!</p>
            <a href="tacos-home.php" class="btn btn-outline-primary">Back to Homepage</a>
        </div>
        <div class="col">
            <!-- Change image-->
            <img src="img/error.png" alt="unexpected error" style="width: 800px">
        </div>
    </div>
</main>

<?php

include_once 'shared/footer-taco.php';

?>