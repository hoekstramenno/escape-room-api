<?php

use Illuminate\Http\Request;
use Illuminate\Routing\Router;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*
* Snippet for a quick route reference
*/
Route::prefix('v1')
     ->group(static function () {
         Route::namespace('Api')
              ->group(static function () {
                  Route::resource('tasks', 'TaskController', [
                      'only' => ['index', 'show', 'store', 'update', 'destroy'],
                  ]);
                  Route::get('tasks/icons', 'IconController@icons')->name('tasks.icons');
                  Route::post('tasks/validate', 'CodeController@validateCode')->name('code.validate');
                  Route::post('security/register', 'TeamController@register')->name('team.register');
              });
     });
