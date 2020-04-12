<?php

// use GuzzleHttp\Middleware;
// use Illuminate\Support\Facades\Route;
// use Illuminate\Support\Facades\DB;

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



Auth::routes(['verify'=>'true']);

Route::group(['middleware'=>'verified'], function(){
    Route::resource('/entrada','EntradaController')->middleware('language');
    Route::post('/entrada/comentario','EntradaController@comentarioGuardar')
    ->name('comentario.guardar');

    Route::get('/home', 'HomeController@index')->name('home');
});




Route::get('/','BlogController@index')->name('blog.index');
Route::get('/blog/{entrada}','BlogController@show')->name('blog.show');

/* Route::get('/blog/{entrada}',function(){
    return('holaaaa');
})->name('blog.show'); */






/* Route::get('/probarconexion',function(){
    try{
        DB::connection()->getPdo();
        

    }catch(\Exception $e){
        die("no puioood".$e);
    }
}); */



