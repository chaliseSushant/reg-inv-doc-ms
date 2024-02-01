<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\FileTypeController;
use App\Http\Controllers\FiscalYearController;
use App\Http\Controllers\InterserverController;
use App\Http\Controllers\IntraserverController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\MunicipalityController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\PrivilegeController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\RevisionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//Route::get('/documents',[TestController::class, 'allDocument']);
/*Route::get('/user', function (Request $request) {


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/


//login
Route::post('/login', [AuthController::class,'login']);
Route::get('/login', [AuthController::class,'login'])->name('login');
Route::middleware('auth:api')->post('/logout', [AuthController::class,'logout']);

//users
Route::middleware('privilege:manage-users_0100')->get('/users', [UserController::class,'index']);
Route::middleware('privilege:manage-users_0100')->get('/users/list', [UserController::class,'userList']);
Route::middleware('privilege:manage-users_1000')->post('/user/save', [UserController::class,'store']);
Route::middleware('privilege:manage-users_0010')->post('/user/role-update', [UserController::class,'role_update']);
Route::middleware('privilege:manage-users_0001')->delete('/user/delete/{id}',[UserController::class,'destroy']);

//activity & logging
Route::middleware('privilege:read-activities_0100')->get('/activities', [ActivityController::class,'index']);

//fiscal year
Route::get('/fiscal-years', [FiscalYearController::class,'index']);
//Route::get('/fiscal-year/all', [FiscalYearController::class,'getFiscalYear']);
Route::middleware('privilege:manage-fiscal-year_1000')->post('/fiscal-year/save',[FiscalYearController::class,'store']);
Route::middleware('privilege:manage-fiscal-year_0010')->post('/fiscal-year/update',[FiscalYearController::class,'update']);
Route::middleware('privilege:manage-fiscal-year_0001')->delete('/fiscal-year/delete/{id}',[FiscalYearController::class,'destroy']);

//provinces
Route::middleware('privilege:manage-provinces_0100')->get('/provinces', [ProvinceController::class,'index']);
Route::middleware('privilege:manage-provinces_1000')->post('/province/save',[ProvinceController::class,'store']);
Route::middleware('privilege:manage-provinces_0010')->post('/province/update',[ProvinceController::class,'update']);
Route::middleware('privilege:manage-provinces_0001')->delete('/province/delete/{id}',[ProvinceController::class,'destroy']);
Route::middleware('privilege:manage-provinces_0100')->get('/provinces/deleted', [ProvinceController::class,'trashedProvinces']);

//districts
Route::middleware('privilege:manage-districts_0100')->get('/districts', [DistrictController::class,'index']);
Route::middleware('privilege:manage-districts_1000')->post('/district/save',[DistrictController::class,'store']);
Route::middleware('privilege:manage-districts_0010')->post('/district/update',[DistrictController::class,'update']);
Route::middleware('privilege:manage-districts_0001')->delete('/district/delete/{id}',[DistrictController::class,'destroy']);
Route::middleware('privilege:manage-districts_0100')->get('/districts/province-districts/{province_id}',[DistrictController::class,'provinceDistricts']);
Route::middleware('privilege:manage-districts_0100')->get('/districts/deleted', [DistrictController::class,'trashedDistricts']);

//municipalities
Route::middleware('privilege:manage-municipalities_0100')->get('/municipalities', [MunicipalityController::class,'index']);
Route::middleware('privilege:manage-municipalities_1000')->post('/municipality/save',[MunicipalityController::class,'store']);
Route::middleware('privilege:manage-municipalities_0010')->post('/municipality/update',[MunicipalityController::class,'update']);
Route::middleware('privilege:manage-municipalities_0001')->delete('/municipality/delete/{id}',[MunicipalityController::class,'destroy']);
//Route::get('/municipality/municipality-details/{id}', [MunicipalityController::class,'municipalityDetails']);
Route::middleware('privilege:manage-municipalities_0100')->get('/municipalities/district-municipalities/{district_id}', [MunicipalityController::class,'districtMunicipalities']);
Route::middleware('privilege:manage-municipalities_0100')->get('/municipalities/deleted', [MunicipalityController::class,'trashedMunicipalities']);

//roles
Route::middleware('privilege:manage-roles_0100')->get('/roles', [RoleController::class,'index']);
Route::middleware('privilege:manage-roles_1000')->post('/role/save', [RoleController::class,'store']);
Route::middleware('privilege:manage-roles_0010')->post('/role/update', [RoleController::class,'update']);
Route::middleware('privilege:manage-roles_0001')->delete('/role/delete/{id}',[RoleController::class,'destroy']);
Route::middleware('privilege:manage-roles_0100')->get('/role/get-role-permission/{role_id}', [RoleController::class,'rolePermission']);
Route::middleware('privilege:manage-roles_0010')->post('/role/update-permission', [RoleController::class,'updatePermission']);
Route::middleware('auth:api')->get('/role/get-role-permission-user', [RoleController::class,'rolePermissionUser']);

//privileges
Route::middleware('privilege:manage-privileges_0100')->get('/privileges', [PrivilegeController::class,'index']);
Route::middleware('privilege:manage-privileges_1000')->post('/privilege/save',[PrivilegeController::class,'store']);
Route::middleware('privilege:manage-privileges_0010')->post('/privilege/update',[PrivilegeController::class,'update']);
Route::middleware('privilege:manage-privileges_0001')->delete('/privilege/delete/{id}',[PrivilegeController::class,'destroy']);

//service
Route::middleware('privilege:manage-services_0100')->get('/services', [ServiceController::class,'index']);
Route::middleware('privilege:manage-services_1000')->post('/service/save',[ServiceController::class,'store']);
Route::middleware('privilege:manage-services_0010')->post('/service/update',[ServiceController::class,'update']);
Route::middleware('privilege:manage-services_0001')->delete('/service/delete/{id}',[ServiceController::class,'destroy']);

//department
Route::middleware('privilege:manage-departments_0100')->get('/departments', [DepartmentController::class,'index']);
Route::middleware('privilege:manage-departments_0100')->get('/departments/list', [DepartmentController::class,'departmentList']);
Route::middleware('privilege:manage-departments_1000')->post('/department/save',[DepartmentController::class,'store']);
Route::middleware('privilege:manage-departments_0010')->post('/department/update',[DepartmentController::class,'update']);
Route::middleware('privilege:manage-departments_0001')->delete('/department/delete/{id}',[DepartmentController::class,'destroy']);
Route::middleware('privilege:manage-departments_0100')->get('/departments/deleted', [DepartmentController::class,'trashedDepartments']);

//registrations
Route::middleware('auth:api')->get('/registrations', [RegistrationController::class,'index']);
Route::middleware('auth:api')->get('/registrations/assigned', [RegistrationController::class,'assignedRegistrationsCurrentMonth']);
Route::middleware('auth:api')->get('/registrations/assigned/last-month', [RegistrationController::class,'assignedRegistrationsLastMonth']);
Route::middleware('auth:api')->get('/registrations/assigned/custom/{from}/{to}', [RegistrationController::class,'assignedRegistrationsCustomRange']);
Route::middleware('auth:api')->post('/registration/save', [RegistrationController::class,'store']);
Route::middleware('auth:api')->post('/registration/assign', [RegistrationController::class,'assignRegistration']);
Route::middleware('auth:api')->get('/registration/assigns/{registration_id}', [RegistrationController::class,'assignsRegistration']);
Route::middleware('auth:api')->get('/registration/delete/{id}', [RegistrationController::class,'destroyDraft']);
Route::middleware('auth:api')->get('/registration/document/{registration_id}', [RegistrationController::class,'viewDocument']);
Route::middleware('auth:api')->get('/registration/{id}', [RegistrationController::class,'viewRegistration']);

//revision
Route::middleware('auth:api')->get('/revisions/{file_id}', [RevisionController::class,'allRevision']);
Route::middleware('auth:api')->post('/revision/latest/save', [RevisionController::class, 'addLatestRevision']);
Route::middleware('auth:api')->delete('/revision/latest/delete/{file_id}', [RevisionController::class, 'destroyLatestRevision']);

//file type
Route::middleware('auth:api')->get('/file-types', [FileTypeController::class,'index']);
Route::middleware('auth:api')->post('/file-type/save', [FileTypeController::class,'store']);
Route::middleware('auth:api')->post('/file-type/update',[FileTypeController::class,'update']);
Route::middleware('auth:api')->delete('/file-type/delete/{id}',[FileTypeController::class,'destroy']);

//documents
Route::middleware('auth:api')->get('/documents', [DocumentController::class,'documentsCurrentMonth']);
Route::middleware('auth:api')->get('/document/{document_id}', [DocumentController::class,'viewDocument']);
Route::middleware('auth:api')->get('/documents/last-month', [DocumentController::class,'documentsLastMonth']);
Route::middleware('auth:api')->get('/documents/custom/{from}/{to}', [DocumentController::class,'documentsCustomRange']);
Route::middleware('auth:api')->post('/document/save', [DocumentController::class,'store']);
Route::middleware('auth:api')->post('/document/assign', [DocumentController::class,'assignDocument']);
Route::middleware('auth:api')->delete('/document/delete/{document_id}', [DocumentController::class,'destroy']);
Route::middleware('auth:api')->get('/document/files/{document_id}', [DocumentController::class,'documentFiles']);
Route::middleware('auth:api')->get('/document/registration-invoice/{document_id}', [DocumentController::class,'documentRegistrationInvoice']);

//file
Route::middleware('auth:api')->get('/file/{file_id}', [FileController::class,'fileRevision']);
Route::middleware('auth:api')->post('/file/add/save', [FileController::class,'addFiles']);

//invoice
Route::middleware('auth:api')->get('/invoices', [InvoiceController::class,'index']);
Route::middleware('auth:api')->get('/invoice/{invoice_id}', [InvoiceController::class,'viewInvoice']);
Route::middleware('auth:api')->get('/invoice/document/{invoice_id}', [InvoiceController::class,'viewDocument']);
Route::middleware('auth:api')->post('/invoice/save', [InvoiceController::class,'store']);

//organization
Route::middleware('auth:api')->middleware('interconnectPermission')->get('/organizations', [OrganizationController::class,'indexConfig']);

//notification
Route::middleware('auth:api')->get('/notification/unread', [NotificationController::class,'unreadNotification']);
Route::middleware('auth:api')->get('/notification/read', [NotificationController::class,'readNotification']);
Route::middleware('auth:api')->post('/notification/mark', [NotificationController::class,'markNotification']);
Route::middleware('auth:api')->get('/notification/mark-all', [NotificationController::class,'markAllNotification']);
Route::middleware('auth:api')->get('/notification/get-all', [NotificationController::class,'getAllNotification']);

//intraserver
Route::middleware('auth:api')->middleware('interconnectPermission')->get('/intraserver/users/{organization_identifier}',[IntraserverController::class, 'interserverUsers']);
Route::middleware('auth:api')->middleware('interconnectPermission')->get('/intraserver/departments/{organization_identifier}',[IntraserverController::class, 'interserverDepartments']);
Route::middleware('auth:api')->middleware('interconnectPermission')->get('/intraserver/department/users/{organization_identifier}/{department_id}',[IntraserverController::class, 'interserverDepartmentUsers']);
Route::middleware('auth:api')->middleware('interconnectPermission')->post('/intraserver/invoice', [IntraserverController::class, 'interserverInterconnectInvoice']);

//interserver
Route::middleware('interserver')->get('/interconnect/get',[InterserverController::class, 'invokableGet']);
Route::middleware('interserver')->post('/interconnect/post',[InterserverController::class, 'invokablePost']);


