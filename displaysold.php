<?php

$sold_array = $db_handle->runQuery($sold);
if (!empty($sold_array)) { 
	foreach($sold_array as $sold_key=>$value){

require ("sold_inventory.php");

	}
}
?>