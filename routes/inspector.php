<?php
Route::middleware(['web', 'auth:web', 'IsInspector'])->group(function () {
    Route::get('/inspector-panel', 'api\inspector\DefaultController@index');
    Route::get('/inspector-panel/{all}', 'api\inspector\DefaultController@index')->where(['all' => '.*']);

    Route::prefix('api/inspector')
        ->namespace('api\inspector')
        ->name('inspector.')
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
                Route::get('/assessment/list', 'CompanyController@assessment_list')->name('assessment_list');

            });
            // ============================== Company ==============================

            // ============================== Team ==============================
            Route::name('Team.')->prefix('teams')->group(function () {
                Route::get('/', 'TeamController@index')->name('index');
                Route::post('/upload-attachment/{id}', 'TeamController@upload_attachment')->name('upload_attachment');
                Route::post('/', 'TeamController@store')->name('store');
                Route::get('/{id}', 'TeamController@getById')->name('getById');
                Route::post('/store-review/{team}', 'TeamController@store_review')->name('review');

                Route::put('/{team}', 'TeamController@update')->name('update');
                Route::delete('/{team}', 'TeamController@destroy')->name('destroy');
                Route::delete('/attachment/{attachmentCompany}', 'TeamController@destroy_attachment')->name('destroy_attachment');
                Route::get('/assessment/list', 'TeamController@assessment_list')->name('assessment_list');

            });
            // ============================== Team ==============================

        });
});


