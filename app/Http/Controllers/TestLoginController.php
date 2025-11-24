<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
class TestLoginController extends Controller
{
    public function login(Request $request)
    {
        // Recuperar por email
        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return response()->json(['status' => 'error', 'message' => 'User not found'], 404);
        }

        // Validar contraseña
        if (! Hash::check($request->password, $user->password)) {
            return response()->json(['status' => 'error', 'message' => 'Invalid password'], 401);
        }

        // NO crea sesión
        // NO usa cookies
        // NO usa Inertia
        return response()->json(['status' => 'ok'], 200);
    }
}
