<?php
Route::middleware(['web', 'auth:web', 'IsClient'])->group(function () {
    Route::get('/client-panel', 'api\client\DefaultController@index');
    Route::get('/client-panel/{all}', 'api\client\DefaultController@index')->where(['all' => '.*']);

    Route::prefix('api/client')
        ->namespace('api\client')
        ->name('client.')
        ->group(function () {

            // ============================== User ==============================
            Route::name('profile.')->prefix('profile')->group(function () {
                Route::get('/', 'UserController@profile')->name('profile');
                Route::put('/', 'UserController@update')->name('update');
            });
            // ============================== User ==============================

            // ============================== Company ==============================
            Route::name('companies.')->prefix('companies')->group(function () {
                Route::get('/', 'CompanyController@index')->name('index');
                Route::post('/upload-attachment/{id}', 'CompanyController@upload_attachment')->name('upload_attachment');
                Route::post('/', 'CompanyController@store')->name('store');
                Route::get('/{id}', 'CompanyController@getById')->name('getById');
                Route::post('/store-review/{company_id}', 'CompanyController@store_review')->name('review');
                Route::post('/{id}/attachment', 'CompanyController@store_attachment')->name('store_attachment');
                Route::put('/{company}', 'CompanyController@update')->name('update');
                Route::put('/attachment/{attachmentCompany}', 'CompanyController@update_attachment')->name('update_attachment');
                Route::get('/attachment/{attachmentCompany}', 'CompanyController@getAttachmentById')->name('get_attachment_by_id');
                Route::delete('/{company}', 'CompanyController@destroy')->name('destroy');
                Route::delete('/attachment/{attachmentCompany}', 'CompanyController@destroy_attachment')->name('destroy_attachment');
                Route::delete('/attachment/single/{attachmentCompany}', 'CompanyController@destroy_attachment_single')->name('destroy_attachment_single');
                Route::get('/attachment-list/{company_id}', 'CompanyController@attachment_list')->name('attachment_list');
            });
            // ============================== Company ==============================

            // ============================== Category ==============================
            Route::get('/categories', 'CompanyController@category_list')->name('category_list');
            // ============================== Category==============================

            // ============================== Project ==============================
            Route::name('projects.')->prefix('projects')->group(function () {
                Route::post('/', 'ProjectController@store')->name('store');
                Route::get('/', 'ProjectController@index')->name('index');
                Route::get('/{id}', 'ProjectController@getById')->name('getById');
                Route::put('/{project}', 'ProjectController@update')->name('update');
                Route::delete('/{id}', 'ProjectController@destroy')->name('destroy');
                Route::post('/upload-introduction', 'ProjectController@upload_introduction')->name('upload_introduction');
                Route::get('/{id}/detail', 'ProjectController@detail')->name('detail');
                Route::get('/reserved/{id}', 'ProjectController@reserved')->name('reserved');
                Route::get('/get-functor/{id}', 'ProjectController@get_functor')->name('get_functor');
                Route::get('/get-developer/{id}', 'ProjectController@get_developer')->name('get_developer');
            });
            // ============================== Project ==============================

            // ============================== Work Samples ==============================
            Route::name('work-sample.')->prefix('work-sample')->group(function () {
                Route::get('/', 'WorkSampleController@list')->name('list');
                Route::post('/', 'WorkSampleController@store')->name('store');
                Route::put('/{id}', 'WorkSampleController@update')->name('update_work_sample');
                Route::delete('/{id}', 'WorkSampleController@destroy')->name('destroy');
                Route::get('/{id}', 'WorkSampleController@get_by_id')->name('get_by_id');
                Route::post('/upload-introduction', 'WorkSampleController@upload_introduction')->name('upload_introduction');
            });
            // ============================== Work Samples ==============================

            // ============================== Reserved Project ==============================
            Route::name('reserved-projects.')->prefix('reserved-projects')->group(function () {
                Route::get('/', 'ReservedProjectController@index')->name('list');
                Route::get('/{id}', 'ReservedProjectController@get_by_id')->name('get_by_id');
                Route::get('/get-owner/{project}', 'ReservedProjectController@get_owner')->name('get_owner');
            });
            // ============================== Reserved Project ==============================

            // ============================== Message ==============================
            Route::name('messages.')->prefix('messages')->group(function () {
                Route::get('/get-by-project-id/{project_id}', 'MessageController@get_by_project_id')->name('get_by_project_id');
                Route::post('/{id}/{fo?}', 'MessageController@store')->name('name');
                Route::get('/download/{id}', 'MessageController@download')->name('download');
                Route::post('/upload/file/d', 'MessageController@upload')->name('upload');
            });
            // ============================== Message ==============================
        });
});


