<?php

use App\Models\Test;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

$data = [
    [
        'id' => 1,
        'first_name' => 'Ernesto',
        'last_name' => 'Aides',
        'email' => 'eaides@hotmail.com',
        'data' => 'data for 1',
    ],
    [
        'first_name' => 'Ernesto',
        'last_name' => 'Aides',
        'email' => 'eaides@hotmail.com',
        'data' => 'data for 2',
    ],
    [
        'first_name' => 'Natalio',
        'last_name' => 'Aides',
        'email' => 'eaides@gmail.com',
        'data' => 'data for 3',
    ],
    [
        'first_name' => 'Other',
        'last_name' => 'Last',
        'email' => 'eaides@hotmail.com',
        'data' => 'data for 4',
    ],
];

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
    return view('welcome');
});

Route::get('/testInsertIgnore', function () use ($data) {
    Test::truncate();
    $result = 0;
    foreach($data as $one)
    {
        $result += Test::insertIgnore($one);
    }
    $db = Test::all();
    return view('dataResponse')
        ->with(compact('data'))
        ->with(compact('db'));
})->name('testIgnore');

Route::get('/testInsertOnDuplicate', function () use ($data) {
    Test::truncate();
    $result = 0;
    foreach($data as $one)
    {
        $result += intval(Test::insertOnDuplicate($one));

    }
    $db = Test::all();
    return view('dataResponse')
        ->with(compact('data'))
        ->with(compact('db'));
})->name('testDuplicate');

Route::post('/responseTime', function (Request $request) {
    $url = $request->url;
    return view('responseTime')->with('url', $url);
    // return \ResponseTime::getResponseTime($url);
})->name('testResponseTime');