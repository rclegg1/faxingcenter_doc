<?php
use FaxingCenter\Entity\SendFaxEntity;
use FaxingCenter\Entity\ReceipientEntity;
use FaxingCenter\Entity\DocumentEntity;
require_once '/../init_autoloader.php';

// Build a receipient list
$receipients = array(
	new ReceipientEntity(array('fax_number'=>'13862345678')),
    new ReceipientEntity(array('fax_number'=>'13862345679'))		
);

// Attach some documents
$documents = array(
	new DocumentEntity(array(
		'file_name'=>'myfile.pdf',
		'file_data' => 'bas64 encode string content of myfile.pdf',
		'order'=> 0		
	)),
    new DocumentEntity(array(
		'file_name'=>'myfile2.pdf',
		'file_data' => 'bas64 encode string content of myfile2.pdf',
		'order'=> 1		
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
