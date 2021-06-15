<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\post\categoriePost;
use \App\Http\Controllers\post\EtapeController;
use \App\Http\Controllers\post\PostController;
use \App\Http\Controllers\post\IngredionPostController;
use \App\Http\Controllers\post\jaimeController;
use \App\Http\Controllers\post\CommentController;



/**
 *    <<<<< ROUTE CATEGORIE POST >>>>>
*/

Route::post('/categoriePostAdd',[categoriePost::class,"add"]);
Route::get('/categoriePostDelete',[categoriePost::class,"delete"]);
Route::get('/getAllCategorie',[categoriePost::class,"getAllCategorie"]);
Route::post('/categoriePostUpdate',[categoriePost::class,"update"]);

/**
 *    <<<<< ROUTE POST >>>>>
*/
   
Route::post('/postAdd',[PostController::class,"add"]);
Route::get('/getAll',[PostController::class,"getAll"])->middleware(['auth:api']);
Route::post('/getPostId',[PostController::class,"getPostId"])->middleware(['auth:api']);
Route::get('/postDelete',[PostController::class,"delete"]);
Route::post('/postUpdate',[PostController::class,"update"]);
Route::post('/postUpdateImage',[PostController::class,"updateImage"]);

/**
 *    <<<<< ROUTE ETAPE >>>>>>
*/

Route::post('/getEtapeIdPost',[EtapeController::class,"getEtapeIdPost"]);
Route::post('/etapeAdd',[EtapeController::class,"add"]);
Route::get('/etapeDelete',[EtapeController::class,"delete"]);
Route::post('/etapeUpdate',[EtapeController::class,"update"]);

/**
 *    <<<<< ROUTE INGREDION POST >>>>>>
*/

Route::post('/getIngredionIdPost',[IngredionPostController::class,"getIngredionIdPost"]);
Route::post('/ingredionPostAdd',[IngredionPostController::class,"add"]);
Route::get('/ingredionPostDelete',[IngredionPostController::class,"delete"]);
Route::post('/ingredionPostUpdate',[IngredionPostController::class,"update"]);

/**
 *  * ROUTE JAIME POST
*/

Route::post('/jaimePostAdd',[jaimeController::class,"jaimePostAdd"])->middleware(['auth:api']);
Route::post('/jaimePostDelete',[jaimeController::class,"jaimePostDelete"])->middleware(['auth:api']);


/**
 *  * ROUTE COMMENT POST
 */

Route::post('/getAllCommentPostId',[CommentController::class,"getAllCommentPostId"]);

