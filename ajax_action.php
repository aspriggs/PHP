<?php
session_start();
require_once("dbcontroller.php");
$db_handle = new DBController();

//Create shopping cart
if(!empty($_POST["action"])) {
switch($_POST["action"]) {
	//add item to cart
	case "add":
		if(!empty($_POST["quantity"])) {
			$productByCode = $db_handle->runQuery("SELECT * FROM tblproduct WHERE code='" . $_POST["code"] . "'");
			$itemArray = array($productByCode[0]["code"]=>array('brand'=>$productByCode[0]["brand"],'model'=>$productByCode[0]["model"],'name'=>$productByCode[0]["name"], 'code'=>$productByCode[0]["code"], 'quantity'=>$_POST["quantity"], 'price'=>$productByCode[0]["price"], 'size'=>$productByCode[0]["size"], 'cond'=>$productByCode[0]["cond"]));
			
			if(!empty($_SESSION["cart_item"])) {
				if(in_array($productByCode[0]["code"],$_SESSION["cart_item"])) {
					foreach($_SESSION["cart_item"] as $k => $v) {
							if($productByCode[0]["code"] == $k)
								$_SESSION["cart_item"][$k]["quantity"] = $_POST["quantity"];
					}
				} else {
					$_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$itemArray);
				}
			} else {
				$_SESSION["cart_item"] = $itemArray;
			}
		}
	break;
	//remove item from cart
	case "remove":
		if(!empty($_SESSION["cart_item"])) {
			foreach($_SESSION["cart_item"] as $k => $v) {
					if($_POST["code"] == $k)
						unset($_SESSION["cart_item"][$k]);
					if(empty($_SESSION["cart_item"]))
						unset($_SESSION["cart_item"]);
			}
		}
	break;
	//empty cart
	case "empty":
		unset($_SESSION["cart_item"]);
	break;		
}
}
?>
<?php
if(isset($_SESSION["cart_item"])){
    $item_total = 0;
?>
<article class="col-md-12" id="quickview">
<section><h3>Shopping Cart</h3><span id="btnEmpty" class="cart-action" onClick="cartAction('empty','');">Empty Cart</span><br></section>
<table class="table table-bordered table-condensed table-hover">
<tbody>
<tr>
<th></th>
<th><strong>SKU</strong></th>
<th><strong>Item</strong></th>
<th><strong>Size</strong></th>
<th><strong>Price</strong></th>
</tr>	
<?php	
	//Display cart information
	$cart = "";	
    foreach ($_SESSION["cart_item"] as $item){
		?>
				<tr>
                <td><a onClick="cartAction('remove','<?php echo $item["code"]; ?>')" class="btnRemoveAction cart-action glyphicon glyphicon-remove"></a></td>
                <td><?php echo $item["code"]; ?></td>
				<td><?php echo $item["brand"]; ?> <?php echo $item["model"]; ?> <?php echo $item["name"]; ?></td>
                <td><?php echo $item["size"]; ?></td>
				<td align=right><?php echo "$".$item["price"]; ?></td>
				</tr>
				<?php
        $item_total += ($item["price"]*$item["quantity"]);
		$shipping = 10;
		$total = $item_total+$shipping;
		
		$cart .= "<p>";
		$cart .= "SKU: ".$item["code"]."<br/>";
        $cart .= "Brand: ".$item["brand"]."<br/>";
		$cart .= "Model: ".$item["model"]."<br/>";
		$cart .= "Name: ".$item["name"]."<br/>";
		$cart .= "Size: ".$item["size"]."<br/>";
		$cart .= "Price: ".$item["price"]."<br/>";
		$cart .= "</p>";
		}
		$cart .= "Order Total: $".$total;
		?>

<tr>
<td colspan="5" align=right><strong>Sub-Total:</strong> <?php echo "$".$item_total; ?></td>
</tr>
<tr id="shipping">
<td colspan="5" align=right><strong>Shipping:</strong> <?php echo "$".$shipping; ?></td>
</tr>
<tr id="total">
<td colspan="5" align=right><strong>Total:</strong> <?php echo "$".$total; ?></td>
</tr>
<tr>
</tr>
</tbody>
</table>	
<?php 
	//echo $cart;
	$skuList = array();
	foreach ($_SESSION["cart_item"] as $sku){
		array_push ($skuList,$sku["code"]); 
	}
	//print_r($skuList);
?>
<form action="charge.php" method="POST" class="pull-right">
	<input hidden type="number" name="total" value="<?php $total = $total * 100; echo $total;?>">
    <input hidden type="text" name="cart" value="<?php echo $cart; ?>">
    
    <?php
    foreach ($_SESSION["cart_item"] as $sku){
		echo ('<input hidden type="number" name="sku[]" value="'.$sku["code"].'">');
	}?>
    
	<script
    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
    data-key="pk_live_uN51JzEgD6vH5jzbtAtvfAAh"
    data-amount="<?php echo $total; ?>"
	data-panel-label="Pay {{amount}}"
    data-name="Your Order:"
    data-description=""
    data-locale="auto"
	data-email="true"
	data-billing-address="true"
	data-shipping-address="true">
    </script>
</form>

</article>
<!-- CUSTOM CHECKOUT
<article id="viewcart" class="col-md-12">
<form action="" method="POST" id="payment-form">
	<section class="col-md-6">
	<h4>Shipping Information <small>(Must match billing information)</small></h4>
    <hr>
    <span class="payment-errors"></span>
	
    <aside class="form-row form-group">
      <label>
        <span>Name</span>
      </label>
      <input type="text" class="form-control"/>
    </aside>
    <aside class="form-row form-group">
      <label>
        <span>Address</span>
      </label>
       <input type="text" class="form-control"/>
    </aside>
    <aside class="form-row form-group">
      <label>
        <span>City</span>
      </label>
      <input type="text" class="form-control"/>
    </aside>
    <aside class="form-row form-group">
      <label>
        <span>State</span>
      </label>
      <input type="text" class="form-control"/>
    </aside>
    <aside class="form-row form-group">
      <label>
        <span>Zip</span>
      </label>
      <input type="number" class="form-control"/>
    </aside>
    </section>
    <section class="col-md-6">
    <h4>Payment Information <small></small></h4>
    <hr>
    <aside class="form-row form-group">
      <label>
        <span>Card Number</span>
      </label>
       <input type="text" data-stripe="number" class="form-control"/>
    </aside>
    
    <aside class="form-row  form-group">
      <label>
        <span>CVC</span>
      </label>
      <input type="text" data-stripe="cvc" class="form-control"/>
    </aside>
    
    <aside class="form-row  form-group">
      <label>
        <span>Expiration Month (MM)</span>
      </label>
       <input type="text" data-stripe="exp-month" class="form-control"/>
      <label>
        <span>Expiration Year (YYYY)</span>
      </label>
      <input type="text" data-stripe="exp-year" class="form-control"/>
      
    </aside>
    
    </section>
    <aside class="form-row form-group">
    <button type="submit" class="btn btn-success center-block">Place order</button>
    </aside>
    <aside class="form-row form-group">
    <button onClick="cartAction('keepshopping','')" class="btn btn-danger btn-xs center-block">Keep Shopping</button>
    </aside>
  </form>
</article>
-->

  <?php
}
?>