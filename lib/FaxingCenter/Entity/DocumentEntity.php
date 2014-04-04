<?php
namespace FaxingCenter\Entity;

class DocumentEntity extends BaseEntity{
	
	/**
	 * 
	 * @var string
	 */
	public $file_name;
	
	/**
	 *
	 * @var string
	 */
	public $file_data;
	
	/**
	 *
	 * @var integer
	 */
	public $order;	
}