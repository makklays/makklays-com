<?php

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

// sitemap
Route::get('sitemap.xml', 'App\Http\Controllers\MysiteController@sitemap')->name('sitemap');

// bot
Route::match(['get', 'post'], 'bota', ['as' => 'bota', 'uses' => 'App\Http\Controllers\BotController@index']);

Route::get('/', function () {
    return redirect( app()->getLocale() );
});

Auth::routes();

Route::group([
    'prefix' => '{locale}',
    'where' => ['locale' => '[a-zA-Z]{2}'],
    'middleware' => 'setlocale'
], function () {

    // main
    Route::get('', 'App\Http\Controllers\MysiteController@main')->name('/');

    // home
    Route::get('home', 'App\Http\Controllers\HomeController@index')->name('home');

    // main pages
    Route::get('about-us', ['as' => 'mysite_about', 'uses' => 'App\Http\Controllers\MysiteController@about']);
    Route::get('we-making', ['as' => 'mysite_howmake', 'uses' => 'App\Http\Controllers\MysiteController@howmake']);
    Route::get('development-site-store', ['as' => 'mysite_whatmake', 'uses' => 'App\Http\Controllers\MysiteController@whatmake']);
    Route::get('request', ['as' => 'mysite_request', 'uses' => 'App\Http\Controllers\MysiteController@request']);
    Route::get('contacts', ['as' => 'mysite_contacts', 'uses' => 'App\Http\Controllers\MysiteController@contacts']);
    Route::get('brief', ['as' => 'mysite_brief', 'uses' => 'App\Http\Controllers\MysiteController@brief']);
    Route::get('download-price', ['as' => 'mysite_download_price', 'uses' => 'App\Http\Controllers\MysiteController@downloadPrice']);

    Route::get('online-brief', ['as' => 'mysite_online_brief', 'uses' => 'App\Http\Controllers\MysiteController@onlineBrief']);
    Route::post('online-brief', ['as' => 'mysite_online_brief_post', 'uses' => 'App\Http\Controllers\MysiteController@onlineBriefPost']);

    Route::get('landing-page', ['as' => 'mysite_lpage', 'uses' => 'App\Http\Controllers\MysiteController@lpage']);
    Route::get('corporate-site', ['as' => 'mysite_corporate', 'uses' => 'App\Http\Controllers\MysiteController@corporate']);
    Route::get('api-service', ['as' => 'mysite_webservice', 'uses' => 'App\Http\Controllers\MysiteController@webservice']);
    Route::get('web-portal', ['as' => 'mysite_webportal', 'uses' => 'App\Http\Controllers\MysiteController@webportal']);
    Route::get('site-system', ['as' => 'mysite_sitesytem', 'uses' => 'App\Http\Controllers\MysiteController@sitesytem']);
    Route::get('online-store', ['as' => 'mysite_store', 'uses' => 'App\Http\Controllers\MysiteController@store']);
    Route::get('privacy-policy', ['as' => 'privacy-policy', 'uses' => 'App\Http\Controllers\MysiteController@privacy_policy']);

    Route::get('black-list', ['as' => 'mysite_blacklist', 'uses' => 'App\Http\Controllers\MysiteController@blacklist']);
    Route::post('call-development-post', ['as' => 'call_development_post', 'uses' => 'App\Http\Controllers\MysiteController@callDevelopmentPost']);

    Route::get('seo-words', ['as' => 'seo_words', 'uses' => 'App\Http\Controllers\MysiteController@countSeoWords']);
    Route::post('seo-words', ['as' => 'seo_words_post', 'uses' => 'App\Http\Controllers\MysiteController@countSeoWordsPost']);

    // site
    Route::get('article/{slug}', 'App\Http\Controllers\MysiteController@showArticle')->name('article');
    Route::get('articles', 'App\Http\Controllers\MysiteController@listArticles')->name('articles');

    Route::get('main', ['as' => 'main', function () {
        return view('test'); // 'main'
    }]);

    Route::get('wait', 'App\Http\Controllers\FeedbackController@wait')->name('wait');
    Route::get('wait2', 'App\Http\Controllers\FeedbackController@wait2')->name('wait2');

    // ivga
    Route::get('ivga', 'App\Http\Controllers\HomeController@ivga')->name('ivga');

    // feedback
    Route::get('feedback', 'App\Http\Controllers\MysiteController@feedback')->name('feedback');
    Route::post('feedback_post', 'App\Http\Controllers\MysiteController@feedback_post')->name('feedback_post');

    // ----------- тест на знание PHP
    Route::get('test-php', ['as' => 'test-php', 'uses' => 'App\Http\Controllers\TestController@intro']);
    Route::post('test-php-start', ['as' => 'test-php-start', 'uses' => 'App\Http\Controllers\TestController@start']);

    Route::get('test-php/question-1', ['as' => 'test_php_q1', 'uses' => 'App\Http\Controllers\TestController@question1']);
    Route::post('test-php/answer-1',  ['as' => 'test_php_a1', 'uses' => 'App\Http\Controllers\TestController@answer1']);
    Route::get('test-php/question-2', ['as' => 'test_php_q2', 'uses' => 'App\Http\Controllers\TestController@question2']);
    Route::post('test-php/answer-2',  ['as' => 'test_php_a2', 'uses' => 'App\Http\Controllers\TestController@answer2']);
    Route::get('test-php/question-3', ['as' => 'test_php_q3', 'uses' => 'App\Http\Controllers\TestController@question3']);
    Route::post('test-php/answer-3',  ['as' => 'test_php_a3', 'uses' => 'App\Http\Controllers\TestController@answer3']);
    Route::get('test-php/question-4', ['as' => 'test_php_q4', 'uses' => 'App\Http\Controllers\TestController@question4']);
    Route::post('test-php/answer-4',  ['as' => 'test_php_a4', 'uses' => 'App\Http\Controllers\TestController@answer4']);

    Route::get('test-php/report',  ['as' => 'test_php_report_get', 'uses' => 'App\Http\Controllers\TestController@report']);
    Route::post('test-php/report', ['as' => 'test_php_report_post', 'uses' => 'App\Http\Controllers\TestController@sendEmail']);
    // ----------------------------------


    // -------------- Adminka
    Route::get('admin/home', ['as' => 'home', 'uses' => 'App\Http\Controllers\HomeController@index'])->name('home');

    Route::get('admin/adm-articles', ['as' => 'adm-articles', 'uses' => 'App\Http\Controllers\ArticlesController@list']);
    Route::match(['get', 'post'],'admin/adm-article-add', ['as' => 'adm-article-add', 'uses' => 'App\Http\Controllers\ArticlesController@add']);
    Route::match(['get', 'post'],'admin/adm-article-edit/{article_id}', ['as' => 'adm-article-edit', 'uses' => 'App\Http\Controllers\ArticlesController@edit'])->where(['article_id' => '[0-9]+']);
    Route::match(['get', 'post'],'admin/adm-article-delete/{article_id}', ['as' => 'adm-article-delete', 'uses' => 'App\Http\Controllers\ArticlesController@delete'])->where(['article_id' => '[0-9]+']);

    Route::get('admin/adm-orders', ['as' => 'adm-orders', 'uses' => 'App\Http\Controllers\OrdersController@index']);
    Route::match(['get', 'post'],'admin/adm-order-add', ['as' => 'adm-order-add', 'uses' => 'App\Http\Controllers\OrdersController@add']);
    Route::match(['get', 'post'],'admin/adm-order-edit/{order_id}', ['as' => 'adm-order-edit', 'uses' => 'App\Http\Controllers\OrdersController@edit'])->where(['order_id' => '[0-9]+']);
    Route::match(['get', 'post'],'admin/adm-order-delete/{order_id}', ['as' => 'adm-order-delete', 'uses' => 'App\Http\Controllers\OrdersController@delete'])->where(['order_id' => '[0-9]+']);
    Route::get('admin/adm-order-view/{order_id}', ['as' => 'adm-order-view', 'uses' => 'App\Http\Controllers\OrdersController@view'])->where(['order_id' => '[0-9]+']);

    Route::get('admin/adm-call', ['as' => 'adm-call', 'uses' => 'App\Http\Controllers\CallController@index']);
    Route::get('admin/adm-blacklist', ['as' => 'adm-blacklist', 'uses' => 'App\Http\Controllers\CallController@blacklist']);

    Route::get('admin/profile', ['as' => 'profile', 'uses' => 'App\Http\Controllers\MysiteController@myProfile']);
    Route::post('admin/profile-post', ['as' => 'profile-post', 'uses' => 'App\Http\Controllers\MysiteController@myProfilePost']);
    Route::get('admin/settings', ['as' => 'settings', 'uses' => 'App\Http\Controllers\MysiteController@settings']);
    Route::get('admin/statistics', ['as' => 'statistics', 'uses' => 'App\Http\Controllers\MysiteController@statistics']);
    Route::get('admin/visits', ['as' => 'visits', 'uses' => 'App\Http\Controllers\VisitsController@listAll']);
    Route::get('admin/visits_days', ['as' => 'visits_days', 'uses' => 'App\Http\Controllers\VisitsController@listAllbyDays']);

    Route::get('admin/report', ['as' => 'report', 'uses' => 'App\Http\Controllers\MysiteController@report']);
    Route::get('admin/report-cat-dog', ['as' => 'report-cat-dog', 'uses' => 'App\Http\Controllers\MysiteController@reportCatDog']);

    Route::get('admin/documents', ['as' => 'documents', 'uses' => 'App\Http\Controllers\MysiteController@documents']);

    /* dashboard */
    Route::get('admin/dashboard', [
        'as' => 'dashboard', 'uses' => 'App\Http\Controllers\MysiteController@dashboard'
    ]);
    /* companies */
    Route::get('admin/companies', [
        'as' => 'companies', 'uses' => 'App\Http\Controllers\CompaniesController@showCompanies'
    ]);
    Route::match(['get', 'post'], 'admin/companies/add', [
        'as' => 'company_add', 'uses' => 'App\Http\Controllers\CompaniesController@addCompany'
    ]);
    Route::match(['get', 'post'], 'admin/companies/del/{id}', [
        'as' => 'company_delete', 'uses' => 'App\Http\Controllers\CompaniesController@delete'
    ])->where(['id' => '[0-9]+']);
    Route::match(['get', 'post'], 'admin/companies/edit/{id}', [
        'as' => 'company_edit', 'uses' => 'App\Http\Controllers\CompaniesController@edit'
    ])->where(['id' => '[0-9]+']);
    Route::get('admin/companies/view/{id}', [
        'as' => 'company_view', 'uses' => 'App\Http\Controllers\CompaniesController@view'
    ])->where(['id' => '[0-9]+']);

    /* employees */
    Route::get('admin/employees', [
        'as' => 'employees', 'uses' => 'App\Http\Controllers\EmployeesController@showEmployees'
    ]);
    Route::match(['get', 'post'], 'admin/employees/add', [
        'as' => 'employee_add', 'uses' => 'App\Http\Controllers\EmployeesController@addEmployee'
    ]);
    Route::match(['get', 'post'], 'admin/employees/del/{id}', [
        'as' => 'employee_delete', 'uses' => 'App\Http\Controllers\EmployeesController@delete'
    ])->where(['id' => '[0-9]+']);
    Route::match(['get', 'post'], 'admin/employees/edit/{id}', [
        'as' => 'employee_edit', 'uses' => 'App\Http\Controllers\EmployeesController@edit'
    ])->where(['id' => '[0-9]+']);

    /* about me */
    Route::get('admin/about2', ['as' => 'about', 'uses' => 'App\Http\Controllers\TodoController@about2']); // биография

    /* cvs */
    Route::get('admin/cvs', ['as' => 'cvs', 'uses' => 'App\Http\Controllers\CvsController@lista']);

    /* jobs - vacancies */
    Route::get('admin/jobs', ['as' => 'jobs', 'uses' => 'App\Http\Controllers\JobsController@lista']);

    /* cvs add */
    Route::get('admin/cvs/add', ['as' => 'cvs_add', 'uses' => 'App\Http\Controllers\CvsController@add']);
    Route::post('admin/cvs/add', ['as' => 'cvs_add_post', 'uses' => 'App\Http\Controllers\CvsController@addPost'])->middleware('mobile.redirect');

    /* cvs favorites */
    Route::get('admin/cvs/favorites', ['as' => 'cvs_favorites', 'uses' => 'App\Http\Controllers\CvsController@favorites']);
    Route::post('admin/cvs/change-favorite/{vacancia_id}', [
        'as' => 'cvs_change_favorite', 'uses' => 'App\Http\Controllers\CvsController@changeFavorite'
    ])->where(['vacancia_id' => '[0-9]+']);
    /* cvs recommend */
    Route::get('admin/cvs/recommend', ['as' => 'cvs_recommend', 'uses' => 'App\Http\Controllers\CvsController@recommend']);

    Route::get('admin/upl', [
        'as' => 'upl', 'uses' => 'App\Http\Controllers\TodoController@UploadT'
    ]);

    /* packages */
    Route::get('admin/packages', [
        'as' => 'packages', 'uses' => 'App\Http\Controllers\PackageController@listPackages'
    ]);
    Route::match(['get','post'], 'admin/package/{id}', [
        'as' => 'package', 'uses' => 'App\Http\Controllers\PackageController@package'
    ])->where(['id' => '[0-9]+']);
    Route::match(['get','post'], 'admin/package/payment_success', [ // post method
        'uses' => 'App\Http\Controllers\PackageController@payment_success'
    ]);
    Route::match(['get','post'], 'admin/package/payment_cancel', [ // post method
        'uses' => 'App\Http\Controllers\PackageController@payment_cancel'
    ]);
    Route::match(['get','post'], 'admin/package/payment_notify', [ // post method
        'uses' => 'App\Http\Controllers\PackageController@payment_notify'
    ]);

    /* to do */
    Route::get('admin/todo', [
        'as' => 'todo', 'uses' => 'App\Http\Controllers\TodoController@listTodo'
    ]);
    Route::match(['get'], 'admin/todo/{id}', [
        'as' => 'todo_item', 'uses' => 'App\Http\Controllers\TodoController@item'
    ])->where(['id' => '[0-9]+']);
    Route::match(['get','post'], 'admin/todo/add', [
        'as' => 'todo_add', 'uses' => 'App\Http\Controllers\TodoController@add'
    ]);
    Route::match(['get','post'], 'admin/todo/edit/{id}', [
        'as' => 'todo_edit', 'uses' => 'App\Http\Controllers\TodoController@edit'
    ])->where(['id' => '[0-9]+']);
    Route::match(['get','post'], 'admin/todo/del/{id}', [
        'as' => 'todo_del', 'uses' => 'App\Http\Controllers\TodoController@del'
    ])->where(['id' => '[0-9]+']);

    // feedback
    Route::get('admin/feedbacks', ['as' => 'feedbacks', 'uses' => 'App\Http\Controllers\FeedbackController@index']);
    Route::get('admin/feedback/show/{id}', ['as' => 'feedback_show', 'uses' => 'App\Http\Controllers\FeedbackController@show'])->where(['id' => '[0-9]+']);
    // -----------------------------------------


    /* test */
    Route::get('test', function () {
        return view('test');
    });
    Route::match(['post'], 'test-data/{choice}', function ($lang, $choice = '') {

        Session::put('choice_cat_dog', $choice);

        // get IP
        function getRealUserIp(){
            switch(true){
                case (!empty($_SERVER['HTTP_X_REAL_IP'])) : return $_SERVER['HTTP_X_REAL_IP'];
                case (!empty($_SERVER['HTTP_CLIENT_IP'])) : return $_SERVER['HTTP_CLIENT_IP'];
                case (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) : return $_SERVER['HTTP_X_FORWARDED_FOR'];
                default : return $_SERVER['REMOTE_ADDR'];
            }
        }
        $ip = getRealUserIp();

        if (!empty($choice)) {
            $response = ['result' => 'Ok!'];
        } else {
            $response = ['error' => 'Error!']; // not choice
        }
        $json_response = json_encode($response);

        return $json_response;

    })->where(['choice' => '[cat|dog]+']);

    Route::get('test-result', ['as' => 'test_result', function () {
        $choice_cat_dog = Session::get('choice_cat_dog');
        // count all tests
        $select_all = DB::selectOne('SELECT count(*) as count_all FROM tests ');
        $count_all = (isset($select_all->count_all) && !empty($select_all->count_all) ? $select_all->count_all : 0);

        // count choice of test
        $count_choices = DB::select('SELECT count(choice) as count, choice FROM tests GROUP BY choice ');
        if (isset($count_choices) && !empty($count_choices)) {
            foreach($count_choices as &$choice){
                $choice->percent = round( ( ( $choice->count * 100 ) / $count_all ),0);
            }
        }

        return view('test-result', [
            'count_all' => $count_all,
            'count_choices' => $count_choices,
            'choice_cat_dog' => $choice_cat_dog,
        ]);
    }]);

});

