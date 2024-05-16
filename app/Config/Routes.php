<?php

use CodeIgniter\Router\RouteCollection; 

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index');
$routes->get('/home/authenticateUserPage/(:any)', 'Home::authenticateUserPage/$1');

// $routes->get('/home/authenticateUserPage'.$setToken, 'Home::authenticateUserPage');
$routes->setAutoRoute(true);