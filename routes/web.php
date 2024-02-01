<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\FiscalYearController;
use App\Http\Controllers\MunicipalityController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
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

// Route::get('/test',[TestController::class, 'test']);
// Route::get('/test2',[TestController::class, 'test2']);
// Route::get('/test3',[TestController::class, 'test3']);
// Route::get('/test4',[TestController::class, 'test3']);
// Route::post('/result',[TestController::class, 'resultcp']);
// Route::get('/check',[TestController::class, 'check']);
// Route::get('/documents',[TestController::class, 'allDocuments']);
// Route::get('/md5check',[TestController::class, 'md5test']);
//Route::get('/interserver/{organization_identifier}',[TestController::class, 'interserverDepartment']);
//Route::middleware('interserver')->get('/interconnect/departments',[TestController::class, 'invokable']);

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');

// Route::get('/', [DashboardController::class,'index'])->name('dashboard');
Route::get('{reactRoutes}', function () {
    return view('welcome'); // your start view
})->where('reactRoutes', '^((?!api).)*$'); // except 'api' word
//intraserver
/*Route::get('/intraserver/users/{organization_identifier}',[TestController::class, 'interserverUsers']);
Route::get('/intraserver/departments/{organization_identifier}',[TestController::class, 'interserverDepartments']);
Route::get('/intraserver/department/users/{organization_identifier}/{department_id}',[TestController::class, 'interserverDepartmentUsers']);*/

//interserver
/*Route::middleware('interserver')->get('/interconnect',[TestController::class, 'invokable']);*/


/*//fiscal year
Route::get('/fiscal-years', [FiscalYearController::class,'index']);
//Route::get('/fiscal-year/all', [FiscalYearController::class,'getFiscalYear']);
Route::post('/fiscal-year/save',[FiscalYearController::class,'store']);
Route::put('/fiscal-year/update',[FiscalYearController::class,'update']);
Route::delete('/fiscal-year/delete/{id}',[FiscalYearController::class,'destroy']);

//provinces
Route::get('/provinces', [ProvinceController::class,'index']);
Route::post('/province/save',[ProvinceController::class,'store']);
Route::put('/province/update',[ProvinceController::class,'update']);
Route::delete('/province/delete/{id}',[ProvinceController::class,'destroy']);

//districts
Route::get('/districts', [DistrictController::class,'index']);
Route::post('/district/save',[DistrictController::class,'store']);
Route::put('/district/update',[DistrictController::class,'update']);
Route::delete('/district/delete/{id}',[DistrictController::class,'destroy']);

//municipalities
Route::get('/municipalities', [MunicipalityController::class,'index']);
Route::post('/municipality/save',[MunicipalityController::class,'store']);
Route::put('/municipality/update',[MunicipalityController::class,'update']);
Route::delete('/municipality/delete/{id}',[MunicipalityController::class,'destroy']);

//users
Route::get('/users', [UserController::class,'index']);
Route::post('/user/save', [UserController::class,'store']);
Route::put('/user/role-update', [UserController::class,'role_update']);
Route::delete('/user/delete/{id}',[UserController::class,'destroy']);

//roles
Route::get('/roles', [RoleController::class,'index']);
Route::post('/role/save', [RoleController::class,'store']);
Route::put('/role/update', [RoleController::class,'update']);
Route::delete('/role/delete/{id}',[RoleController::class,'destroy']);

//department
Route::get('/departments', [DepartmentController::class,'index']);
Route::post('/department/save',[DepartmentController::class,'store']);
Route::put('/department/update',[DepartmentController::class,'update']);
Route::delete('/department/delete/{id}',[DepartmentController::class,'destroy']);

//registrations
Route::get('/registrations', [RegistrationController::class,'index']);
Route::get('/registration/normal-registration', [RegistrationController::class,'normal_registration']);
Route::get('/registration/chalani-registration', [RegistrationController::class,'chalani_registration']);*/



