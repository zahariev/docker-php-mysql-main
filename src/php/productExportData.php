<?

function productsExportData($conn) 
{
    // Prepare the SQL query
    $sql = "SELECT c.name as cat_name, sc2.name as sub2_name, p.* 
FROM products p
LEFT JOIN category c ON p.category_id = c.id
LEFT JOIN sub2category sc2 ON p.sub2category_id = sc2.id
";

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
    die("Error in preparing the SQL query: " . $conn->error);
}
  

    // Bind the parameters
//   $stmt->bind_param('ss', $startDate, $endDate);
    // Execute the query
    $stmt->execute();

    // Get the result set
    $result = $stmt->get_result();

     while ($row = $result->fetch_assoc()) {
 
        $orders[] =  $row;
    }

    return $orders;
}

?>