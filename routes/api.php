<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\ChecklistController;
use App\Http\Controllers\ChecklistItemController;
use App\Http\Controllers\FolderController;
use Illuminate\Support\Facades\Route;


Route::group([
    "middleware" => "api",
    "namespace" => "App\Http\Controllers",
    "prefix" => "auth",
], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('refresh', [AuthController::class, 'refresh']);
    Route::delete('destroy', [AuthController::class, 'destroy']);
    Route::put('update', [AuthController::class, 'update']);
    Route::get('me', [AuthController::class, 'me']);
    Route::put('password', [AuthController::class, 'resetPassword']);
});

Route::apiResources([
    // "users" => UserController::class,
    "boards" => BoardController::class,
    "folders" => FolderController::class,
    "cards" => CardController::class,
    "checklists" => ChecklistController::class,
    "checklist_items" => ChecklistItemController::class,
]);

Route::get("users/{id}/boards", [BoardController::class, "getUserBoards"]);
Route::get("boards/{id}/folders", [FolderController::class, "getBoardFolders"]);
Route::get("folders/{id}/cards", [CardController::class, "getFolderCards"]);
Route::put("cards/{id}/move", [CardController::class, "move"]);
Route::put("checklist_items/{id}/toggle", [ChecklistItemController::class, "toggle"]);
