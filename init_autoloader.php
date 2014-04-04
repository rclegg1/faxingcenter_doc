<?php 

chdir(__DIR__);

// Or, using an anonymous function as of PHP 5.3.0
spl_autoload_register(function ($class) {
	include 'lib/' . $class . '.php';
});

require_once 'config.php';
$client = new FaxingCenter\Client;
$client(new FaxingCenter\Entity\AuthorizeEntity($configs['auth']));
