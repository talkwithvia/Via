<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\FarmsController;
use App\Http\Controllers\WardController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\AggregatorsController;
use App\Http\Controllers\ProduceCatalogueController;
use App\Http\Controllers\WarehouseSurveyController;
use App\Http\Controllers\WarehouseInspectorController;
use App\Http\Controllers\MarkingSchemeController;
use App\Http\Controllers\WarehouseInspectionController;
use App\Http\Controllers\BidderController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\WarehouseDispatchController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});


Route::prefix('error')->name('error.')->group(function () {
    Route::get('/{code}', function ($code) {
        abort($code);
    })->where('code', '401|403|404|419|429|500|503');
});

Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    return redirect()->route('admin.dashboard');
});

Route::middleware(['auth', 'checkUserStatus'])->group(function () {

    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name('profile');
        Route::put('/update', [ProfileController::class, 'update'])->name('profile.update');
    });

    // dashboard 
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/chart-data', [DashboardController::class, 'getChartData'])->name('dashboard.chart-data');
    Route::resource('users', UserController::class)->middleware('permission:view users|super-admin');

    // Extra route to attach roles
    Route::post('users/{user}/assign-role', [UserController::class, 'assignRole'])->name('users.assignRole');
    Route::post('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');

    // roles
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
    Route::get('/roles/{role}/permissions', [RoleController::class, 'permissions'])->name('roles.permissions');
    Route::put('/roles/{role}/permissions', [RoleController::class, 'updatePermissions'])->name('roles.permissions.update');

    Route::resource('activity-log', ActivityLogController::class);
    Route::get('/activity-logs/export', [ActivityLogController::class, 'export'])->name('activity-log.export');
    // resource routes
    Route::resource('warehouses', WarehouseController::class);
    // Import routes
    Route::prefix('warehouses')->name('warehouses.')->group(function () {
        Route::post('/import/preview', [WarehouseController::class, 'previewImport'])->name('import.preview');
        Route::post('/import/confirm', [WarehouseController::class, 'confirmImport'])->name('import.confirm');
        Route::get('/export/now', [WarehouseController::class, 'export'])->name('export');
        Route::get('/download/template', [WarehouseController::class, 'downloadTemplate'])->name('download-template');
    });

    // status toggles (optional) 
    Route::post('warehouses/{warehouse}/enable',  [WarehouseController::class, 'enable'])->name('warehouses.enable');
    Route::post('warehouses/{warehouse}/disable', [WarehouseController::class, 'disable'])->name('warehouses.disable');
    Route::post('warehousedetails/fetch', [WarehouseController::class, 'fetchAjaxDetails'])->name('warehousedetails.fetch');

    // cascading selects (web GET endpoints used by AJAX to populate form selects)
    Route::get('regions/{region}/districts',   [LocationController::class, 'districts'])->name('locations.districts');
    Route::get('districts/{district}/divisions', [LocationController::class, 'divisions'])->name('locations.divisions');
    Route::get('divisions/{division}/wards',   [LocationController::class, 'wards'])->name('locations.wards');



    // Routes for enabling/disabling regions
    Route::resource('regions', RegionController::class);

    Route::post('regions/{region}/disable', [RegionController::class, 'disable'])
        ->name('regions.disable');
    Route::post('regions/{region}/enable', [RegionController::class, 'enable'])
        ->name('regions.enable');
    Route::get('/regions/import', [RegionController::class, 'showImportForm'])->name('regions.import.form');
    Route::post('/regions/import/preview', [RegionController::class, 'previewImport'])->name('regions.import.preview');
    Route::post('/regions/import/confirm', [RegionController::class, 'confirmImport'])->name('regions.import.confirm');


    // districts
    Route::resource('districts', DistrictController::class);
    Route::post('districts/{district}/disable', [DistrictController::class, 'disable'])
        ->name('districts.disable');
    Route::post('districts/{district}/enable', [DistrictController::class, 'enable'])
        ->name('districts.enable');
    Route::get('/districts/import', [DistrictController::class, 'showImportForm'])->name('districts.import.form');
    Route::post('/districts/import/preview', [DistrictController::class, 'previewImport'])->name('districts.import.preview');
    Route::post('/districts/import/confirm', [DistrictController::class, 'confirmImport'])->name('districts.import.confirm');

    // divisions
    Route::resource('divisions', DivisionController::class);
    Route::post('divisions/{division}/disable', [DivisionController::class, 'disable'])
        ->name('divisions.disable');
    Route::post('divisions/{division}/enable', [DivisionController::class, 'enable'])
        ->name('divisions.enable');
    Route::post('/divisions/import/preview', [DivisionController::class, 'previewImport'])->name('divisions.import.preview');
    Route::post('/divisions/import/confirm', [DivisionController::class, 'confirmImport'])->name('divisions.import.confirm');

    // wards
    Route::resource('wards', WardController::class);
    Route::post('wards/{ward}/disable', [WardController::class, 'disable'])
        ->name('wards.disable');
    Route::post('wards/{ward}/enable', [WardController::class, 'enable'])
        ->name('wards.enable');
    Route::post('/wards/import/preview', [WardController::class, 'previewImport'])->name('wards.import.preview');
    Route::post('/wards/import/confirm', [WardController::class, 'confirmImport'])->name('wards.import.confirm');

    // types
    Route::resource('types', TypeController::class);
    Route::post('types/{type}/disable', [TypeController::class, 'disable'])
        ->name('types.disable');
    Route::post('types/{type}/enable', [TypeController::class, 'enable'])
        ->name('types.enable');

    // farms
    Route::resource('farms', FarmsController::class);
    Route::post('farms/{farm}/disable', [FarmsController::class, 'disable'])
        ->name('farms.disable');
    Route::post('farms/{farm}/enable', [FarmsController::class, 'enable'])
        ->name('farms.enable');

    // aggregators
    Route::resource('aggregators', AggregatorsController::class);
    Route::post('aggregators/{aggregator}/disable', [AggregatorsController::class, 'disable'])->name('aggregators.disable');
    Route::post('aggregators/{aggregator}/enable', [AggregatorsController::class, 'enable'])->name('aggregators.enable');
    Route::get('aggregators/{aggregatorId}/farms', [AggregatorsController::class, 'fetchFarms'])->name('aggregators.fetch-farms');
    Route::post('/aggregators/import/preview', [AggregatorsController::class, 'previewImport'])->name('aggregators.import.preview');
    Route::post('/aggregators/import/confirm', [AggregatorsController::class, 'confirmImport'])->name('aggregators.import.confirm');
    Route::get('/aggregators/export/all', [AggregatorsController::class, 'export'])->name('aggregators.export');


    // produce catalogue
    Route::resource('produce_catalogues', ProduceCatalogueController::class);
    Route::post('produce_catalogues/{produce_catalogue}/disable', [ProduceCatalogueController::class, 'disable'])
        ->name('produce_catalogues.disable');
    Route::post('produce_catalogues/{produce_catalogue}/enable', [ProduceCatalogueController::class, 'enable'])
        ->name('produce_catalogues.enable');

    // warehouse inspectors
    Route::prefix('warehouse-inspectors')->name('warehouse-inspectors.')->group(function () {
        Route::get('/datatable', [WarehouseInspectorController::class, 'datatableForWarehouse'])->name('datatable');
        Route::get('/unassigned', [WarehouseInspectorController::class, 'datatableUnassigned'])->name('unassigned');
        Route::get('/all', [WarehouseInspectorController::class, 'allInspectors'])->name('all');
        Route::post('/attach', [WarehouseInspectorController::class, 'attach'])->name('attach');
        Route::post('/attach-many', [WarehouseInspectorController::class, 'attachMany'])->name('attachMany');
        Route::post('/detach/{pivotId}', [WarehouseInspectorController::class, 'detach'])->name('detach');
    });


    Route::get('warehouse-inspections', [WarehouseInspectionController::class, 'index'])->name('warehouse-inspections.index');
    Route::get('warehouse-inspections/datatable', [WarehouseInspectionController::class, 'datatable'])->name('warehouse-inspections.datatable');
    Route::get('warehouse-inspections/{inspection}', [WarehouseInspectionController::class, 'show'])->name('warehouse-inspections.show');
    Route::get('warehouse-inspections/{inspection}/edit', [WarehouseInspectionController::class, 'edit'])->name('warehouse-inspections.edit');
    Route::put('warehouse-inspections/{inspection}', [WarehouseInspectionController::class, 'update'])->name('warehouse-inspections.update');

    Route::get('warehouse-dispatch', [WarehouseInspectionController::class, 'dispatch'])->name('warehouse-dispatch.index');
    Route::get('warehouse-dispatch/datatable', [WarehouseInspectionController::class, 'dispatchdatatable'])->name('warehouse-dispatch.datatable');
    Route::get('warehouse-dispatch/{inspection}', [WarehouseInspectionController::class, 'dispatchshow'])->name('warehouse-dispatch.show');
    Route::get('warehouse-dispatch/{inspection}/edit', [WarehouseInspectionController::class, 'dispatchedit'])->name('warehouse-dispatch.edit');
    Route::put('warehouse-dispatch/{inspection}', [WarehouseInspectionController::class, 'dispatchupdate'])->name('warehouse-dispatch.update');

    Route::get('bidders', [BidderController::class, 'index'])->name('bidders.index');
    Route::get('bidders/datatable', [BidderController::class, 'datatable'])->name('bidders.datatable');
    Route::patch('bidders/{bidder}/toggle-status', [BidderController::class, 'toggleStatus'])->name('bidders.toggle-status');
    Route::resource('bidders', BidderController::class);


    // warehouse survey questions 
    Route::get('survey-questions', [WarehouseSurveyController::class, 'index'])->name('survey-questions');
    Route::post('survey-questions/store', [WarehouseSurveyController::class, 'store'])->name('survey-questions.store');
    Route::post('survey-questions/update', [WarehouseSurveyController::class, 'update'])->name('survey-questions.update');
    Route::get('survey-questions/manage-answers', [WarehouseSurveyController::class, 'manageanswers'])->name('survey-questions.manage-answers');
    Route::post('survey-question-answer/store', [WarehouseSurveyController::class, 'storeanswers'])->name('survey-question-answer.store');
    Route::post('survey-question-answer/update', [WarehouseSurveyController::class, 'updateanswers'])->name('survey-question-answer.update');

    Route::get('surveys', [WarehouseSurveyController::class, 'surveyIndex'])->name('surveys');

    Route::get('surveys/show/{id}', [WarehouseSurveyController::class, 'surveyDetails'])->name('surveys.show');
    // Route::get('/surveys/{id}', [WarehouseSurveyController::class, 'surveyDetails'])->name('surveys.show');

    Route::post('surveys/create', [WarehouseSurveyController::class, 'surveycreate'])->name('surveys.create');
    Route::post('surveys/edit', [WarehouseSurveyController::class, 'surveyedit'])->name('surveys.edit');
    Route::get('surveys/manage-questions', [WarehouseSurveyController::class, 'managequestions'])->name('surveys.manage-questions');
    Route::get('surveys/manage-add-questions', [WarehouseSurveyController::class, 'manageaddquestions'])->name('surveys.manage-add-questions');
    Route::post('survey-questions/add-selected-questions', [WarehouseSurveyController::class, 'addQuestionsToSurvey'])->name('survey.questions.bulk-add');
    Route::post('/surveys/{survey}/toggle-status', [WarehouseSurveyController::class, 'toggleStatus']);
    Route::post('/surveys-question/{survey}/toggle-status', [WarehouseSurveyController::class, 'toggleStatusSurveyQuestion']);


    // marking scheme routes
    Route::get('/marking-scheme/{survey_id}', [MarkingSchemeController::class, 'index'])->name('marking-scheme.index');
    Route::post('/marking-scheme', [MarkingSchemeController::class, 'store'])->name('marking-scheme.store');
    Route::get('/marking-scheme/show/{id}', [MarkingSchemeController::class, 'show'])->name('marking-scheme.show');
    Route::delete('/marking-scheme/{id}', [MarkingSchemeController::class, 'destroy'])->name('marking-scheme.destroy');
    Route::get('/marking-scheme/check/{survey_id}', [MarkingSchemeController::class, 'checkSurvey'])->name('marking-scheme.check');


    // warehouse dispatch routes
    Route::get('/warehouse-dispatches/import', [WarehouseDispatchController::class, 'showImportForm'])->name('warehouse-dispatches.import.form');
    Route::get('/warehouse-dispatches/import/template', [WarehouseDispatchController::class, 'downloadTemplate'])->name('warehouse-dispatches.import.template');
    Route::post('/warehouse-dispatches/import/preview', [WarehouseDispatchController::class, 'previewImport'])->name('warehouse-dispatches.import.preview');
    Route::post('/warehouse-dispatches/import/confirm', [WarehouseDispatchController::class, 'confirmImport'])->name('warehouse-dispatches.import.confirm');
    // warehouse receive routes
    Route::get('/warehouse-receives/import', [WarehouseInspectionController::class, 'showImportForm'])->name('warehouse-receives.import.form');
    Route::get('/warehouse-receives/import/template', [WarehouseInspectionController::class, 'downloadTemplate'])->name('warehouse-receives.import.template');
    Route::post('/warehouse-receives/import/preview', [WarehouseInspectionController::class, 'previewImport'])->name('warehouse-receives.import.preview');
    Route::post('/warehouse-receives/import/confirm', [WarehouseInspectionController::class, 'confirmImport'])->name('warehouse-receives.import.confirm');
});
require __DIR__ . '/auth.php';
