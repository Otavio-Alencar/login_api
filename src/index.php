<?php
    require_once('./vendor/autoload.php');
    use App\Http\Route;

    Route::get('/','HomeController@index');

    print_r(Route::routes()); 

?>
