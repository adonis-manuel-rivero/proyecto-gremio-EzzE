<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Client\ResponseSequence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function funIngresar(Request $request)
    {
        // validar

        $credenciales = $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);

        // autenticar

        if (!Auth::attempt($credenciales)) {
            return response()->json(["mensaje" => "Credenciales Incorrectas"], 401);
        }

        //generar token 

        $token = $request->user()->createToken('Token Auth')->plainTextToken;

        return response()->json([
            "access_token" => $token,
            "usuario" => $request->user()
        ], 200);
    }

    public function funRegistro(Request $request)
    {
        // validar

        $request->validate([
            "name" => "required",
            "email" => "required|email",
            "password" => "required|same:cpassword"
        ]);

        //guardar

        $usuario = new User();
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->password = bcrypt($request->password);
        $usuario->save();

        return response()->json(["mensaje" => "Usuario regístrado"], 200);
    }

    public function funPerfil(Request $request)
    {
        //procesar
        $user = $request->user();
        return response()->json($user, 200);
    }

    public function funSalir(Request $request)
    {
        //cierra sesión o eliminar token
        $request->user()->tokens()->delete();
        return response()->json(["mensaje" => "Salio"], 200);
    }
}
