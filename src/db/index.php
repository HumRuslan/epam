<?php

require_once './functions.php';
/** @var \PDO $pdo */
require_once './pdo_ini.php';

$uniqueFirstLetters = getUniqueFirstLetters($pdo);

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $url_sort = '';
    $url_filter_by_first_letter = '';
    $url_filter_by_state = '';
    $url_page = '';
    $page = isset($_GET['page']) ? $_GET['page'] : 1;

    foreach ($_GET as $key => $value) {
        $function_name = snakeCaseToCamelCase('get_'.$key);
        if (function_exists($function_name)) {
            $sql = $function_name($value, $sql);
            $name_url = 'url_' .$key;
            $$name_url = "&$key=$value";
        }
    }
    $sql_query = getAirports($pdo, $sql);
    $airports = $sql_query['airports'];
    $count = $sql_query['count'];
    if ($page >= 10) {
        $start_page = $page - 5;
        $end_page = (ceil($count/5) > $page + 5) ? $page + 5: ceil($count/5);
    } else {
        $start_page = 1;
        $end_page = (ceil($count/5) > 10) ? 10: ceil($count/5);
    }
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title>Airports</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body>
<main role="main" class="container">
    <h1 class="mt-5">US Airports</h1>
    <div class="alert alert-dark">
        Filter by first letter:

        <?php foreach ($uniqueFirstLetters as $letter): ?>
            <a href="index.php?filter_by_first_letter=<?= $letter  . $url_filter_by_state . $url_sort?>"><?= $letter ?></a>
        <?php endforeach; ?>

        <a href="index.php" class="float-right">Reset all filters</a>
    </div>
    <table class="table">
        <thead>
        <tr>
            <th scope="col"><a href="index.php?sort=name&<?=$url_page . $url_filter_by_first_letter . $url_filter_by_state ?>">Name</a></th>
            <th scope="col"><a href="index.php?sort=code&<?=$url_page . $url_filter_by_first_letter . $url_filter_by_state ?>">Code</a></th>
            <th scope="col"><a href="index.php?sort=state_name&<?=$url_page . $url_filter_by_first_letter . $url_filter_by_state ?>">State</a></th>
            <th scope="col"><a href="index.php?sort=city_name&<?=$url_page . $url_filter_by_first_letter . $url_filter_by_state ?>">City</a></th>
            <th scope="col">Address</th>
            <th scope="col">Timezone</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($airports as $airport): ?>
        <tr>
            <td><?= $airport['name'] ?></td>
            <td><?= $airport['code'] ?></td>
            <td><a href="index.php?filter_by_state=<?= $airport['state_name']  . $url_filter_by_first_letter . $url_sort?>"><?= $airport['state_name'] ?></a></td>
            <td><?= $airport['city_name'] ?></td>
            <td><?= $airport['address'] ?></td>
            <td><?= $airport['timezone'] ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <nav aria-label="Navigation">
        <ul class="pagination justify-content-center">
            <?php
            for($i = $start_page; $i <= $end_page; $i++){
                if ($i == $page){
                    ?>
                    <li class="page-item active"><a class="page-link" href="index.php?page=<?=$i . $url_filter_by_first_letter . $url_filter_by_state . $url_sort?>"><?=$i?></a></li>
                    <?php
                } else {
                    ?>
                    <li class="page-item"><a class="page-link" href="index.php?page=<?=$i . $url_filter_by_first_letter . $url_filter_by_state . $url_sort?>"><?=$i?></a></li>
                    <?php
                }
            }
            ?>
        </ul>
    </nav>
</main>
</html>
