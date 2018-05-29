<?php

use Illuminate\Routing\Router;

Admin::registerHelpersRoutes();

Route::group([
    // 'prefix'        => config('admin.prefix'),
    'namespace'     => Admin::controllerNamespace(),
    'middleware' => ['web', ],
  ],function (Router $router)
  {
    $router->get('auth/login', 'AuthController@getLogin');
    $router->post('auth/login', 'AuthController@postLogin');
  });

Route::group([
    // 'prefix'        => config('admin.prefix'),
    'namespace'     => Admin::controllerNamespace(),
    'middleware'    => ['web', 'admin'],
], function (Router $router) {
    $router->resource('wx/synimg','Wx\WxController');


    $router->get('auth/logout', 'AuthController@getLogout');
    $router->get('auth/setting', 'AuthController@getSetting');
    $router->put('auth/setting', 'AuthController@putSetting');
    $router->get('auth',function (){return redirect(url('auth/users'));});

 

    $router->resource('platform/question','Platform\QuestionController');

    $router->get('/', 'HomeController@index');    //index
    $router->resource('onesignal','OneSignalController');     //notification
    $router->get('404','Platform\StoreController@page401');       //404
    $router->resource('platform/logs','Platform\LogsController');      //logs
    
    $router->resource('platform/mail','Platform\MailController');     //Platform mail
    $router->get('platform/mail/{content_type}/{sender}/{title?}','Platform\MailController@select');
   
    $router->resource('platform/user','Platform\UserController');      //show user had sign in
    $router->resource('platform/role','Platform\RoleController');      //
    $router->resource('platform/rule','Platform\RuleController');     //
    
    $router->resource('test','TestController');      //just for test
});
