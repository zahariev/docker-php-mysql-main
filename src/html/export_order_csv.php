<?php

// require_once "get_orders_by_date_range.php";


$conn = require_once '../php/connection.inc';

    if (!($result=mysqli_query($conn,'SHOW DATABASES')))
    printf("Error: %s\n", mysqli_error($conn));

echo "<h3>Databases</h3>";

while($row = mysqli_fetch_row( $result ))
    echo $row[0]."<br />";

$result -> free_result();
$conn->close();
    
?>