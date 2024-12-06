<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('status', 'Sesión cerrada exitosamente.');
    }

    public function login(Request $request)
    {
        // Validar los datos de entrada
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string|min:8',
        ]);

        // Comprobar si la validación falla
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422); // 422 Unprocessable Entity
        }

        // Intentar autenticar al usuario
        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user(); // Obtener el usuario autenticado
            return response()->json([
                'message' => 'Inicio de sesión exitoso.',
                'user' => $user,
            ], 200); // 200 OK
        }

        // Si las credenciales no son válidas
        return response()->json([
            'message' => 'Credenciales inválidas. Por favor, verifica tu correo y contraseña.',
        ], 401); // 401 Unauthorized
    }

    public function register(Request $request)
    {
        // Validar los datos de entrada
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        // Comprobar si la validación falla
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422); // 422 Unprocessable Entity
        }

        // Crear el usuario
        $user = \App\Models\User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        // Retornar una respuesta de éxito
        return response()->json([
            'message' => 'Usuario registrado exitosamente.',
            'user' => $user,
        ], 201); // 201 Created
    }
}
