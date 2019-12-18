<?php
Route::middleware(['web', 'auth:web', 'IsUser'])->group(function () {
    Route::get('/user-panel', 'api\user\DefaultController@index');
    Route::get('/user-panel/{all}', 'api\user\DefaultController@index')->where(['all' => '.*']);

});

Route::prefix('api/user')
    ->namespace('api\user')
    ->name('user.')
    ->middleware(['web', 'auth:web', 'IsUser'])
    ->group(function () {
        // ============================== User ==============================
        Route::name('profile.')->prefix('profile')->group(function () {
            Route::get('/', 'UserController@profile')->name('profile');
            Route::put('/', 'UserController@update')->name('update');
        });
        // ============================== User ==============================

        // ============================== Cv ==============================
        Route::name('cv.')->prefix('cv')->group(function () {
            Route::get('/', 'CvController@show')->name('show');
            Route::post('/', 'CvController@store')->name('store');
        });
        // ============================== Cv ==============================

        // ============================== Company ==============================
        Route::name('companies.')->prefix('companies')->group(function () {
            Route::get('/', 'CompanyController@index')->name('index');
            Route::post('/upload-attachment/{id}', 'CompanyController@upload_attachment')->name('upload_attachment');
            Route::post('/upload-introduction', 'CompanyController@upload_introduction')->name('upload_introduction');
            Route::post('/', 'CompanyController@store')->name('store');
            Route::get('/{id}', 'CompanyController@getById')->name('getById');
            Route::post('/{id}/attachment', 'CompanyController@store_attachment')->name('store_attachment');
            Route::post('/{id}/work-sample', 'CompanyController@store_work_sample')->name('store_work_sample');
            Route::post('/{id}/member', 'CompanyController@store_member')->name('store_member');
            Route::put('/{company}', 'CompanyController@update')->name('update');
            Route::put('/attachment/{attachmentCompany}', 'CompanyController@update_attachment')->name('update_attachment');
            Route::put('/work-sample/{companyWorkSample}', 'CompanyController@update_work_sample')->name('update_work_sample');
            Route::put('/member/{companyMember}', 'CompanyController@update_member')->name('update_member');
            Route::get('/attachment/{attachmentCompany}', 'CompanyController@getAttachmentById')->name('get_attachment_by_id');
            Route::get('/work-sample/{companyWorkSample}', 'CompanyController@getWorkSampleById')->name('get_work_sample_by_id');
            Route::delete('/{company}', 'CompanyController@destroy')->name('destroy');
            Route::delete('/attachment/{attachmentCompany}', 'CompanyController@destroy_attachment')->name('destroy_attachment');
            Route::delete('/attachment/single/{attachmentCompany}', 'CompanyController@destroy_attachment_single')->name('destroy_attachment_single');
            Route::delete('/work-sample/{companyWorkSample}', 'CompanyController@destroy_work_sample')->name('destroy_work_sample');
            Route::delete('/member/{companyMember}', 'CompanyController@destroy_member')->name('destroy_member');
            Route::get('/attachment-list/{company_id}', 'CompanyController@attachment_list')->name('attachment_list');
            Route::get('/review/{company_id}', 'CompanyController@review')->name('review');
            Route::get('/attachments/type', 'CompanyController@attachment_type')->name('attachment_type');
            Route::get('/work-sample-list/{id}', 'CompanyController@work_sample_list')->name('work_sample_list');
            Route::get('/member-list/{company_id}', 'CompanyController@member_list')->name('member_list');
            Route::get('/member/{companyMember}', 'CompanyController@getMemberById')->name('get_member_by_id');
            Route::get('/check-attachment', 'CompanyController@check_attachment')->name('check_attachment');
            Route::get('/get-assessment/{id}', 'CompanyController@get_assessment')->name('get_assessment');
            Route::get('/reserved-project/{id}', 'CompanyController@reserved_projects')->name('reserved_projects');
            Route::get('/project/{id}', 'CompanyController@project')->name('project');

        });
        // ============================== Company ==============================

        // ============================== Category ==============================
        Route::get('/categories', 'CompanyController@category_list')->name('category_list');
        // ============================== Category==============================

        // ============================== Message ==============================
        Route::name('messages.')->prefix('messages')->group(function () {
            Route::get('/get-by-project-id/{project_id}', 'MessageController@get_by_project_id')->name('get_by_project_id');
            Route::post('/{id}/{fo?}', 'MessageController@store')->name('name');
            Route::get('/download/{id}', 'MessageController@download')->name('download');
            Route::post('/upload/file/d', 'MessageController@upload')->name('upload');
        });
        // ============================== Message ==============================

        // ============================== Project ==============================
        Route::name('projects.')->prefix('projects')->group(function () {
            Route::post('/{id}', 'ProjectController@store')->name('store');
            Route::get('/{id}', 'ProjectController@index')->name('index');
            Route::get('/get/{project}', 'ProjectController@getById')->name('getById');
            Route::put('/{project}', 'ProjectController@update')->name('update');
            Route::delete('/{project}', 'ProjectController@destroy')->name('destroy');
            Route::post('/upload-introduction/file', 'ProjectController@upload_introduction')->name('upload_introduction');
            Route::get('/{id}/detail', 'ProjectController@detail')->name('detail');
            Route::get('/reserved/{id}', 'ProjectController@reserved')->name('reserved');
            Route::get('/reserved-for-company/{id}/{pid}', 'ProjectController@reserved_for_company')->name('reserved_for_company');
            Route::get('/get-functor/{id}', 'ProjectController@get_functor')->name('get_functor');
            Route::get('/get-reserved-functor/{id}', 'ProjectController@get_reserved_functor')->name('get_reserved_functor');
        });
        // ============================== Project ==============================

    });


