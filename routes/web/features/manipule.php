<?php

Route::namespace('Manipule')->group(function () {
    Route::get('download', ExcelController::class . '@download');
});