<?php
namespace FaxingCenter\Entity;

class ErrorResponseEntity extends BaseEntity{
	
	/**
	 * 
	 * @var integer
	 */
	public $code;	
	/**
	 *
	 * @var string
	 */
	public $type;
	/**
	 *
	 * @var integer
	 */
	public $status;
	/**
	 *
	 * @var string
	 */
	public $title;
	/**
	 *
	 * @var string
	 */
	public $detail;
	
	
}