<?php
require 'lib/Stripe.php';
require 'dbcontroller.php';
$db_handle = new DBController();
$db_handleID = new DBController();

if ($_SERVER['REQUEST_METHOD'] == "POST"){
	// Store posted variables
	$total = $_POST["total"];
	$code = $_POST["code"];
	$brand = $_POST["brand"];
	$model = $_POST["model"];
	$name = $_POST["name"];
	$size = $_POST["size"];
	$price = $_POST["price"];
	$cart = $_POST["cart"];
	// Array of SKUs from order
	$skuList = $_POST["sku"];
	
	// Set your secret key: remember to change this to your live secret key in production
	// See your keys here https://dashboard.stripe.com/account/apikeys
	Stripe::setApiKey("sk_live_RH8ujKwgXotPaRSrju660agN");
	
	// Get the details submitted by the form
	$token = $_POST['stripeToken'];
	$customerEmail = $_POST['stripeEmail'];
	$customerName = $_POST['stripeShippingName'];
	$customerAddress = $_POST['stripeShippingAddressLine1'];
	$customerAddress .= " ".$_POST['stripeShippingAddressCity'];
	$customerAddress .= " ".$_POST['stripeShippingAddressState'];
	$customerAddress .= " ".$_POST['stripeShippingAddressZip'];
	$customerAddress .= " ".$_POST['stripeShippingAddressCountry'];
	
	// Remove items once order confirmed, setting quantity to zero
	foreach($skuList as $sku){
	$soldQuery = "UPDATE  `tblproduct` SET  `stock` =  '0' WHERE  `code` = ".$sku.";";
	$sold = $db_handle->runQuery($soldQuery);
	}
	
	// Create a Customer
	$customer = Stripe_Customer::create(array(
	  "source" => $token,
	  "description" => $customerName)
	);
	
	// Charge the Customer instead of the card
	Stripe_Charge::create(array(
	  "amount" => $total, // amount in cents, again
	  "currency" => "usd",
	  "customer" => $customer->id)
	);
	
	// Store order in database
	$orderQuery = "INSERT INTO `order` VALUES ('','".date("Y-m-d")." ".date("h:i:sa")."','$token','$total','$customerName','$customerEmail','$customerAddress','OPEN','$cart')";
	$order = $db_handle->runQuery($orderQuery);
	
	// Fetch order number
	$orderIDQuery = "SELECT `orderID` FROM `order` ORDER BY `orderID` DESC LIMIT 1";
	$orderIDFetch=$db_handleID->runQuery($orderIDQuery);
	$orderID = $orderIDFetch[0];
	$orderNo = implode($orderID);
	
	// E-Mail to Array Of Soles
	$message = "";
	$message .= "<html><body>";
	$message .= "<h1>Order Summary</h1>";
	$message .= "Token: ".$token."<br>";
	$message .= "Order #: ".$orderNo;
	$message .= "<br>".$cart."<br>";
	$message .= "<br>Shipping/Billing Information: <br>";
	$message .= "Name: ".$customerName."<br>";
	$message .= "E-Mail: ".$customerEmail."<br>";
	$message .= "Address:<br>".$customerAddress."<br>";
	$message .= "</body></html>";
	$recipient = "spriggslife@gmail.com, arrayofsolesonline@gmail.com";
	$subject = "Array of Soles: New Order";
	$headers = "From: no-reply@arrayofsoles.com\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	mail($recipient, $subject, $message, $headers);
	
	// E-Mail to Customer
	$custMessage = "";
	$custMessage .= "<html><body>";
	$custMessage .= "<h1>Order Confirmation & Summary</h1>";
	$custMessage .= "Order #: ".$orderNo;
	$custMessage .= "<br>".$cart."<br>";
	$custMessage .= "<br>Shipping/Billing Information: <br>";
	$custMessage .= "Name: ".$customerName."<br>";
	$custMessage .= "E-Mail: ".$customerEmail."<br>";
	$custMessage .= "Address:<br>".$customerAddress."<br>";
	$custMessage .= "Your order will be shipped in 1-3 business days.";
	$custMessage .= "</body></html>";
	$custSubject = "Your Array of Soles Order";
	$custHeaders = "From: no-reply@arrayofsoles.com\r\n";
	$custHeaders .= "MIME-Version: 1.0\r\n";
	$custHeaders .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	mail($customerEmail, $custSubject, $custMessage, $custHeaders);
	}
?>
<!--Customer confirmation-->
<!DOCTYPE>
<html>
<head></head>
<body>
<h1>Thanks you for your purchase!</h1>
<h2>Order Summary</h2>
<?php
echo "Order #: ".$orderNo;
echo "<br><br>Shipping Info:<br>";
echo $customerName."<br>";
echo $customerAddress."<br>";
echo "<br>Order Receipt<br>".$cart;
?>
<br>
<a href="index.php">Return to Array of Sole</a>
</body>
</html>
