<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MaritimeAgentController;
use App\Http\Controllers\MooringOperatorController;
use App\Http\Controllers\PortFacilityController;
use App\Http\Controllers\PortFacilityTypeController;
use App\Http\Controllers\TugboatCompanyController;
use App\Http\Controllers\UserAgentController;
use App\Http\Controllers\VoyageController;
use App\Http\Controllers\EventPlanningController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/maritime-agent-user-agent', [MaritimeAgentController::class, 'store_user_agent']);
Route::apiResource('maritime-agent', MaritimeAgentController::class);

Route::post('/mooring-operator-user-agent', [MooringOperatorController::class, 'store_user_agent']);
Route::apiResource('mooring-operator', MooringOperatorController::class);

Route::post('/port-facility-user-agent', [PortFacilityController::class, 'store_user_agent']);
Route::apiResource('port-facility', PortFacilityController::class);

Route::get('/port-facility-types', [PortFacilityTypeController::class, 'index']);
Route::apiResource('port-facility-type', PortFacilityTypeController::class);

Route::post('/tugboat-company-user-agent', [TugboatCompanyController::class, 'store_user_agent']);
Route::apiResource('tugboat-company', TugboatCompanyController::class);

Route::get('/user-agent-registration', [UserAgentController::class, 'index']);
Route::post('/user-agent-registration', [UserAgentController::class, 'store']);
Route::get('/user-agent-registration/{userAgent}', [UserAgentController::class, 'show']);
Route::patch('/user-agent-registration/{userAgent}', [UserAgentController::class, 'update']);
Route::delete('/user-agent-registration/{userAgent}', [UserAgentController::class, 'destroy']);

Route::get('/voyage/acceptance', [VoyageController::class, 'index_acceptance']);
Route::post('/voyage/acceptance', [VoyageController::class, 'store_acceptance']);
Route::patch('/voyage/{voyage}/acceptance', [VoyageController::class, 'update_acceptance']);
Route::get('/voyage/{voyage}/status', [VoyageController::class, 'show_status']);
Route::post('/voyage/vessel-operator-response', [VoyageController::class, 'store_vessel_operator_response']);
Route::apiResource('voyage', VoyageController::class);

Route::post('/event-planning/{voyage}', [EventPlanningController::class, 'store']);
Route::get('/event-planning/{voyage}', [EventPlanningController::class, 'index']);
