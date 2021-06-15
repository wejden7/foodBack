<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\ingredion\CategorieIngredionController;
use \App\Http\Controllers\ingredion\IngredionController;

 /**
  *   <<<<<  ROUTE CATEGORIE INGREDION  >>>>>
  */
  
  Route::post('/categorieIngredionAdd',[CategorieIngredionController::class,"add"]);
  Route::get('/categorieIngredionDelete',[CategorieIngredionController::class,"delete"]);
  Route::post('/categorieIngredionUpdate',[CategorieIngredionController::class,"update"]);

  /**
   *   <<<<<  ROUTE INGREDION  >>>>>
   */

  Route::get('/getAll',[IngredionController::class,"getAll"]);
  Route::post('/getId',[IngredionController::class,"getId"]);
  Route::post('/ingredionAdd',[IngredionController::class,"add"]);
  Route::get('/ingredionDelete',[IngredionController::class,"delete"]);
  Route::post('/ingredionUpdate',[IngredionController::class,"update"]);
  Route::post('/ingredionUpdateImage',[IngredionController::class,"updateImage"]);
  