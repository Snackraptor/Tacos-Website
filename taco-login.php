<?php

session_start();
//connect to db
require_once 'taco-database.php';
$conn = db_connect();

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    //Taking username and password
    $username = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

    //query db for username
    $sql = "SELECT * FROM taco_users WHERE username=:username";
    $cmd = $conn -> prepare($sql);
    $cmd -> bindParam(":username", $username, PDO::PARAM_STR, 50);
    $cmd -> execute();
    $found_user = $cmd -> fetch();

    //Password check
    if (password_verify($password, $found_user['hashed_password'])) {
        //redirecting to home page
        session_regenerate_id();
        $_SESSION['user_id'] = $found_user['user_id'];
        $_SESSION['last_login'] = time();
        $_SESSION['username'] = $found_user['username'];
        header("Location: tacos-home.php");
        exit;
    } else {
        header("Location:taco-login.php?invalid=true");
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>

<body>
    <div class="container-fluid"></div>
    <div class="row">
        <div class="col d-none d-sm-block">
            <img src="img/login.jpg" alt="" class="img-fluid">
        </div>
        <div class="col d-flex">
            <div class="align-self-center">

                <h1 class="text-center fs-5 py-3">ACCOUNT LOGIN</h1>
                <form method="POST" class="row">
                    <div class="row">
                        <div class="form-floating mb-4">
                            <input type="email" required autocomplete="email" autofocus id="email"
                                placeholder="name@example.com" class="rounded-0 form-control" name="email">
                            <label for="email" class="px-4">Email Address</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-floating mb-4">
                            <input type="password" required id="password" placeholder="password"
                                class="rounded-0 form-control" name="password">
                            <label for="password" class="px-4">Password</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <button class="btn text-dark btn-lg mb-4 w-100" style="background-color: #ddd">Sign
                                In</button>
                        </div>
                        <div class="col">
                            <a href="taco-register.php" class="btn btn-success btn-lg mb-4 w-100">Sign Up</a>
                        </div>
                    </div>
                </form>

                <?php if($_GET['invalid'] ?? false) { ?>
                <p class="text-danger"><strong>Invalid username or password</strong></p>
                <?php } ?>

            </div>
        </div>
    </div>


    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

</body>

</html>