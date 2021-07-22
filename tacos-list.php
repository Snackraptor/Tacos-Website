<?php

session_start();
require_once 'taco-validations.php';

//connect to db
require_once 'taco-database.php';
$conn = db_connect();

?>

<?php
$title_tag = "Taco List";
include_once 'shared/top-taco.php';

//build a sql query
$sql = "SELECT * FROM tacos";
$tacos = db_queryAll($sql, $conn);

?>

<table class="table table-dark table-bordered border-secondary fs-5 mt-4">
    <thead>
        <tr>
            <th scope="col">Taco Name</th>
            <th scope="col">Filling</th>
            <th scope="col">Salsa</th>
            <th scope="col">Tortilla</th>
            <?php if(is_logged_in()) { ?>
            <th scope="col" class="col-1">Edit</th>
            <th scope="col" class="col-1">Delete</th>
            <?php } ?>
        </tr>
    </thead>
    <tbody>

        <?php foreach($tacos as $taco){ ?>
        <tr>
            <th scope="row"><?php echo $taco['title']; ?></th>
            <td><?php echo $taco['filling']; ?></td>
            <td><?php echo $taco['salsa']; ?></td>
            <td><?php echo $taco['tortilla']; ?></td>
            <?php if(is_logged_in()) { ?>
            <td><a href="taco-edit.php?taco_id=<?php echo $taco['taco_id']; ?>" class="btn btn-info">Edit <i
                        class="bi bi-pencil-square"></i></a>
            </td>
            <td><a href="tacos-delete.php?taco_id=<?php echo $taco['taco_id']; ?>" class="btn btn-danger"><span
                        class="visually-hidden">Delete</span> <i class="bi bi-trash"></i></a>
            </td>
            <?php } ?>
        </tr>
        <?php } ?>
    </tbody>
</table>


<?php

include_once 'shared/footer-taco.php';

?>