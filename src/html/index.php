<!DOCTYPE html>
<html lang="en">
<head>
<title>Order Export</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>
<body>

<h1>Order Export</h1>
	<form action="export_order_csv.php" method="post">
		<label for="start_date">Start Date:</label>
		<input type="date" name="start_date" id="start_date" required>
		<label for="end_date">End Date:</label>
		<input type="date" name="end_date" id="end_date" required>
		<button type="submit">Export</button>
	</form>
</br>
    <form class="productExport"action="productsExport.php" method="post">
		
		<button type="submit">Products Export</button>
	</form>
</div>
</body>
</html>