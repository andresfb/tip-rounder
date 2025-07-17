<?php

use App\Http\Controllers\CalculateTipController;
use Illuminate\Support\Facades\Route;

Route::middleware('throttle:30,2')->group(static function (): void {

    Route::get('/', static function () {
        $tip = (float) config('constants.base_tip_percentage');

        return view('welcome', ['tip' => $tip]);
    })
        ->name('home');

    Route::post('/tip', CalculateTipController::class)
        ->name('tip');

});
