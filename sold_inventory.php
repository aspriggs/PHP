<section class="product-item col-md-4 text-center">
        
          <div id="carousel<?php echo $sold_array[$sold_key]["code"]; ?>" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
              <li data-target="#carousel<?php echo $sold_array[$sold_key]["code"]; ?>" data-slide-to="0" class="active"></li>
              <li data-target="#carousel<?php echo $sold_array[$sold_key]["code"]; ?>" data-slide-to="1"></li>
              <li data-target="#carousel<?php echo $sold_array[$sold_key]["code"]; ?>" data-slide-to="2"></li>
              <li data-target="#carousel<?php echo $sold_array[$sold_key]["code"]; ?>" data-slide-to="3"></li>
            </ol>
            <div class="carousel-inner" role="listbox">
              <div class="item active"><img src="product-images/<?php echo $sold_array[$sold_key]["image"]; ?>" alt="First slide image" class="center-block">
      	      </div>
        	    <div class="item"><img src="product-images/<?php echo $sold_array[$sold_key]["image2"]; ?>" alt="Second slide image" class="center-block">
      	      </div>
        	    <div class="item"><img src="product-images/<?php echo $sold_array[$sold_key]["image3"]; ?>" alt="Third slide image" class="center-block">
      	      </div>
              <div class="item"><img src="product-images/<?php echo $sold_array[$sold_key]["image4"]; ?>" alt="Fourth slide image" class="center-block">
      	      </div>
            </div>
            
             <a class="left carousel-control" href="#carousel<?php echo $sold_array[$sold_key]["code"]; ?>" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#carousel<?php echo $sold_array[$sold_key]["code"]; ?>" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
            
            </div>
            
            <h1 class="text-center text-captialize">SOLD!</h1>
            
</section>