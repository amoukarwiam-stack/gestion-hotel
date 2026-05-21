

<?php
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ChambreController;
use App\Http\Controllers\Api\ReservationController;
use Illuminate\Http\Request;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register-client', [AuthController::class, 'registerClient']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});//quelle user

Route::middleware(['auth:sanctum', 'role:Admin'])->group(function () {
    
    Route::post('/chambres', [ChambreController::class, 'store']);
    Route::put('/chambres/{id}', [ChambreController::class, 'update']);
    Route::delete('/chambres/{id}', [ChambreController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->get('/chambres', [ChambreController::class, 'index']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/reservations', [ReservationController::class, 'AjouterReservation']);
});
 
Route::middleware('auth:sanctum')->get('/mes-reservations', 
[ReservationController::class, 'mesReservations']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/reservations', [ReservationController::class, 'index']);

    Route::delete('/reservations/{id}', [ReservationController::class, 'SupprimerReservation']);

});

Route::middleware('auth:sanctum')
    ->get('/stats', [ReservationController::class, 'stats']);


    Route::middleware('auth:sanctum')
    ->get('/stats/monthly', [ReservationController::class, 'statsByMonth']);
    Route::middleware('auth:sanctum')
    ->get('/stats/rooms-types', [ReservationController::class, 'roomsTypes']);
    
    Route::post('/reservations/import/xml', [ReservationController::class, 'importXML']);
    
    
    Route::get('/reservations/export/xml', [ReservationController::class, 'exportXML']);
    
     Route::get('/reservation/{id}/pdf', [ReservationController::class, 'downloadPdf']);

    Route::middleware(['auth:sanctum', 'role:Admin'])->put('/reservations/{id}/etat', [ReservationController::class, 'changerEtat']);