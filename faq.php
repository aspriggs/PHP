<?php
require_once("dbcontroller.php");
$db_handle = new DBController();
?>
<HTML>
<HEAD>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<TITLE></TITLE>
<link href="css/style.css" type="text/css" rel="stylesheet" />
<link href="css/bootstrap-3.3.5.css" rel="stylesheet" type="text/css">

<!-- The required Stripe lib -->
  <script type="text/javascript" src="https://js.stripe.com/v2/"></script>

  <!-- jQuery is used only for this example; it isn't required to use Stripe -->
  <!-- <link href="css/bootstrap.css" rel="stylesheet" type="text/css"> -->  
  <!-- <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> -->  
 
  <script src="js/jquery-1.11.3.min.js" type="text/javascript"></script>
  <script type="text/javascript">
    // This identifies your website in the createToken call below
    Stripe.setPublishableKey('pk_test_l7e5COwAmbGxFFryM8BB3X6B');
    var stripeResponseHandler = function(status, response) {
      var $form = $('#payment-form');
      if (response.error) {
        // Show the errors on the form
        $form.find('.payment-errors').text(response.error.message);
        $form.find('button').prop('disabled', false);
      } else {
        // token contains id, last4, and card type
        var token = response.id;
        // Insert the token into the form so it gets submitted to the server
        $form.append($('<input type="hidden" name="stripeToken" />').val(token));
        // and re-submit
        $form.get(0).submit();
      }
    };
	
    jQuery(function($) {
      $('#payment-form').submit(function(e) {
        var $form = $(this);
        // Disable the submit button to prevent repeated clicks
        $form.find('button').prop('disabled', true);
        Stripe.card.createToken($form, stripeResponseHandler);
        // Prevent the form from submitting with the default action
        return false;
      });
    });
  </script>

<script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
<script>
function showEditBox(editobj,id) {
	$('#frmAdd').hide();
	$(editobj).prop('disabled','true');
	var currentMessage = $("#message_" + id + " .message-content").html();
	var editMarkUp = '<textarea rows="5" cols="80" id="txtmessage_'+id+'">'+currentMessage+'</textarea><button name="ok" onClick="callCrudAction(\'edit\','+id+')">Save</button><button name="cancel" onClick="cancelEdit(\''+currentMessage+'\','+id+')">Cancel</button>';
	$("#message_" + id + " .message-content").html(editMarkUp);
}
function cancelEdit(message,id) {
	$("#message_" + id + " .message-content").html(message);
	$('#frmAdd').show();
}
function cartAction(action,product_code) {
	var queryString = "";
	if(action != "") {
		switch(action) {
			case "add":
				queryString = 'action='+action+'&code='+ product_code+'&quantity='+$("#qty_"+product_code).val();
			break;
			case "remove":
				queryString = 'action='+action+'&code='+ product_code;
			break;
			case "empty":
				queryString = 'action='+action;
			break;
		}	 
	}
	jQuery.ajax({
	url: "ajax_action.php",
	data:queryString,
	type: "POST",
	success:function(data){
		$("#cart-item").html(data);
		if(action != "") {
			switch(action) {
				case "add":
					$("#add_"+product_code).hide();
					$("#added_"+product_code).show();
				break;
				case "remove":
					$("#add_"+product_code).show();
					$("#added_"+product_code).hide();
				break;
				case "empty":
					$(".btnAddAction").show();
					$(".btnAdded").hide();
				break;
				case "checkout":
					$("#main").hide();
					$("#btnEmpty").hide();
					$("#checkout").hide();
					$("#banner").hide();
					$(".btnRemoveAction").hide();
					$("#exitcart").show();
					$("#viewcart").show();
				break;
				case "keepshopping":
					$("#main").show();
					$("#banner").show();
				break;
				case "promo":
					
				break;
			}	 
		}
	},
	error:function (){}
	});
}
</script>
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<!--The following script tag downloads a font from the Adobe Edge Web Fonts server for use within the web page. We recommend that you do not modify it.--><script>var __adobewebfontsappname__="dreamweaver"</script><script src="http://use.edgefonts.net/crushed:n4:default;luckiest-guy:n4:default;coda:n4:default;droid-sans:n4:default.js" type="text/javascript"></script>
</HEAD>
<BODY>


<?php
	require ("header.php");
?>

<section class="container-fluid row" id="main">
<div id="faq" class="col-lg-8 col-lg-push-2">
<h1>FAQ</h1>
<ul class="list-group">
	<a href="#" class="list-group-item">
    <h4>How can I pay?</h4>
    <p>We accept all forms of payment (Visa, MasterCard, American Express, Discover). The credit card user must be the same person as the name printed on the card (owner of the card and accounts).
    </p>
    </a>
</ul>
<ul class="list-group">
	<a href="#" class="list-group-item">
    <h4>How long does it take for shipment? </h4>
    <p>All orders are processed and shipped within 24-48 hours. 
    </p>
    </a>
</ul>
<ul class="list-group"> 
	<a href="#" class="list-group-item">   
    <h4>Can I place a pre-order? </h4>
    <p>We do not accept any pre-orders.
    </p>
    </a>
 </ul> 
 <ul class="list-group"> 
 	<a href="#" class="list-group-item"> 
    <h4>Can you keep an item on hold?</h4>
    <p>All products are on a first come first serve basis. We do not accept any holds on items. 
    </p>
    </a>
 </ul>
 <ul class="list-group">  
 	<a href="#" class="list-group-item"> 
    <h4>How can I track my order status?</h4>
    <p>Once your order is shipped, your tracking information will be sent to you via email. 
    </p>
    </a>
 </ul>  
 <ul class="list-group"> 
 	<a href="#" class="list-group-item">
    <h4>How and where do you use for shipment?</h4>
    <p>We ship via USPS and we ship out of Woodbridge, Virginia.
    </p>
    </a>
 </ul>
 <ul class="list-group"> 
 	<a href="#" class="list-group-item">  
    <h4>Any shipping insurance available? </h4>
    <p>All items shipped will be insured for the full purchase amount.
    </p>
    </a>
 </ul>  
 <ul class="list-group">
 	<a href="#" class="list-group-item">
    <h4>Why was my order cancelled?</h4>
    <p>All orders without credit card billing addresses will be automatically cancelled. We do reserve the right to refuse or cancel any order for any reason, at our sole discretion. 
    </p>
    </a>
 </ul>
 <ul class="list-group">
 	<a href="#" class="list-group-item">
    <h4>Can I cancel/return/exchange an item?</h4>
    <p>All sales are final, no exceptions. All shoes are inspected prior to shipment for order accuracy and defects (yellowing, scuffs, and stains).
    </p>
    </a>
</ul>
<ul class="list-group">
	<a href="#" class="list-group-item">    
    <h4>Do you accept trades?</h4>
    <p>No, we do not accept online/shipping trades under any circumstances.
    </p>
    </a>
</ul>
<ul class="list-group"> 
	<a href="#" class="list-group-item">   
    <h4>How long does it take for my order to arrive?</h4>
    <p>2-6 business days depending on your location.
    </p>
    </a>
</ul>
<ul class="list-group">
	<a href="#" class="list-group-item">    
    <h4>Are all shoes/clothing authentic?</h4>
    <p>All shoes/clothing are guaranteed to be 100% authentic. 
    </p>
    </a>
</ul>
<ul class="list-group"> 
	<a href="#" class="list-group-item">   
    <h4>What is the percentage you take for consignment?</h4>
    <p>We will subtract 20% off the final sale price once your shoes sell.
    </p>
    </a>
</ul>
<ul class="list-group"> 
	<a href="#" class="list-group-item">   
    <h4>Do I get a discount if I purchase multiple items?</h4>
    <p>There are no discounts for multiple items purchased.
    </p>
    </a>
 </ul>
 <ul class="list-group">   
 	<a href="#" class="list-group-item">
    <h4>Can you put my item in a extra box?</h4>
    <p>All orders are double boxed to provide optimal protection.
    </p>
    </a>
</ul>
</div>
</section>

<?php require("footer.php"); ?>


<script src="js/bootstrap-3.3.5.js" type="text/javascript"></script>
<script>
$(document).ready(function () {
	cartAction('','');
})
$('.carousel').carousel({
  interval: false
})
</script>
<!--<script src="js/aos.js"></script>-->
</BODY>
</HTML>