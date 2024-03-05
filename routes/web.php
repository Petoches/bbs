<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Homepage');
});

Route::get('/debug', function() {

    $response = Http::withHeaders([
        'User-Agent' => config('services.instagram.user_agent'),
        'x-ig-app-id' => config('services.instagram.x_ig_app_id')
    ])->get('https://i.instagram.com/api/v1/users/web_profile_info/?username='.config('services.instagram.page'));


    dd($response->object());
});
