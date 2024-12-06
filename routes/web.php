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
    return view('welcome');
});

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

Route::post('cocktails', function (Request $request) {
    // $validated = $request->validate([
    //     'id' => 'required|integer|unique:cocktail,id',
    //     'nombre' => 'required|string|max:255',
    //     'categoria' => 'required|string|max:255',
    //     'alcoholica' => 'required|boolean',
    //     'vaso' => 'required|string|max:255',
    //     'instrucciones' => 'required|string',
    // ]);

    // Crear un nuevo registro en la base de datos
    $cocktail = Cocktail::create([
        'id' => $request->input('id'),
        'nombre' => $request->input(key: 'nombre'),
        'categoria' => $request->input(key: 'categoria'),
        'alcoholica' => $request->input('alcoholica'),
        'ruta_imagen' => $request->input('ruta_imagen'),
        'vaso' => $request->input('vaso'),
        'instrucciones' => $request->input('instrucciones')
    ]);

    // Retornar una respuesta exitosa
    return response()->json([
        'message' => 'Cóctel guardado exitosamente.',
        'cocktail' => $cocktail,
    ], 201);
});

Route::resource('cocktails', CocktailController::class);
