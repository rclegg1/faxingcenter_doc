<?php
require_once '/../init_autoloader.php';
// Send Id
$sid = 'a5734e214cdb4113b855006cdf04bcc3';

// Message Id
$mid = null;
$mid = '0ba654a37a7e4c50b9ffcf6252b9d544';


$response = $client->getStatus($sid, $mid);

// handle the response
if($response){
	var_dump( $client->getLastResponse() );
}
else{
	echo "#### Request failed #### \n";
	var_dump( $client->getLastResponse() );	
}
