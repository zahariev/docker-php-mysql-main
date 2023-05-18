<?


function orderExportData($conn, $startDate, $endDate) 
{
    // Prepare the SQL query
    $sql = "SELECT
    o.id ,
    o.name ,
    o.family,
    o.phone ,
    o.email,
    o.comment,
    o.updated_at,
    o.delivery_type,
    CASE
        WHEN o.delivery_type LIKE 'До адрес%' THEN CONCAT(o.city, ' ', o.address)
        WHEN o.delivery_type LIKE 'Офис на%' THEN CONCAT('Oфис no. ', o.office)
        ELSE ''
    END AS delivery_address,
    os.name AS status,
    pt.name AS payment_type,
    o.invoice_type ,
    CASE
        WHEN o.invoice_type = 'Юридическо лице' THEN o.invoice_j_firm
        ELSE ''
    END AS 'firm_name',
    CASE
        WHEN o.invoice_type = 'Юридическо лице' THEN o.invoice_j_mol
        ELSE ''
    END AS 'mol',
    CASE
        WHEN o.invoice_type = 'Юридическо лице' THEN o.invoice_j_address
        ELSE ''
    END AS 'firm_address',
    CASE
        WHEN o.invoice_type = 'Юридическо лице' THEN o.invoice_j_eik
        ELSE ''
    END AS 'eik',
    CASE
        WHEN o.invoice_type = 'Юридическо лице' AND o.invoice_j_has_vat THEN 'Да' 
        ELSE ''
    END AS ' vat',
    CASE
        WHEN o.invoice_type = 'Физическо лице' THEN o.invoice_p_name
        ELSE ''
    END AS 'invoice_name',
    CASE
        WHEN o.invoice_type = 'Физическо лице' THEN o.invoice_p_family
        ELSE ''
    END AS 'invoice_family',
    CASE
        WHEN o.invoice_type = 'Физическо лице' THEN o.invoice_p_address
        ELSE ''
    END AS 'invoice_address',
    CASE
        WHEN o.invoice_type = 'Физическо лице' THEN o.invoice_p_egn
        ELSE ''
    END AS 'invoice_egn'
   
FROM orders o
LEFT JOIN order_statuses os ON o.status = os.id
LEFT JOIN payment_types pt ON o.payment_type = pt.id
WHERE DATE_FORMAT(o.updated_at,'%Y-%m-%d') BETWEEN DATE_FORMAT( ? ,'%Y-%m-%d') AND DATE_FORMAT(?,'%Y-%m-%d') 
ORDER BY o.id ASC";

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
    die("Error in preparing the SQL query: " . $conn->error);
}
  

    // Bind the parameters
  $stmt->bind_param('ss', $startDate, $endDate);
    // Execute the query
    $stmt->execute();

    // Get the result set
    $result = $stmt->get_result();

     while ($row = $result->fetch_assoc()) {

        $order = $row;
        $order['products'] = getOrderProducts($conn, $row['id']);
        $orders[] =  $order;
    }

    return $orders;
}

function getOrderProducts($conn, $orderId) {
    $sql = "SELECT full_arr FROM order_products WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $orderId);
    $stmt->execute();
    $result = $stmt->get_result();
    $products = array();

    while ($row = $result->fetch_assoc()) {
        $products[] = json_decode($row['full_arr']);
    }
    $products[] = array();
    return $products;
}

function getProductsArray($productsString) {
  
    $resultArray = array();

    $resultArray[] = array(
                                'ID',
                                'Име на продукта',
                                'Бр.',
                                'Цена',
                                'Сума',
                );
            
            foreach ($productsString as $product) {
                $resultArray[] = array(
                   $product->product_id,
                    $product->title,
                    $product->quantity,
                    $product->price,
                    $product->real_price,
                );

            }
   

    return $resultArray;
}

?>