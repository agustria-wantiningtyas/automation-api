<?php
$router->options(
    '/{any:.*}',
    [
        'middleware' => ['CorsMiddleware'],
        function () {
            return response(['status' => 'success']);
        },
    ]
);

$router->get('/', function () use ($router) {
    return $router->app->version();
});

// Generate random string
$router->get('appKey', function () {
    return str_random('32');
});

$router->group(['middleware' => 'CorsMiddleware'], function () use ($router) {
    $router->group(['prefix' => 'api'], function () use ($router) {
        // version
        $router->group(['prefix' => 'v1'], function () use ($router) {
            // muser
            $router->post('/login', 'UserController@login');

            // menu
            $router->post('/menu/index', 'MenuSettingController@index');
            $router->post('/menu/check-menu-access', 'MenuSettingController@checkMenuAccess');

            
            // employee
            $router->post('/employee/index', 'EmployeeController@index');
            $router->post('/employee/index/export', 'EmployeeController@indexExport');
            $router->post('/employee/show', 'EmployeeController@show');
            $router->post('/employee/store', 'EmployeeController@store');
            $router->post('/employee/update', 'EmployeeController@update');
            $router->post('/employee/delete', 'EmployeeController@delete');

            // feature
            $router->post('/feature/index', 'FeatureController@index');
            $router->post('/feature/store', 'FeatureController@store');
            $router->post('/feature/show', 'FeatureController@show');
            $router->post('/feature/update', 'FeatureController@update');

            // testcase
            $router->post('/testCase/index', 'TestCaseController@index');
            $router->post('/testCase/store', 'TestCaseController@store');
            $router->post('/testCase/show', 'TestCaseController@show');
            $router->post('/testCase/update', 'TestCaseController@update');
            $router->post('/testCase/showByStatus', 'TestCaseController@showByStatus');
            

            // run test
            $router->post('/run-test/index', 'RunHistoryController@index');
            $router->post('/run-test/excecute', 'RunHistoryController@store');
            $router->post('/report/index', 'RunHistoryController@report');


        });
    });

});
