<?php

//webshop and dashboard
$router->get('', 'HomeController@indexAction');
$router->post('search', 'HomeController@searchAction');

//login and registration
$router->get('login', 'AuthController@loginAction');
$router->post('login', 'AuthController@loginSubmitAction');
$router->get('register', 'AuthController@registerAction');
$router->post('register', 'AuthController@registerSubmitAction');
$router->get('logout', 'AuthController@logoutAction');

// user pages
$router->get('user/show', 'UserController@showAction');
$router->get('user/edit', 'UserController@editAction');

//product pages
$router->get('product', 'ProductController@indexAction');
$router->get('product/create', 'ProductController@createAction');
$router->post('product/store', 'ProductController@storeAction');

$router->get('product/show?id=' . isset($_GET['id']), 'ProductController@showAction');


