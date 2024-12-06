<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

use App\Http\Controllers\CocktailController;
use App\Models\Cocktail;

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
    return view('home');
})->name('home');

Route::get('/cocktails-api', function () {
    $url = 'https://www.thecocktaildb.com/api/json/v1/1/random.php';
    $cocktails = [];

    // Realizar 5 solicitudes
    for ($i = 0; $i < 5; $i++) {
        $response = Http::get($url);

        if ($response->ok()) {
            $data = $response->json()['drinks'][0]; // Leer el primer cóctel
            $cocktails[] = [
                'id' => $data['idDrink'],
                'nombre' => $data['strDrink'],
                'categoria' => $data['strCategory'],
                'alcoholica' => $data['strAlcoholic'],
                'ruta_imagen' => $data['strDrinkThumb'],
                'vaso' => $data['strGlass'],
                'instrucciones' => $data['strInstructions'],
            ];
        }
    }

    // Pasar los datos a la vista
    return view('cocktails.api', compact('cocktails'));
});

Route::resource('cocktails', CocktailController::class);
