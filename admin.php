<?php 
	$servername = "localhost";
	$username = "arrayofsoles";
	$password = "array2015";
	$dbname = "FORTUNAaos";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>FORTUNA ADMIN</title>
<link href="/css/bootstrap.css" rel="stylesheet" type="text/css">
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body>
<main class="container-fluid">
	<h1>Add<br><small>New Item</small></h1>
    <form class="row" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>"> 
        	<aside class="form-group col-md-6">
            	<label for="Product SKU">SKU:</label>
            	<input required type="number" name="product_SKU" class="form-control">
            </aside>
            <aside class="form-group col-md-6">
            	<label for="Product Type">Type:</label>
                <select name="product_type" class="form-control">
                    <option value="shoes">Shoes</option>
                    <option value="appearl">Appearl</option>
                    <option value="other">Other</option>
                </select>
            </aside>
            <aside class="form-group col-md-6">
            	<label for="Product Type">Sub-Type:</label>
                <select name="product_subtype" class="form-control">
                    <option value="Men">Men</option>
                    <option value="Women">Women</option>
                    <option value="Kids">Kids</option>
                </select>
            </aside>
            <aside class="form-group col-md-6">
            	<label for="Product Brand">Brand:</label>
            	<input required type="text" name="product_brand" class="form-control">
            </aside>
            <aside class="form-group col-md-6">
            	<label for="Product Name">Model:</label>
            	<input required type="text" name="product_model" class="form-control">
            </aside>
            <aside class="form-group col-md-6">
            	<label for="Product Name">Name:</label>
            	<input required type="text" name="product_name" class="form-control">
            </aside>
            <aside class="form-group col-md-6">
            	<label for="Product Size">Size:</label>
            	<input required type="text" name="product_size" class="form-control">
            </aside>
            <aside class="form-group col-md-6">
            	<label for="Product Condition">Condition:</label>
                <select name="product_cond" class="form-control">
                    <option value="DEADSTOCK">New</option>
                    <option value="CONDITIONAL">Conditional</option>
                </select>
            </aside>
            <aside class="form-group col-md-6">
            	<label for="Product Price">Price($):</label>
            	<input required type="number" name="price" value="Price" class="form-control">
            </aside>
            <aside class="form-group col-md-6">
            	<label for="Quantity">Quantity:</label>
            	<input required type="number" name="stock" value="Stock" class="form-control">
            </aside>
            <aside class="form-group col-xs-6 col-md-3">
            	<label for="Product Images">Images:</label>
            	<input type="file" name="product_img_name1">
            	<input type="file" name="product_img_name2">
            </aside>
            <aside class="form-group col-xs-6 col-md-3">
            	<input type="file" name="product_img_name3">
            	<input type="file" name="product_img_name4">
            </aside>
            <button type="submit" class="btn btn-default col-xs-12">Submit</button>
    </form>
</main>
<?php
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // collect value of input field
	$SKU = $_POST['product_SKU'];
    $type = $_POST['product_type'];
	$subtype = $_POST['product_subtype'];
	$brand = $_POST['product_brand'];
	$model = $_POST['product_model'];
	$name = $_POST['product_name'];
	$size = $_POST['product_size'];
	$cond = $_POST['product_cond'];
	$price = $_POST['price'];
	$img1 = $_POST['product_img_name1'];
	$img2 = $_POST['product_img_name2'];
	$img3 = $_POST['product_img_name3'];
	$img4 = $_POST['product_img_name4'];
	$stock = $_POST['stock'];
    if (empty($brand)) {
        echo "Brand is empty";
    } else {
		$add_item_query="
			INSERT INTO tblproduct 
			VALUES ('', '".$type."', '".$subtype."', '".$brand."',  '".$model."', '".$name."', '".$SKU."',  '".$img1."', '".$img2."', '".$img3."', '".$img4."', '".$price."', '".$size."', '".$cond."', '".$stock."')";
		if ($conn->query($add_item_query) === TRUE) {
			echo "New record created successfully";
		} else {
			echo "Error: " . $add_item_query . "<br>" . $conn->error;
			}
    	}
	}
?>
</body>
</html>