<?php

//connect to db
require_once 'taco-database.php';
$conn = db_connect();

?>

</div>

<footer>
    <div class="container-fluid">
        <div class="card">
            <div class="card-body bg-dark text-light py-5">
                <div class="row">
                    <p class="col text-center">&copy; 2021 | COMP1006 | LP</p>
                </div>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous">
</script>
</body>

</html>

<?php

db_disconnect($conn);

?>