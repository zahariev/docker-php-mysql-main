<?php

// $conn = require_once '../php/connection.inc';
require_once '../php/orderExportData.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    echo "Start Date: $start_date<br>";
    echo "End Date: $end_date<br>";
    $data = orderExportData($start_date, $end_date);

    echo $data->num_rows;

    while ($row = $data->fetch_assoc()) {
    echo "<pre>".print_r($row)."</pre>";
    }

    // Извличане на поръчките и свързаните с тях продукти за избрания период
    // $data = orderExportData($start_date, $end_date);

}

    exit;

    ?>