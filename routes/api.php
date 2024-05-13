<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardStatsController;
use App\Http\Controllers\FixtureController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\StandingController;
use App\Http\Controllers\TeamController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class,'logout']);
});



Route::group([
    'middleware' => 'api',
    'prefix'=>'teams',
], function ($router) {
    Route::get('', [TeamController::class, 'getTeams']);
    Route::get('{id}', [TeamController::class, 'getTeam']);
});

Route::group([
    'middleware' => 'auth:api',
    'prefix'=>'teams',
], function ($router) {
    Route::post('', [TeamController::class, 'createTeam']);
    Route::put('{id}', [TeamController::class, 'updateTeam']);
    Route::delete('{id}', [TeamController::class, 'deleteTeam']);
});

Route::group([
    'middleware' => 'api',
    'prefix'=>'players',
], function ($router) {
    Route::get('', [PlayerController::class, 'getPlayers']);
    Route::get('{id}', [PlayerController::class, 'getPlayer']);
});

Route::group([
    'middleware' => 'auth:api',
    'prefix'=>'players',
], function ($router) {
    Route::post('', [PlayerController::class, 'createPlayer']);
    Route::put('{id}', [PlayerController::class, 'updatePlayer']);
    Route::delete('{id}', [PlayerController::class, 'deletePlayer']);
});

Route::group([
    'middleware' => 'api',
    'prefix'=>'players',
], function ($router) {
    Route::get('', [PlayerController::class, 'getPlayers']);
    Route::get('{id}', [PlayerController::class, 'getPlayer']);
});

Route::group([
    'middleware' => 'auth:api',
    'prefix'=>'players',
], function ($router) {
    Route::post('', [PlayerController::class, 'createPlayer']);
    Route::put('{id}', [PlayerController::class, 'updatePlayer']);
    Route::delete('{id}', [PlayerController::class, 'deletePlayer']);
});

Route::group([
    'middleware' => 'api',
    'prefix'=>'fixtures',
], function ($router) {
    Route::get('', [FixtureController::class, 'getFixtures']);
    Route::get('{id}', [FixtureController::class, 'getFixture']);
});

Route::group([
    'middleware' => 'auth:api',
    'prefix'=>'fixtures',
], function ($router) {
    Route::post('', [FixtureController::class, 'createFixture']);
    Route::put('{id}', [FixtureController::class, 'updateFixture']);
    Route::delete('{id}', [FixtureController::class, 'deleteFixture']);
});

Route::group([
    'middleware' => 'api',
    'prefix'=>'results',
], function ($router) {
    Route::get('', [ResultController::class, 'getResults']);
    Route::get('{id}', [ResultController::class, 'getResult']);
});

Route::group([
    'middleware' => 'auth:api',
    'prefix'=>'results',
], function ($router) {
    Route::post('', [ResultController::class, 'createResult']);
    Route::put('{id}', [ResultController::class, 'updateResult']);
    Route::delete('{id}', [ResultController::class, 'deleteResult']);
});

Route::group([
    'middleware' => 'api',
    'prefix'=>'standings',
], function ($router) {
    Route::get('', [StandingController::class, 'getStandings']);
    Route::get('{id}', [StandingController::class, 'getStanding']);
});

Route::group([
    'middleware' => 'auth:api',
    'prefix'=>'standings',
], function ($router) {
    Route::post('', [StandingController::class, 'createStanding']);
    Route::put('{id}', [StandingController::class, 'updateStanding']);
    Route::delete('{id}', [StandingController::class, 'deleteStanding']);
});

//Dashboard stats
Route::group([
    'middleware' => 'api',
    'prefix'=>'stats',
], function ($router) {
    Route::get('', [DashboardStatsController::class, 'stats']);
   
});

//HomePage
Route::group([
    'middleware' => 'api',
    'prefix'=>'homepage',
], function ($router) {
    Route::get('fixtures', [HomePageController::class, 'upcomingFixtures']);
    Route::get('players', [HomePageController::class, 'newPlayers']);
    Route::get('result', [HomePageController::class, 'latestResult']);
    Route::get('standings', [HomePageController::class, 'standings']);
});







