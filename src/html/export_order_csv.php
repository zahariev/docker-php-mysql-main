<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    echo "Start Date: $start_date<br>";
    echo "End Date: $end_date<br>";
    // $data = get_orders_by_date_range($start_date, $end_date);

}

    exit;

    ?>