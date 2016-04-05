<section class="product-item col-md-4 text-center">
        
          <div id="carousel<?php echo $product_array[$key]["code"]; ?>" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
              <li data-target="#carousel<?php echo $product_array[$key]["code"]; ?>" data-slide-to="0" class="active"></li>
              <li data-target="#carousel<?php echo $product_array[$key]["code"]; ?>" data-slide-to="1"></li>
              <li data-target="#carousel<?php echo $product_array[$key]["code"]; ?>" data-slide-to="2"></li>
              <li data-target="#carousel<?php echo $product_array[$key]["code"]; ?>" data-slide-to="3"></li>
            </ol>
            <div class="carousel-inner" role="listbox">
              <div class="item active"><img src="product-images/<?php echo $product_array[$key]["image"]; ?>" alt="First slide image" class="center-block">
      	      </div>
        	    <div class="item"><img src="product-images/<?php echo $product_array[$key]["image2"]; ?>" alt="Second slide image" class="center-block">
      	      </div>
        	    <div class="item"><img src="product-images/<?php echo $product_array[$key]["image3"]; ?>" alt="Third slide image" class="center-block">
      	      </div>
              <div class="item"><img src="product-images/<?php echo $product_array[$key]["image4"]; ?>" alt="Fourth slide image" class="center-block">
      	      </div>
            </div>
            
             <a class="left carousel-control" href="#carousel<?php echo $product_array[$key]["code"]; ?>" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#carousel<?php echo $product_array[$key]["code"]; ?>" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
            
            </div>
            
<form id="frmCart">
  <section><strong><?php echo $product_array[$key]["brand"]; ?></strong>
    <strong><?php echo $product_array[$key]["model"]; ?></strong> <em><?php echo $product_array[$key]["name"]; ?></em></section>
  <section>	<small><strong><?php echo $product_array[$key]["cond"]; ?></strong>
    Size: <strong><?php echo $product_array[$key]["size"]; ?></strong>
    Price: <strong class="product-price"><?php echo "$".$product_array[$key]["price"]; ?></strong>
    </small>
    </section>
  <section><input hidden type="text" id="qty_<?php echo $product_array[$key]["code"]; ?>" name="quantity" value="1" size="2" />
    <?php
				$in_session = "0";
				if(!empty($_SESSION["cart_item"])) {
					$session_code_array = array_keys($_SESSION["cart_item"]);
				    if(in_array($product_array[$key]["code"],$session_code_array)) {
						$in_session = "1";
				    }
				}
			?>
    <input type="button" id="add_<?php echo $product_array[$key]["code"]; ?>" value="Add to cart" class="btnAddAction cart-action btn btn-xs btn-info" onClick = "cartAction('add','<?php echo $product_array[$key]["code"]; ?>')" <?php if($in_session != "0") { ?>style="display:none" <?php } ?> />
    <input type="button" id="added_<?php echo $product_array[$key]["code"]; ?>" value="Added" class="btnAdded btn btn-xs" <?php if($in_session != "1") { ?>style="display:none" <?php } ?> />
    </section>
</form>
</section>