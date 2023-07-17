<?php

use App\Api\V1\Controllers\TalkProposalsListController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'], function () {
    Route::get('talk-proposals', TalkProposalsListController::class)->name('api.v1.talk-proposals-list');
});
