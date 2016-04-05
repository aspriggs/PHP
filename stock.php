<?php

$product_array = $db_handle->runQuery($stock);
if (!empty($product_array)) { 
	foreach($product_array as $key=>$value){

require ("inventory.php");

	}
}
?>