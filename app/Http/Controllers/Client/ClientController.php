<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\Client\ClientRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\client\clientResource;
use  App\Models\Client\Client;
use App\Traits\ApiResponse;


use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    use ApiResponse;

    public function store(ClientRequest $request)
    {
        DB::beginTransaction();
        try {
            $validated = $request->validated();
            $validated['user_id'] = Auth::id();

            $client = Client::create($validated);
            DB::commit();

            return response()->json([
                "message" => $client->id . "Usuario creado satisfactoriamente"
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e])->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function index()
    {
        $clients = Client::all();
        return clientResource::collection($clients);
    }

    public function show(Client $client)
    {
        return new clientResource($client);
    }

    public function update(ClientRequest $request, Client $client)
    {
        try {
            $client->update($request->validated());
            return new clientResource($client);
        } catch (\Exception $e) {
            return $this->successResponse($client, 'Error al actualizar el cliente', Response::HTTP_BAD_REQUEST);
        }
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
