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
    Route::resources(['option' => 'OptionController']);
    Route::resources(['cart' => 'CartController']);

    Route::get('/cart_state_1', 'CartController@cart_state_1')->name('cart_state_1'); //결제대기중
    Route::get('/cart_state_2', 'CartController@cart_state_2')->name('cart_state_2'); //결제완료
    Route::get('/cart_state_3', 'CartController@cart_state_3')->name('cart_state_3'); //데이터추출중
    Route::get('/cart_state_4', 'CartController@cart_state_4')->name('cart_state_4'); //데이터추출완료

    Route::get('/option_state_1', 'CartController@option_state_1')->name('option_state_1'); //업로드대기
    Route::get('/option_state_2', 'CartController@option_state_2')->name('option_state_2'); //업로드요청
    Route::get('/option_state_3', 'CartController@option_state_3')->name('option_state_3'); //업로드완료

    Route::get('/ajaxOptionStateChange', 'OptionController@stateChange')->name('options_statechange');

    Route::get('/ajaxTaxStateChange', 'OrderController@taxstateChange')->name('orders_taxstateChange');
});


