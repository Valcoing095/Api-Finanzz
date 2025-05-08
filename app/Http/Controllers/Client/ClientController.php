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
}
