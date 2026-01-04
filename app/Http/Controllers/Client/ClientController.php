<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\Client\ClientRequest;
use Illuminate\Support\Facades\Auth;
use  App\Models\Client\Client;


use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    public function newClient(ClientRequest $request)
    {
        DB::beginTransaction();
        try {

            $validated = $request->validated();
            $validated['user_id'] = Auth::id();

            //Validar que no exista un cliente con el mismo email para el usuario autenticado
            $existingClient = Client::where('email', $validated['email'])->where('user_id', Auth::id())->first();
            if ($existingClient) {
                return response()->json([
                    "message" => "Ya existe un cliente con el correo electrónico registrado."
                ], 409);
            }

            $client = Client::create($validated);
            DB::commit();

            return response()->json([
                "message" => $client->id .'-'. "Usuario creado satisfactoriamente"
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e])->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getClients()
    {
        try {
            $userId = Auth::id();
            $clients = Client::where('user_id', $userId)->get();

            return response()->json([
                'data' => $clients
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => $e])->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
