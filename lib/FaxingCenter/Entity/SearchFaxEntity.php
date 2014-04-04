<?php
namespace FaxingCenter\Entity;

class SearchFaxEntity extends BaseEntity{
	
	/**
	 * 
	 * @var string
	 */
	public $from_date;
	/**
	 * 
	 * @var string
	 */
	public $to_date;
	/**
	 * 
	 * @var integer
	 */
	public $user_id;
	/**
	 * 
	 * @var integer
	 */
	public $p = 1;
	/**
	 * 
	 * @var integer
	 */
	public $status;
}