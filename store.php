<?php 
//connect to db
require_once 'taco-database.php';
$conn = db_connect();
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style-two.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Pattaya&display=swap" rel="stylesheet">
    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
    <link rel="manifest" href="site.webmanifest">

    <link rel="preconnect" href="https://app.snipcart.com">
    <link rel="preconnect" href="https://cdn.snipcart.com">

    <link rel="stylesheet" href="https://cdn.snipcart.com/themes/v3.2.1/default/snipcart.css" />

</head>

<body>
    <div class="container">

        <header>
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <a class="navbar-brand gamefont fs-3" href="">Merch</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="tacos-list.php">Tacos</a>
                            </li>

                        </ul>

                        <ul class="navbar-nav d-flex">
                            <li class="nav-item">
                                <button class="btn btn-success snipcart-checkout">
                                    <span class="snipcart-total-price">$0.00</span>
                                    <i class="bi bi-cart4"></i>
                                    <span class="badge bg-warning text-dark snipcart-items-count">0</span>
                                </button>
                            </li>
                        </ul>


                    </div>
                </div>
            </nav>

        </header>


        <?php

$sql = "SELECT * FROM items";
$items = db_queryAll($sql, $conn)

?>

        <div class="row">

            <div class="col">

                <?php foreach($items as $item){ ?>

                <div class="card mb-3" style="max-width: 540px;">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="<?= $item['item_image'] ?>" class="img-fluid rounded-start" alt="...">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title"><?= $item['item_name'] ?></h5>
                                <p class="card-text"><?= $item['item_desc'] ?></p>

                                <button class="btn btn-primary buy-button snipcart-add-item"
                                    data-item-id="<?= $item['item_id'] ?>" data-item-price="<?= $item['item_price'] ?>"
                                    data-item-url="<?= $item['item_url'] ?>" data-item-name="<?= $item['item_name'] ?>"
                                    data-item-description="<?= $item['item_desc'] ?>"
                                    data-item-image="<?= $item['item_image'] ?>">Add to Cart
                                    ($<?= $item['item_price'] ?>)</button>

                            </div>
                        </div>
                    </div>
                </div>

                <?php } ?>

            </div>

            <div class="col">
                <img src="items/bg.jpg" alt="Items">
            </div>

        </div>

        <script async src="https://cdn.snipcart.com/themes/v3.2.1/default/snipcart.js"></script>
        <div hidden id="snipcart"
            data-api-key="YjQ4OGU3MWEtZTllNC00MDA1LWJiMDMtZTk1YWYyODExYjM5NjM3NjQ3NjQzMjgxMDg5NTU3"></div>

        <?php

include_once 'shared/footer-taco.php';

?>