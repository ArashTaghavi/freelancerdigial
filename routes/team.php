<?php
Route::middleware(['web', 'auth:web', 'IsTeam'])->group(function () {
    Route::get('/team-panel', 'api\team\DefaultController@index');
    Route::get('/team-panel/{all}', 'api\team\DefaultController@index')->where(['all' => '.*']);

    Route::prefix('api/team')
        ->namespace('api\team')
        ->name('team.')
        ->group(function () {

            // ============================== User ==============================
            Route::name('profile.')->prefix('profile')->group(function () {
                Route::get('/', 'UserController@profile')->name('profile');
                Route::put('/', 'UserController@update')->name('update');
            });
            // ============================== User ==============================

            // ============================== Team ==============================
            Route::name('teams.')->prefix('teams')->group(function () {
                Route::get('/', 'TeamController@index')->name('index');
                Route::post('/', 'TeamController@store')->name('store');
                Route::post('/upload-introduction', 'TeamController@upload_introduction')->name('upload_introduction');
                Route::put('/{team}','TeamController@update')->name('update');
                Route::get('/work-sample-list/{team_id}','TeamController@work_sample_list')->name('work-sample-list');
                Route::put('/work-sample/{teamWorkSample}','TeamController@update_work_sample')->name('update_work_sample');
                Route::post('/{id}/work-sample','TeamController@store_work_sample')->name('store_work_sample');
                Route::put('/work-sample/{id}','TeamController@update_work_sample')->name('update_work_sample');
                Route::get('/work-sample/{teamWorkSample}','TeamController@getWorkSampleById')->name('get_work_sample_by_id');
                Route::delete('/work-sample/{teamWorkSample}', 'TeamController@destroy_work_sample')->name('destroy_work_sample');
                Route::delete('/{id}', 'TeamController@destroy')->name('destroy');
                Route::delete('/member/{id}', 'TeamController@destroy_member')->name('destroy_member');
                Route::get('/member-list/{team_id}', 'TeamController@member_list')->name('member_list');
                Route::get('/member/{memberTeam}', 'TeamController@getMemberById')->name('get_member_by_id');
                Route::post('/{id}/member', 'TeamController@store_member')->name('store_member');
                Route::put('/member/{id}', 'TeamController@update_member')->name('update_member');
                Route::get('/{id}', 'TeamController@getById')->name('getById');
                Route::get('/review/{team_id}', 'TeamController@review')->name('review');
                Route::post('/work-sample/upload', 'TeamController@upload_work_sample')->name('upload_work_sample');
                Route::get('/reserved-project/{id}', 'TeamController@reserved_projects')->name('reserved_projects');
                Route::get('/project/{id}', 'TeamController@project')->name('project');

            });
            // ============================== Team ==============================

            // ============================== Category ==============================
            Route::get('/categories', 'TeamController@category_list')->name('category_list');
            // ============================== Category==============================

            // ============================== Project ==============================
            Route::name('projects.')->prefix('projects')->group(function () {
                Route::post('/{id}', 'ProjectController@store')->name('store');
                Route::get('/{id}', 'ProjectController@index')->name('index');
                Route::get('/get/{project}', 'ProjectController@getById')->name('getById');
                Route::put('/{id}', 'ProjectController@update')->name('update');
                Route::delete('/{project}', 'ProjectController@destroy')->name('destroy');
                Route::post('/upload-introduction/file', 'ProjectController@upload_introduction')->name('upload_introduction');
                Route::get('/{id}/detail', 'ProjectController@detail')->name('detail');
                Route::get('/reserved/{id}', 'ProjectController@reserved')->name('reserved');
                Route::get('/reserved-for-team/{id}/{pid}', 'ProjectController@reserved_for_team')->name('reserved_for_team');
                Route::get('/get-functor/{id}', 'ProjectController@get_functor')->name('get_functor');
                Route::get('/get-reserved-functor/{id}', 'ProjectController@get_reserved_functor')->name('get_reserved_functor');

            });
            // ============================== Project ==============================

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


