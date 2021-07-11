<?php

//connect to db
require_once 'taco-database.php';
$conn = db_connect();

include_once 'shared/top-taco.php';

?>

<main class="container">
    <div class="row">
        <div class="col">
            <h1 class="mt-5 pt-5">You Have Successfully Logged in!</h1>
            <p>Your login credentials have been saved!</p>
            <a href="tacos-home.php" class="btn btn-outline-primary">Back to Homepage</a>
        </div>
        <div class="col">
            <img src="img/login.svg" alt="login">
        </div>
    </div>
</main>


<?php

include_once 'shared/footer-taco.php';

?>