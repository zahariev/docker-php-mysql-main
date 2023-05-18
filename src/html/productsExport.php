<?php

require_once '../php/productExportData.php';
$conn = require_once '../php/connection.php';
$filename = 'orders_' . $start_date . '_' . $end_date . '.csv';

    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename=' . $filename);

    $file = fopen('php://output', 'w');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    // Извличане на поръчките и свързаните с тях продукти за избрания период
    $data = productsExportData($conn,$start_date, $end_date);

     

print_r($header_row);
    if (!empty($data)) {
        $header_row = array_keys($data[0]); 
        fputcsv($file, $header_row);

    
        foreach ($data as $row) {
            fputcsv($file, $row);
           
        }
    } else {
        fputcsv($file, array('No orders found'));    
    }
}

 fclose($file);
    exit;

    ?>