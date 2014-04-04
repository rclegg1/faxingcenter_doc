<?php
namespace FaxingCenter\Entity;

class BaseEntity{
	
	public function __construct($data = null){
		if($data !== null){
		  $this->populateEntity($data);		
		}
	}
	
	public function populateEntity($data){
	
		foreach(array_keys(get_class_vars(get_called_class())) as $key){
	
			if(is_array($data)){
				if(isset($data[$key])){
					$this->$key = $data[$key];
				}
			}
			else{
				if(isset($data->$key)){
					$this->$key = $data->$key;
				}
			}
		}
	}
	
	
}