<?php

$route['users/logout'] 	= "users/logout";
$route['users/account']	= "users/account";
$route['users/login'] 	= "users/login";
$route['users/signup'] 	= "users/signup";
$route['users/(:any)'] 	= "users/user/$1";

?>