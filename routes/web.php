<?php

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
    if (auth()->user()) {
        return redirect()->route('backoffice');
    } else {
        return redirect()->route('login');
    }
});

// 권한 예외 처리
Route::get('/role', function() {
    Auth::logout();

    return view('role');
})->name('role');

Auth::routes();


Route::middleware(['auth', 'role'])->group( function () {
    Route::get('/backoffice', function () {
        return view('backoffice');
    })->name('backoffice');

    Route::resources(['users' => 'UserController']);
    Route::resources(['faqs' => 'FaqController']);
    Route::resources(['questions' => 'QuestionController']);
    Route::resources(['orders' => 'OrderController']);
    Route::resources(['goods' => 'GoodsController']);
});


