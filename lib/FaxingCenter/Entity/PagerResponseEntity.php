<?php
namespace FaxingCenter\Entity;

class PagerResponseEntity extends BaseEntity{
	
	/**
	 * Which page are you on
	 * @var integer
	 */
	public $pageCount;
	
	/**
	 * How many items per page
	 * @var integer
	 */
	public $itemCountPerPage;
	
	/**
	 * First page number
	 * @var integer
	 */
	public $first;
	
	/**
	 * Current page number
	 * @var integer
	 */
	public $current;
	
	/**
	 * Last page number
	 * @var integer
	 */
	public $last;
	
	/**
	 * How many items are on this pate
	 * @var integer
	 */
	public $currentItemCount;
	
	/**
	 * How many items in the total
	 * @var integer
	 */
	public $totaltemCount;
	
	/**
	 * First item number
	 * @var integer
	 */
	public $firstItemNumber;
	
	/**
	 * Last item number
	 * @var integer
	 */
	public $lastItemNumber;
	
	/**
	 * 
	 * @var array
	 */
	public $_links;
	
}