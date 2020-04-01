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

    Route::resource('users' , 'UserController');
    Route::get('/user_find_id', 'UserController@find_id')->name('users.find.id');

    Route::resource('faqs' , 'FaqController');
    Route::get('/faq_find_id', 'FaqController@find_id')->name('faqs.find.id');

    Route::resource('questions','QuestionController');
    Route::get('/question_find_id', 'QuestionController@find_id')->name('question.find.id');

    Route::resource('contactsus','ContactsusController')->only('index','destroy');
    Route::get('/contactsus_find_id', 'ContactsusController@find_id')->name('contactsu.find.id');

    Route::resources(['orders' => 'OrderController']);
    Route::resources(['goods' => 'GoodsController']);
    Route::resources(['option' => 'OptionController']);
    Route::resources(['cart' => 'CartController']);

    Route::get('/cart_find_id', 'CartController@find_id')->name('cart.find.id');

    Route::get('/checking', 'CartController@cart_state_1')->name('cart_state_1'); //확인중
    Route::get('/payment_waiting', 'CartController@cart_state_2')->name('cart_state_2'); //결제대기중
    Route::get('/payment_completed', 'CartController@cart_state_3')->name('cart_state_3'); //결제완료
    Route::get('/data_extraction', 'CartController@cart_state_4')->name('cart_state_4'); //데이터추출중
    Route::get('/data_completed', 'CartController@cart_state_5')->name('cart_state_5'); //데이터추출완료

    Route::get('/upload_waiting', 'CartController@option_state_1')->name('option_state_1'); //업로드대기
    Route::get('/upload_request', 'CartController@option_state_2')->name('option_state_2'); //업로드요청
    Route::get('/upload_completed', 'CartController@option_state_3')->name('option_state_3'); //업로드완료


    Route::get('/file_download/{data_files}/{org_files}', 'CartController@file_download')->name('file_download');


    Route::get('/ajaxOptionStateChange', 'OptionController@stateChange')->name('options_statechange');

    Route::get('/ajaxTaxStateChange', 'OrderController@taxstateChange')->name('orders_taxstateChange');
});


