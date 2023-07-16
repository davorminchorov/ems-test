<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SpeakerSignUpController;
use App\Http\Controllers\SpeakerSignUpPageController;
use App\Http\Controllers\TalkProposalSubmissionController;
use App\Http\Controllers\TalkProposalSubmissionPageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/speakers/sign-up', SpeakerSignUpPageController::class)->name('speakers.sign-up-page');
    Route::post('/speakers', SpeakerSignUpController::class)->name('speakers.sign-up');

    Route::get('/talk-proposals/submit', TalkProposalSubmissionPageController::class)->name('talk-proposals.submission-page');
    Route::post('/talk-proposals', TalkProposalSubmissionController::class)->name('talk-proposals.submit');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
