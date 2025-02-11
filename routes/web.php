<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Route;

Route::prefix("/position")
    ->name("position.")
    ->group(function () {
        Route::get("/", Position\ListController::class)->name("list");
        Route::post("/", Position\CreateController::class)->name("create");
        Route::post("/routing", Position\RoutingController::class)->name("routing");

        Route::prefix("/{id}")
            ->whereUuid("id")
            ->group(function () {
                Route::get("/", Position\GetController::class)->name("get");
                Route::post("/", Position\UpdateController::class)->name("update");
            });
    });
