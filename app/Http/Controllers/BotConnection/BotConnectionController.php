<?php

namespace App\Http\Controllers\BotConnection;

use App\Http\Controllers\Controller;
use App\Models\BotConnection;
use Illuminate\Http\JsonResponse;


class BotConnectionController extends Controller
{
    public function index(): JsonResponse
    {
        $user = auth()->id();
        $bots = BotConnection::where('user_id', $user)->get();

        if ($bots->isEmpty()) {
            return response()->json(['message' => 'Vous n\'avez pas encore connecté de serveur'], 200);
        }

        return response()->json($bots);
    }

}
