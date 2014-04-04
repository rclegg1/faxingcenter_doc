<?php
use FaxingCenter\Entity\SearchFaxEntity;
require_once '/../init_autoloader.php';

$entity = new SearchFaxEntity();
$entity->from_date = '2014-04-04T11:52:36-5:00';
$entity->to_date   = '2014-04-30T23:59:59-5:00';
$entity->p = '1';

//$entity->status = '2';
//$entity->user_id = '';

$response = $client->search($entity);

// handle the response
if($response){
	var_dump( $client->getLastResponse() );
}
else{
	echo "#### Request failed #### \n";
	var_dump( $client->getLastResponse() );	
}