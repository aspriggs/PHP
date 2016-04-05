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

<!-- The required Stripe lib -->
  <script type="text/javascript" src="https://js.stripe.com/v2/"></script>

  <!-- jQuery is used only for this example; it isn't required to use Stripe -->
  <!-- <link href="css/bootstrap.css" rel="stylesheet" type="text/css"> -->  
  <!-- <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> -->  
  <link href="css/bootstrap-3.3.5.css" rel="stylesheet" type="text/css">
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

<?php require ("nav.php");?>

<section id="shopping-cart">
<div id="cart-item"></div>
</section>

<section class="container-fluid row" id="main">

<section class="col-lg-12 text-center">
    	
    	<h2>Events</h2>
        <hr>
<h1><strong>March 26</strong> <em>Baltimore Sneaker Show</em></h1>
                 <address>Security Square Mall <br>
                  6901 Security Blvd <br>
                 Windsor, MD</address> 

<h1><strong>April 2 & 3</strong> <em>Sole X Change NJ</em></h1> 
                  <address>IPlay America Event Center<br>
                  110 Schank Rd<br>
                  Freehold, NJ</address> 

<h1><strong>June 11</strong> <em>Sole X Change DC</em></h1>

<h1><strong>July 16</strong> <em>SneakerMania DC </em>  </h1>                     
             <address>Washington Convention Center <br>
             801 Mt Vernon Pl NW<br>
             Washington, DC</address>

<h1><strong>Aug 26-28</strong><em> Sole X Change NYC</em></h1>
                   <address>68 Lexington Ave<br>
                   NYC, NY</address>

<h1><strong>Dec 17</strong><em> SneakerMania DC</em></h1>

	<hr>
    </section>

</section>

<?php require("footer.php"); ?>

<!-- <script src="js/bootstrap.js" type="text/javascript"></script> -->
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