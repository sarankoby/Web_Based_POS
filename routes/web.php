<?php
use App\Http\Controllers\LoginController;
use App\Http\Livewire\AccessModel;
use App\Http\Livewire\AccessPoint;
use App\Http\Livewire\Category;
use App\Http\Livewire\Permission;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\Users;
use App\Http\Livewire\UserType;

use Illuminate\Support\Facades\Route;

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
    return view('auth.login');
})->name('login');

Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::group(['middleware'=>['auth','access']],function(){
    
Route::get('/user-type', UserType::class)->name('user-type');
Route::get('/access-model', AccessModel::class)->name('access-model');
Route::get('/access-point/{id}', AccessPoint::class)->name('access-point');
Route::get('/permission/{id}', Permission::class)->name('permission');
Route::get('/users', Users::class)->name('users');
Route::get('/dashboard', Dashboard::class)->name('dashboard');
Route::get('/category', Category::class)->name('category');



});