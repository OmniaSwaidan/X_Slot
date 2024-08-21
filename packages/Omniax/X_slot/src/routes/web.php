<?php

use Illuminate\Support\Facades\Route;


Route::resource('xslots', 'Omniax\X_slot\Controllers\XslotController');
Route::post('xslots/{xslot}/book', 'Omniax\X_slot\Controllers\XslotController@bookSlot');
Route::post('xslots/{xslot}/cancel', 'Omniax\X_slot\Controllers\XslotController@cancelBooking');
Route::view('/','index');


