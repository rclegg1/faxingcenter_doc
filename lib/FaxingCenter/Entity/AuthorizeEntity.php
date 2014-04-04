<?php
namespace FaxingCenter\Entity;

class AuthorizeEntity extends BaseEntity{
	/**
	 * 
	 * @var string
	 */	
	public $client_id;
	/**
	 * 
	 * @var string
	 */
	public $client_secret;
	
	/**
	 * 
	 * @var string
	 */
	public $grant_type;

}