<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\unite\categorieUnite;
use \App\Http\Controllers\unite\Unite;


/**
 *    <<<<< ROUTE CATEGORIE UNITE >>>>>
 */

Route::post('/categorieUniteAdd',[categorieUnite::class,"add"]);
Route::get('/categorieUniteDelete',[categorieUnite::class,"delete"]);
Route::post('/categorieUniteUpdate',[categorieUnite::class,"update"]);

/**
 *    <<<<< ROUTE CATEGORIE UNITE >>>>>
 */

Route::post('/getUnitesIdCategorie',[Unite::class,"getUnitesIdCategorie"]);
Route::post('/uniteAdd',[Unite::class,"add"]);
Route::get('/uniteDelete',[Unite::class,"delete"]);
Route::post('/uniteUpdate',[Unite::class,"update"]);