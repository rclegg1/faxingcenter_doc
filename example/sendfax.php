<?php
use FaxingCenter\Entity\SendFaxEntity;
use FaxingCenter\Entity\ReceipientEntity;
use FaxingCenter\Entity\DocumentEntity;
require_once '/../init_autoloader.php';

// Build a receipient list
$receipients = array(
	new ReceipientEntity(array('fax_number'=>'18555808797')),
	new ReceipientEntity(array('fax_number'=>'18555808797'))
);

// Attach some documents
$documents = array(
	new DocumentEntity(array(
		'file_name'=>'test.txt',
		'file_data' => 'fdsafdsa',
		'order'=> 0		
	))
);

// Create the send entity
$send_fax_entity = new SendFaxEntity(array(
	'receipients'=>$receipients,
	'documents' => $documents	
));

// Send your fax
$response = $client->sendFax($send_fax_entity);

// handle the response
if($response){
	var_dump( $client->getLastResponse() );
}
else{
	echo "#### Request failed #### \n";
	var_dump( $client->getLastResponse() );	
}
