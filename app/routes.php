<?php

//webshop and dashboard
$router->get('', 'HomeController@indexAction');
$router->post('', 'HomeController@searchAction');

//login and registration
$router->get('login', 'AuthController@loginAction');
$router->post('login', 'AuthController@loginSubmitAction');

$router->get('register', 'AuthController@registerAction');
$router->post('register', 'AuthController@registerSubmitAction');

$router->get('logout', 'AuthController@logoutAction');

//product pages
$router->get('product', 'ProductController@indexAction');
$router->get('product/create', 'ProductController@createAction');
$router->post('product/store', 'ProductController@storeAction');

//paydesk
$router->get('paydesk', 'PaydeskController@indexAction');
$router->post('paydesk', 'PaydeskController@indexAction');

$router->post('paydesk/cart', 'PaydeskController@addToCartAction');
$router->post('paydesk/remove', 'PaydeskController@removeAction');
$router->post('paydesk/process', 'PaydeskController@processAction');

//aquisition
$router->get('acquisition', 'AcquisitionController@indexAction');
$router->post('acquisition', 'AcquisitionController@indexAction');
$router->post('acquisition/cart', 'AcquisitionController@addToCartAction');
$router->post('acquisition/remove', 'AcquisitionController@removeAction');
$router->post('acquisition/process', 'AcquisitionController@processAction');


