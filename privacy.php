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
<div id="privacy" class="col-lg-8 col-lg-push-2">
<h1>Privacy Policy</h1>
    <p>Array of Soles guarantees that every transaction you make on our website will be safe. All information gathered while shopping with us is held in the strictest confidence.</p>

	<p>Your name, address, e-mail, and all other personal information will never be distributed or sold. We recognize your right to confidentiality and are committed to protecting your privacy.</p>

	<p>We use the information that we collect on our Web sites to provide you with a superior shopping experience and to communicate with you about products, services, and promotions.</p>

	 <p>Registration at this web site is optional. However, you can use all our convenient site features and check out quickly if you choose to register with us.</p>

	 <p>During registration you will provide contact information (such as name, email address, billing and shipping address). We use this information to contact you about the services on our site in which you have expressed interest.</p>

	 <p>We use your information to send you the order confirmation and shipping notification via email. Generally, you may not opt-out of these communications, which are not promotional in nature.</p>

	 <p>If you do not wish to receive them, you have the option to deactivate your account. Orders If you purchase a product or service from us, we request certain personally identifiable information from you on our order form.</p>

	 <p>You must provide contact information (such as name, email, and shipping address) and financial information (such as credit card number, expiration date). We use this information for billing purposes and to fill your orders.</p>

	 <p>If we have trouble processing an order, we will use this information to contact you. Customer Service Based upon the personally identifiable information you provide us, we will send you a welcoming email to verify your username and password.</p>

	 <p>We will also communicate with you in response to your inquiries, to provide the services you request, and to manage your account. We will communicate with you by email or telephone, in accordance with your wishes.</p>

	 <p>Generally, you may not opt-out of these communications, which are not promotional in nature. If you do not wish to receive them, you have the option to deactivate your account. Unsolicited E-mail (SPAM) WE DO NOT send unsolicited e-mail. If you receive an unsolicited email that you believe is connected with us in any way, please forward the e-mail (as an enclosure) to us and we will investigate. If you sign up for our promotional email list, you may receive our deal announcement from time to time.</p>

	 <p>You can opt out the list anytime by replying to the unsubscribe instructions in the email. When you place an order, your personal information and credit card or debit card information are encrypted using SSL encryption technology before being sent over the Internet, We use SSL technology to prevent your information from being stolen or intercepted while being transferred to us.</p>

	 <p>Your credit card information is always stored in encrypted form in a restricted-access database that is away from our Web site database so it isn't connected to the Internet, to keep it safe from hackers. Notification of Changes to this privacy policy: If we decide to change our privacy policy, we will post those changes to this privacy statement, the homepage, and other places we deem appropriate so that you are aware of what information we collect, how we use it, and under what circumstances, if any, we disclose it.</p>

	 <p>We reserve the right to modify this privacy statement at any time, so please review it frequently. If we make material changes to this policy, we will notify you here, by email, or by means of a notice on our homepage.</p> 
     <a>Contact Us</a>
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