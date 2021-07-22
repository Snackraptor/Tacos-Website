<?php

session_start();
require_once 'taco-validations.php';
require_login();

//connect to db
require_once 'taco-database.php';
$conn = db_connect();

?>

<?php
$title_tag = "Main Page";
include_once 'shared/top-taco.php';

?>

<img src="img/taco.jpg" class="img-fluid" alt="">

<?php

include_once 'shared/footer-taco.php';

?>