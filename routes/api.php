<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TicketsController;
use App\Http\Controllers\RespensesController;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'getUser']);

    Route::get('/tickets', [TicketsController::class, 'index']); 
    Route::get('/my-tickets', [TicketsController::class, 'userTickets']);
    Route::get('/tickets/{id}', [TicketsController::class, 'show']); 
    Route::post('/tickets', [TicketsController::class, 'store']); 
    Route::put('/tickets/{id}', [TicketsController::class, 'update']); 
    Route::delete('/tickets/{id}', [TicketsController::class, 'destroy']); 

    Route::put('/tickets/{id}/start', [TicketsController::class, 'start']); 
    Route::put('/tickets/{id}/close', [TicketsController::class, 'close']); 

    Route::get('/tickets/open', [TicketsController::class, 'openTickets']); 
    Route::get('/tickets/in-progress', [TicketsController::class, 'inProgressTickets']); 
    Route::get('/tickets/closed', [TicketsController::class, 'closedTickets']); 

    Route::get('/tickets/{ticketId}/respenses', [RespensesController::class, 'index']);
    Route::post('/tickets/{ticketId}/respenses', [RespensesController::class, 'store']);
    Route::put('/respenses/{id}', [RespensesController::class, 'update']);
    Route::delete('/respenses/{id}', [RespensesController::class, 'destroy']);

});
