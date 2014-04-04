<?php
namespace FaxingCenter\Entity;

class SendFaxResponseEntity extends BaseEntity{
	
	/**
	 * 
	 * @var string
	 */
	public $sid;
	/**
	 * 
	 * @var SendFaxResponseResultEntity
	 */
	public $result;
	
}

class SendFaxResponseResultEntity extends BaseEntity{
	
	/**
	 * 
	 * @var integer
	 */
	public $total_documents;
	
	/**
	 * Returns an array of SendFaxResponseResultRecipientsEntity
	 * @var SendFaxResponseResultRecipientsEntity[]
	 */
	public $receipients;
	
}

class SendFaxResponseResultRecipientsEntity extends BaseEntity{
	
	/**
	 * 
	 * @var string
	 */
	public $mid;
	/**
	 * 
	 * @var string
	 */
	public $fax_number;
	/**
	 * integer
	 * @var unknown
	 */
	public $status;
	
}