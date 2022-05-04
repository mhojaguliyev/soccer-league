<?php

use App\Http\Controllers\API\FixturesController;
use App\Http\Controllers\API\TeamsController;
use Illuminate\Support\Facades\Route;

Route::get('standings', [TeamsController::class, 'index']);
Route::get('fixtures', [TeamsController::class, 'fixtures']);
Route::get('predictions', [TeamsController::class, 'predictions']);

Route::post('reset', [TeamsController::class, 'reset']);

Route::post('generate-fixtures', [FixturesController::class, 'generateAll']);
Route::post('play-all', [FixturesController::class, 'playAll']);
Route::post('play-next', [FixturesController::class, 'nextWeek']);

