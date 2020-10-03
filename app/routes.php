<?php

//webshop and dashboard
$router->get('', 'HomeController@indexAction');
$router->post('', 'HomeController@indexAction');

//login and registration
$router->get('login', 'AuthController@loginAction');
$router->post('login', 'AuthController@loginSubmitAction');

$router->get('register', 'AuthController@registerAction');
$router->post('register', 'AuthController@registerSubmitAction');

$router->get('logout', 'AuthController@logoutAction');

//user controllers
$router->get('user', 'UserController@indexAction');
$router->get('user/edit', 'UserController@editAction');
$router->post('user/update', 'UserController@updateAction');


//product pages
$router->get('product', 'ProductController@indexAction');
$router->post('product', 'ProductController@indexAction');
$router->get('product/create', 'ProductController@createAction');
$router->post('product/store', 'ProductController@storeAction');

//paydesk
$router->get('paydesk', 'PaydeskController@indexAction');
$router->post('paydesk', 'PaydeskController@indexAction');

$router->post('paydesk/cart', 'PaydeskController@addToCartAction');
$router->post('paydesk/remove', 'PaydeskController@removeAction');
$router->post('paydesk/process', 'PaydeskController@processAction');
$router->get('paydesk/createPdf', 'PaydeskController@createPdfReceipt');

//acquisitions
$router->get('acquisition', 'AcquisitionController@indexAction');
$router->post('acquisition', 'AcquisitionController@indexAction');

$router->get('acquisition/create', 'AcquisitionController@createAction');
$router->post('acquisition/create', 'AcquisitionController@createAction');

if (isset($_GET['acquisitionId'])){
    $router->get('acquisition/show?acquisitionId=' . $_GET['acquisitionId'],
        'AcquisitionController@showAction');
}

$router->post('acquisition/cart', 'AcquisitionController@addToCartAction');
$router->post('acquisition/process', 'AcquisitionController@processAction');
$router->post('acquisition/complete', 'AcquisitionController@completeAction');
$router->post('acquisition/remove', 'AcquisitionController@removeAction');


