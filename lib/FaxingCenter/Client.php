<?php
namespace FaxingCenter;

use FaxingCenter\Entity\AuthorizeEntity;
use FaxingCenter\Entity\TokenEntity;
use FaxingCenter\Entity\SendFaxEntity;
use FaxingCenter\Entity\ErrorResponseEntity;
use FaxingCenter\Entity\SendFaxResponseEntity;
use FaxingCenter\Entity\FaxStatusResponseEntity;
use FaxingCenter\Entity\SearchFaxEntity;
use FaxingCenter\Entity\SearchResponseEntity;
class Client{
	
	/**
	 * 
	 * @var AuthorizeEntity
	 */
	protected $authorize_entity;
	
	/**
	 * 
	 * @var TokenEntity
	 */
	protected $token_entity;
	
	protected $_token_expires = 0;
	
	protected $_last_error;
	
	protected $_last_response;
	
	/**
	 * Get the status of a fax SID is required
	 * @param string $sid
	 * @param string $mid
	 * @return boolean
	 */
	public function getStatus($sid, $mid = null){
		$this->requestToken();
		$this->_last_error = $this->_last_response = null;
		
		$curl = curl_init();

		$qry_str = "?sid={$sid}";
		if($mid !== null && $mid !=''){
			$qry_str.="&mid={$mid}";
		}
		
		$url = 'https://api.faxingcenter/api/rest/fax/status' . $qry_str;
		
		$header = array(
				'Content-Type:application/json',
				'Accept: application/json',
				"Authorization: {$this->token_entity->token_type} {$this->token_entity->access_token}"
		);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		
			
		$result = curl_exec($curl);
		if (!$result) {
			echo 'An error has occurred: ' . curl_error($curl) . "\n";
		}
		else {
				
			if( curl_getinfo($curl, CURLINFO_HTTP_CODE) == '200'  ){
				$this->_last_response = new FaxStatusResponseEntity(json_decode($result));
				return true;
			}else{
				$this->_last_response = new ErrorResponseEntity(json_decode($result));
				return false;
			}
		}
		curl_close($curl);
	}
	
	public function search(SearchFaxEntity $entity){
		$this->requestToken();
		$this->_last_error = $this->_last_response = null;
		
		$curl = curl_init();
		
		$qry_str = array();
		//$qry_str[] = "from_date={$entity->from_date}";
		//$qry_str[] = "to_date={$entity->to_date}";
		
		foreach(array_keys(get_class_vars(get_class($entity))) as $key){
				if(isset($entity->$key) && $entity->$key !== null ){
					$v = urlencode($entity->$key);
					$qry_str[] = "{$key}={$v}";
				}
		}
		
		$url = 'https://api.faxingcenter.com/api/rest/fax/search?' . implode('&', $qry_str);
		
		$header = array(
				'Content-Type:application/json',
				'Accept: application/json',
				"Authorization: {$this->token_entity->token_type} {$this->token_entity->access_token}"
		);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		
			
		$result = curl_exec($curl);
		
	
		if (!$result) {
			echo 'An error has occurred: ' . curl_error($curl) . "\n";
		}
		else {
		
			if( curl_getinfo($curl, CURLINFO_HTTP_CODE) == '200'  ){
				$this->_last_response = new SearchResponseEntity(json_decode($result));
				return true;
			}else{
				$this->_last_response = new ErrorResponseEntity(json_decode($result));
				return false;
			}
		}
		curl_close($curl);
	}
	
	public function sendFax(SendFaxEntity $entity){
		$this->requestToken();
		$this->_last_error = $this->_last_response = null;
		
		$curl = curl_init();
		 
		$url = 'https://api.faxingcenter.com/api/rest/fax/send';
		 
		$json_payload = json_encode($entity);
		
		$header = array(
				'Content-Type:application/json',
				'Content-Length: ' . strlen($json_payload),
				'Accept: application/json',
				"Authorization: {$this->token_entity->token_type} {$this->token_entity->access_token}"
		);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $json_payload);
		 
		$result = curl_exec($curl);
		
		if (!$result) {
			echo 'An error has occurred: ' . curl_error($curl) . "\n";
		}
		else {
			
			if( curl_getinfo($curl, CURLINFO_HTTP_CODE) == '201' ){
				$this->_last_response = new SendFaxResponseEntity(json_decode($result));
				return true;
			}else{			
				$this->_last_response = new ErrorResponseEntity(json_decode($result));
				return false;				
			}
		}
		curl_close($curl);
			
		
	}
	/**
	 * 
	 * @return Ambigous <NULL, \FaxingCenter\Entity\ErrorResponseEntity, \FaxingCenter\Entity\SendFaxResponseEntity, \FaxingCenter\Entity\FaxStatusResponseEntity>
	 */
	public function getLastResponse(){
		return $this->_last_response;
	}
	
	public function getError(){
		return $this->_last_error;
	}
	
	public function __invoke(AuthorizeEntity $authorize_entity){
		$this->authorize_entity = $authorize_entity;
	}
	
	protected function hasAuthToken(){
		return is_a($this->token_entity, 'FaxingCenter\Entity\TokenEntity');
	}
	
	protected function requestToken(){
	  
	  if($this->hasAuthToken() && $this->_token_expires >= time()){
	  	return true;
	  }	  
	  
	  $curl = curl_init();
	  
	  $url = 'https://api.faxingcenter.com/oauth';
	  
	  
	  $json_payload = json_encode($this->authorize_entity);
	  
	  
	  $header = array(
	  		'Content-Type:application/json', 
	  		'Content-Length: ' . strlen($json_payload)
	  );
	  curl_setopt($curl, CURLOPT_URL, $url);
	  curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
	  curl_setopt($curl, CURLOPT_HEADER, false);
	  curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
	  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	  curl_setopt($curl, CURLOPT_POSTFIELDS, $json_payload);
	  
	  $result = curl_exec($curl);
	  
	  if (!$result) {
	  	echo 'An error has occurred: ' . curl_error($curl) . "\n";
	  }
	  else {
	  	$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);	  	
	  	if($status == '200'){
	      $this->token_entity = new TokenEntity(json_decode($result));
	      $this->_token_expires = time() + $this->token_entity->expires_in;
	  	}else{
	  		throw new \Exception('Request Failed: '. $status, $status);
	  	}	
	  }
	  curl_close($curl);	  
	}
		
	
}