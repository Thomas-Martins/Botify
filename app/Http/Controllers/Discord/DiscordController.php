<?php

namespace App\Http\Controllers\Discord;

use App\Http\Controllers\Controller;
use App\Models\BotConnection;
use App\Models\User;
use App\Providers\DiscordService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DiscordController extends Controller
{
    protected DiscordService $discordService;

    public function __construct(DiscordService $discordService)
    {
        $this->discordService = $discordService;
    }


    public function connectToDiscord(): JsonResponse
    {
        $url = $this->discordService->connectUserToDiscord();
        return response()->json(['url' => $url]);
    }

    public function getBotInfo(): JsonResponse
    {
        $botInfo = $this->discordService->getBotInfo();
        return response()->json($botInfo);
    }

    public function getInviteLink(): JsonResponse
    {
        $inviteUrl = $this->discordService->generateInviteLink();
        return response()->json(['url' => $inviteUrl]);
    }


    public function handleDiscordCallback(Request $request)
    {
        $userId = auth()->id();

        // Vérification que l'utilisateur est authentifié
        if (!$userId) {
            return redirect()->route('login');
        }

        // Gérer le code d'autorisation de Discord
        if ($request->has('code') && $request->missing('guild_id')) {
            try {
                $code = $request->input('code');
                $accessTokenResponse = $this->getDiscordAccessToken($code);

                if (!isset($accessTokenResponse['access_token'])) {
                    return redirect()->route('dashboard')->with('error', 'Échec de la récupération du token d\'accès Discord.');
                }

                $accessToken = $accessTokenResponse['access_token'];
                $discordUserInfo = $this->discordService->getDiscordUserInfo($accessToken);

                if (!isset($discordUserInfo['id'])) {
                    return redirect()->route('dashboard')->with('error', 'Échec de la récupération des informations de l\'utilisateur Discord.');
                }

                $discordUserId = $discordUserInfo['id'];

                // Vérifie si l'utilisateur est présent dans la base de données
                $user = User::find($userId);
                if (!$user) {
                    return redirect()->route('dashboard')->with('error', 'Utilisateur non trouvé.');
                }

                // Met à jour l'ID utilisateur Discord
                $user->discord_user_id = $discordUserId;
                $user->save();

                return redirect()->route('dashboard')->with('success', 'Connexion à Discord réussie !');
            } catch (\Exception $e) {
                return redirect()->route('dashboard')->with('error', 'Erreur lors de la connexion à Discord: ' . $e->getMessage());
            }
        } elseif ($request->has('code') && $request->has('guild_id')) {
            try {
                $guildId = $request->input('guild_id');
                $guildInfo = $this->discordService->getGuildInfo($guildId);

                if ($guildInfo === null) {
                    return redirect()->route('dashboard')->with('error', 'Impossible de récupérer les informations du serveur.');
                }

                // Vérifie si la connexion existe déjà dans la base de données
                $botConnection = BotConnection::where('user_id', $userId)->where('guild_id', $guildId)->first();

                if ($botConnection) {
                    return redirect()->route('dashboard')->with('error', 'La connexion avec ce serveur existe déjà.');
                } else {
                    // Crée une nouvelle connexion
                    BotConnection::create([
                        'user_id' => $userId,
                        'guild_id' => $guildId,
                        'guild_name' => $guildInfo['name'],
                        'guild_icon' => $guildInfo['icon'],
                    ]);

                    return redirect()->route('dashboard')->with('success', 'Connexion avec le serveur établie avec succès.');
                }
            } catch (\Exception $e) {
                return redirect()->route('dashboard')->with('error', 'Erreur lors de la connexion au serveur Discord: ' . $e->getMessage());
            }
        }

        // Si aucun paramètre n'est présent, renvoie un message d'erreur
        return redirect()->route('dashboard')->with('error', 'Paramètre manquant.');
    }
    
    /**
     * Échanger le "code" contre un token d'accès OAuth2
     */
    private function getDiscordAccessToken($code)
    {
        $clientId = env('DISCORD_CLIENT_ID');
        $clientSecret = env('DISCORD_CLIENT_SECRET');
        $redirectUri = env('DISCORD_REDIRECT_URI'); // URI de redirection

        $response = Http::asForm()->post('https://discord.com/api/oauth2/token', [
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => $redirectUri,
        ]);

        return $response->json();
    }

}
