<?php

use CodeIgniter\Router\RouteCollection; 

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index'); 
$routes->get('/authentication/(:any)', 'Home::authenticateUserPage/$1'); 
$routes->post('/verify/(:any)','Home::authUser/$1');
$routes->get('/error','Home::errPage'); 
$routes->setAutoRoute(true);