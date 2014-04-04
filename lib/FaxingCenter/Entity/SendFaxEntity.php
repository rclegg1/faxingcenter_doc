<?php
namespace FaxingCenter\Entity;

class SendFaxEntity extends BaseEntity{
	
	/**
	 * Array of ReciepientEntity
	 * @var ReciepientEntity[]
	 */
	public $receipients;
	
	public $documents;
	
	public function populateEntity($data){
	
		foreach(array_keys(get_class_vars(get_called_class())) as $key){
	
			if(is_array($data)){
				if(isset($data[$key])){
					if(is_object($data[$key])){
						$class = get_class($data[$key]);
						$this->key = new $class($data[$key]);
					}
					else{
					  $this->$key = $data[$key];
					}
				}
			}
			else{
				if(isset($data->$key)){
					if(is_object($data->$key)){
						$class = get_class($data->$key);
						$this->key = new $class($data->$key);
					}else{
					  $this->$key = $data->$key;
					}
				}
			}
		}		
	}
	
}