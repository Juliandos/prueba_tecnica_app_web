<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use App\Models\Cocktail;

class CocktailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cocktails = Cocktail::all();

        return view('cocktails.crud', compact('cocktails'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validar los datos recibidos
        // $validated = $request->validate([
        //     'nombre' => 'required|string|max:255',
        //     'categoria' => 'required|string|max:255',
        //     'alcoholica' => 'required|boolean',
        //     'vaso' => 'required|string|max:255',
        //     'instrucciones' => 'required|string',
        //     'ruta_imagen' => 'nullable|string|max:255',
        // ]);

        // Buscar el cóctel por su ID
        $cocktail = Cocktail::find($id);

        // Verificar si el cóctel existe
        if (!$cocktail) {
            return response()->json([
                'message' => 'Cóctel no encontrado.',
            ], 404);
        }

        // Actualizar los datos del cóctel
        $cocktail->update([
            'nombre' => $request->input('nombre'),
            'categoria' => $request->input('categoria'),
            'alcoholica' => $request->input('alcoholica'),
            'ruta_imagen' => $request->input('ruta_imagen'),
            'vaso' => $request->input('vaso'),
            'instrucciones' => $request->input('instrucciones'),
        ]);

        // Retornar una respuesta exitosa con los datos actualizados
        return response()->json([
            'message' => 'Cóctel actualizado exitosamente.',
            'cocktail' => $cocktail,
        ], 200);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): JsonResponse
    {
        $result = Cocktail::find($id)->delete();

        if ($result) {
            return response()->json([
                'status' => 'success',
                'message' => 'The specified resource was successfully removed'
            ]);
        } else {
            return response()->json([
                'status' => 'fail',
                'message' => 'The specified was not removed'
            ]);
        }
    }
}
