<?php
namespace FaxingCenter\Entity;

class FaxStatusResponseEntity extends BaseEntity{
	
	/**
	 * Array of FaxStatusResponseMessageEntity
	 * @var FaxStatusResponseMessageEntity[]
	 */
	public $results;
	
	/**
	 * 
	 * @var PagerResponseEntity
	 */
	public $pager;
	
	public function populateEntity($data){
		parent::populateEntity($data);
		if(isset($data->results) && is_array($data->results)){
			$this->results = array();
			foreach($data->results as $item){
				$this->results[] = new FaxStatusResponseMessageEntity($item);
			}
		}
		if(isset($data->pager)){
			$this->pager = new PagerResponseEntity($data->pager);
		}
	}	
}

class FaxStatusResponseMessageEntity extends BaseEntity{
	
	/**
	 * Send Id
	 * @var string
	 */
	public $sid;
	/**
	 * Message Id
	 * @var string
	 */
	public $mid;
	/**
	 * Fax number
	 * @var string
	 */
	public $fax_number;
	/**
	 * Status of message
	 * @var integer
	 */
	public $status;
	/**
	 * DateTime fax was sent
	 * @var string
	 */
	public $sent_on;
	/**
	 *DateTim fax was received
	 * @var string
	 */
	public $received_on;
	/**
	 * Pages for this fax
	 * @var integer
	 */
    public $pages;
    /**
     * Connection attemps
     * @var integer
     */
    public $attempts;
    /**
     * User Id that sent the fax
     * @var integer
     */
    public $user_id;
    /**
     * Account Id that sent the fax
     * @var integer
     */
    public $account_id;
	
	
}