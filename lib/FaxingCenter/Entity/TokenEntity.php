<?php
namespace FaxingCenter\Entity;

class TokenEntity extends BaseEntity{
	
	/**
	 * 
	 * @var string
	 */
	public $access_token;
	
	/**
	 * 
	 * @var integer
	 */
	public $expires_in;
	
	/**
	 * 
	 * @var string
	 */
	public $token_type;
	
}