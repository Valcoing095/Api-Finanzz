<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\{DB,log};
#Models
use App\Models\User;
#Requests
use App\Http\Requests\Auth\{SingUpRequest,AuthRequest};

use Carbon\Carbon;

class AuthController extends Controller
{
    public function signUp(SingUpRequest $request) {
        try {
            $validated = $request->validated();

            $user = User::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Usuario registrado exitosamente',
                'data' => $user->id
            ], 201);

        } catch (\Exception $e) {
            Log::error('Error al registrar usuario: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);

            return $e->getMessage();
        }
    }

    public function logIn(AuthRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Credenciales inválidas'
            ], 401);
        }

        $user = $request->user();

        $tokenResult = $user->createToken($user->email . '-' . now());

        return response()->json([
            'access_token' => $tokenResult->plainTextToken,
            'token_type' => 'Bearer',
            'id' => $user->id,
            'expires_at' => null
        ], 201);
    }


    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }


}
