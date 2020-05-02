<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Illuminate\Support\Facades\Schema;

Route::get('/', function () {
    return view('welcome');
});

Route::get('user/{id?}', function ($id = 1) {
    return 'user '.$id;
});

// prefix -> group
// Route admin
$prefixAdmin = config('test.url.prefix_admin');
// route news
$prefixNews = config('test.url.prefix_news');


Route::group(['prefix' => $prefixAdmin, 'middleware' => ['permission.admin']], function () {

    // ============route user
    $prefix = 'user';
    $controllerName = 'user';
    Route::group(['prefix' => $prefix], function () use($controllerName){
        // echo $prefix.'<br>';
        $controller = ucfirst($controllerName).'Controller@';

        Route::get('/', [
            'as' => $controllerName,
            'uses' => $controller.'index'
        ]);

        // Route::get('form/{id?}', $controller.'form')->where('id', '[0-9]+');
        Route::get('form/{id?}', [
            'as' => $controllerName . '/form',
            'uses' => $controller.'form'
        ])->where('id', '[0-9]+');

        Route::post('save', [
            'as' => $controllerName . '/save',
            'uses' => $controller.'save'
        ]);

        Route::post('change-password', [
            'as' => $controllerName . '/change-password',
            'uses' => $controller.'changePassword'
        ]);

        Route::post('change-level', [
            'as' => $controllerName . '/change-level',
            'uses' => $controller.'changeLevel'
        ]);

        // Route::get('delete/{id}', $controller.'delete')->where('id', '[0-9]+');
        Route::get('delete/{id}', [
            'as' => $controllerName. '/delete',
            'uses' => $controller. 'delete'
        ])->where('id', '[0-9]+');

        Route::get('change-status-{status}/{id}', [
            'as' => $controllerName. '/status',
            'uses' => $controller. 'status'
        ])->where('id', '[0-9]+');

        Route::get('change-level-{level}/{id}', [
            'as' => $controllerName. '/level',
            'uses' => $controller. 'level'
        ])->where('id', '[0-9]+');
    });

    // ============route dashboard
    $prefix = 'dashboard';
    $controllerName = 'dashboard';
    Route::group(['prefix' => $prefix], function () use($controllerName){

        $controller = ucfirst($controllerName).'Controller@';

        Route::get('/',     ['as' => $controllerName,   'uses' => $controller.'index']);
    });

    // ============route slider
    $prefix = 'slider';
    $controllerName = 'slider';
    Route::group(['prefix' => $prefix], function () use($controllerName){
        // echo $prefix.'<br>';
        $controller = ucfirst($controllerName).'Controller@';

        Route::get('/', [
            'as' => $controllerName,
            'uses' => $controller.'index'
        ]);

        // Route::get('form/{id?}', $controller.'form')->where('id', '[0-9]+');
        Route::get('form/{id?}', [
            'as' => $controllerName . '/form',
            'uses' => $controller.'form'
        ])->where('id', '[0-9]+');

        Route::post('save', [
            'as' => $controllerName . '/save',
            'uses' => $controller.'save'
        ]);

        // Route::get('delete/{id}', $controller.'delete')->where('id', '[0-9]+');
        Route::get('delete/{id}', [
            'as' => $controllerName. '/delete',
            'uses' => $controller. 'delete'
        ])->where('id', '[0-9]+');

        Route::get('change-status-{status}/{id}', [
            'as' => $controllerName. '/status',
            'uses' => $controller. 'status'
        ])->where('id', '[0-9]+');
    });

    // ============route category
    $prefix = 'category';
    $controllerName = 'category';
    Route::group(['prefix' => $prefix], function () use($controllerName){
        // echo $prefix.'<br>';
        $controller = ucfirst($controllerName).'Controller@';

        Route::get('/', [
            'as' => $controllerName,
            'uses' => $controller.'index'
        ]);

        // Route::get('form/{id?}', $controller.'form')->where('id', '[0-9]+');
        Route::get('form/{id?}', [
            'as' => $controllerName . '/form',
            'uses' => $controller.'form'
        ])->where('id', '[0-9]+');

        Route::post('save', [
            'as' => $controllerName . '/save',
            'uses' => $controller.'save'
        ]);

        // Route::get('delete/{id}', $controller.'delete')->where('id', '[0-9]+');
        Route::get('delete/{id}', [
            'as' => $controllerName. '/delete',
            'uses' => $controller. 'delete'
        ])->where('id', '[0-9]+');

        Route::get('change-status-{status}/{id}', [
            'as' => $controllerName. '/status',
            'uses' => $controller. 'status'
        ])->where('id', '[0-9]+');

        Route::get('change-isHome-{isHome}/{id}', [
            'as' => $controllerName. '/isHome',
            'uses' => $controller. 'isHome'
        ])->where('id', '[0-9]+');

        Route::get('change-display-{display}/{id}', [
            'as' => $controllerName. '/display',
            'uses' => $controller. 'display'
        ])->where('id', '[0-9]+');
    });

    // ============route article
    $prefix = 'article';
    $controllerName = 'article';
    Route::group(['prefix' => $prefix], function () use($controllerName){
        // echo $prefix.'<br>';
        $controller = ucfirst($controllerName).'Controller@';

        Route::get('/', [
            'as' => $controllerName,
            'uses' => $controller.'index'
        ]);

        // Route::get('form/{id?}', $controller.'form')->where('id', '[0-9]+');
        Route::get('form/{id?}', [
            'as' => $controllerName . '/form',
            'uses' => $controller.'form'
        ])->where('id', '[0-9]+');

        Route::post('save', [
            'as' => $controllerName . '/save',
            'uses' => $controller.'save'
        ]);

        // Route::get('delete/{id}', $controller.'delete')->where('id', '[0-9]+');
        Route::get('delete/{id}', [
            'as' => $controllerName. '/delete',
            'uses' => $controller. 'delete'
        ])->where('id', '[0-9]+');

        Route::get('change-status-{status}/{id}', [
            'as' => $controllerName. '/status',
            'uses' => $controller. 'status'
        ])->where('id', '[0-9]+');

        Route::get('change-type-{type}/{id}', [
            'as' => $controllerName. '/type',
            'uses' => $controller. 'type'
        ])->where('id', '[0-9]+');
    });

    // Route::get('test', function () {
    //     Schema::dropIfExists('failed_jobs');
    // });
    
    
});

Route::group(['prefix' => $prefixNews], function () {

    // ============route homepage
    $prefix = '';
    $controllerName = 'home';
    Route::group(['prefix' => $prefix], function () use($controllerName){

        $controller = ucfirst($controllerName).'Controller@';
        Route::get('/', [
            'as' => $controllerName,
            'uses' => $controller.'index'
        ]);
    });

    // ============route category 
    $prefix = 'chuyen-muc';
    $controllerName = 'categoryNews';
    Route::group(['prefix' => $prefix], function () use($controllerName){
        $controller = ucfirst($controllerName).'Controller@';

        Route::get('/{category_name}-{category_id}.html', [
            'as' => $controllerName . '/index',   
            'uses' => $controller.'index'
        ])
        ->where('category-name', '[0-9a-zA-Z_-]+')
        ->where('category-id', '[0-9]+');
    });

    // ============route article
    $prefix = 'bai-viet';
    $controllerName = 'articleNews';
    Route::group(['prefix' => $prefix], function () use($controllerName){
        $controller = ucfirst($controllerName).'Controller@';

        Route::get('/{article_name}-{article_id}.html', [
            'as' => $controllerName . '/index',   
            'uses' => $controller.'index'
        ])
        ->where('category-name', '[0-9a-zA-Z_-]+')
        ->where('category-id', '[0-9]+');
    });

    // ============route notify
    $prefix = '';
    $controllerName = 'notify';
    Route::group(['prefix' => $prefix], function () use($controllerName){
        $controller = ucfirst($controllerName).'Controller@';

        Route::get('/no-permission', [
            'as' => $controllerName . '/noPermission',   
            'uses' => $controller.'noPermission'
        ]);
    });

    // ============route login
    $prefix = '';
    $controllerName = 'auth';
    Route::group(['prefix' => $prefix], function () use($controllerName){
        $controller = ucfirst($controllerName).'Controller@';

        Route::get('/login', [
            'as' => $controllerName . '/login',   
            'uses' => $controller.'login'
        ])->middleware('check.login');

        Route::post('/postlogin', [
            'as' => $controllerName . '/postlogin',   
            'uses' => $controller.'postlogin'
        ]);

        Route::get('/logout', [
            'as' => $controllerName . '/logout',   
            'uses' => $controller.'logout'
        ]);
    });

});