<?php

// $conn = require_once '../php/connection.inc';
require_once '../php/orderExportData.php';
$conn = require_once '../php/connection.php';
$filename = 'orders_' . $start_date . '_' . $end_date . '.csv';

    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename=' . $filename);

    $file = fopen('php://output', 'w');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Извличане на поръчките и свързаните с тях продукти за избрания период
    $data = orderExportData($conn,$start_date, $end_date);

     $header_row = array(
        'Номер на поръчка',
        'Малко име',
        'Фамилия',
        'Телефон',
        'И-мейл',
        'Коментар към поръчка',
        'Дата на поръчка',
        'Начин на доставка',
        'Адрес на доставка',
        'Статус на поръчка',
        'Начин на плащане',
        'Тип на фактурата',
        'Име на фирма',
        'МОЛ на фирма',
        'Седалище на фирма',
        'ЕИК на фирма',
        'ддс',
        'Име за фактура',
        'Фамилия за фактура',
        'Адрес за фактура',
        'ЕГН за фактура'
    );


    if (!empty($data)) {
        // $order = $data[0];

        fputcsv($file, $header_row);

    
        foreach ($data as $row) {

               // get products array
            $products = getProductsArray($row['products']);
            // array_pop($row);

            fputcsv($file, $row);
             foreach ($products as $product) 
                            fputcsv($file, $product);
        }
    } else {
        fputcsv($file, array('No orders found'));    
    }
}

 fclose($file);
    exit;

    ?>