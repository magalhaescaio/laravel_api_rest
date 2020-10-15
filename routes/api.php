<?php

Route::apiResource('companies', 'App\Http\Controllers\Api\CompanyController');

Route::apiResource('{id_company?}/participants', 'App\Http\Controllers\Api\ParticipantController');

