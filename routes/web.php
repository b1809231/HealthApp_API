<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NguoiDungController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!*/



Route::get('/getdanhmuc', 'App\Http\Controllers\NguoiDungController@apidanhmuc');
Route::get('/getnhanvien', 'App\Http\Controllers\NguoiDungController@apinhanvien');
Route::get('/getnguoidung', 'App\Http\Controllers\NguoiDungController@apinguoidung');
Route::get('/getthongbao', 'App\Http\Controllers\NguoiDungController@apithongbao');
Route::get('/getlichtuvan', 'App\Http\Controllers\NguoiDungController@apilichtuvan');
Route::get('/getduoc', 'App\Http\Controllers\NguoiDungController@apiduoc');
Route::get('/getbenh', 'App\Http\Controllers\NguoiDungController@apibenh');
Route::get('/getbantin', 'App\Http\Controllers\NguoiDungController@apibantin');
Route::get('/getlhcuanv/{id}', 'App\Http\Controllers\NguoiDungController@getlhcuanv');
Route::get('/getlhcuand/{id}', 'App\Http\Controllers\NguoiDungController@getlhcuand');
Route::get('/gettbcuand/{id}', 'App\Http\Controllers\NguoiDungController@gettbcuand');
Route::get('/getchiso/{id}', 'App\Http\Controllers\NguoiDungController@apichiso');
Route::get('/getkhambenh/{id}', 'App\Http\Controllers\NguoiDungController@apikhambenh');
Route::get('/getsotiem/{id}', 'App\Http\Controllers\NguoiDungController@apisotiem');
Route::get('/getluyentap', 'App\Http\Controllers\NguoiDungController@apisotiem');
Route::get('/topnv', 'App\Http\Controllers\NguoiDungController@topnv');
Route::post('/xacnhanlich', 'App\Http\Controllers\NguoiDungController@xacnhanlich');
Route::post('/login', 'App\Http\Controllers\NguoiDungController@login');
Route::post('/editnd', 'App\Http\Controllers\NguoiDungController@editnd');
Route::post('/loginad', 'App\Http\Controllers\NguoiDungController@loginad');
Route::post('/editad', 'App\Http\Controllers\NguoiDungController@editad');
Route::post('/changepassadmin', 'App\Http\Controllers\NguoiDungController@changepassad');
Route::get('/timThuoc/{keyword}', 'App\Http\Controllers\NguoiDungController@timThuoc');
Route::post('/changepassnd', 'App\Http\Controllers\NguoiDungController@changepassnd');
Route::post('/register', 'App\Http\Controllers\NguoiDungController@register');
Route::post('/lichtuvan', 'App\Http\Controllers\NguoiDungController@lichtuvan');
Route::post('/chiso', 'App\Http\Controllers\NguoiDungController@chiso');
Route::post('/editchiso', 'App\Http\Controllers\NguoiDungController@editchiso');
Route::post('/editsotiem', 'App\Http\Controllers\NguoiDungController@editsotiem');
Route::post('/khambenh', 'App\Http\Controllers\NguoiDungController@khambenh');
Route::post('/sotiem', 'App\Http\Controllers\NguoiDungController@themsotiem');
Route::post('/uploadimage/{NV_ID}', 'App\Http\Controllers\NguoiDungController@uploadimage');
