<?php

namespace App\Providers;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class DiscordService
{
    protected const BASE_URL = 'https://discord.com/api/v10';
    protected const SCOPE_IDENTIFY = 'identify';
    protected const SCOPE_GUILDS = 'guilds';
    protected const SCOPE_BOT = 'bot';

    protected PendingRequest $http;

    public function __construct()
    {
        $this->http = Http::withHeaders([
            'Authorization' => 'Bot ' . env('DISCORD_BOT_TOKEN'),
        ]);
    }

    public function connectUserToDiscord()
    {
        $clientId = env('DISCORD_CLIENT_ID');
        $redirectUri = urlencode(env('DISCORD_REDIRECT_URI'));
        $url = "https://discord.com/oauth2/authorize?client_id={$clientId}&&response_type=code&redirect_uri={$redirectUri}&scope=identify&scope=identify";

        return $url;
    }

    public function getBotInfo()
    {
        $token = env('DISCORD_BOT_TOKEN');

        // Faire une requête à l'API Discord pour obtenir les informations du bot
        $response = Http::withHeaders([
            'Authorization' => 'Bot ' . $token,
        ])->get(self::BASE_URL . '/users/@me');

        if ($response->successful()) {
            $botData = $response->json();
            return $botData;
        }

        return null;
    }

    public function generateInviteLink(): string
    {
        $clientId = env('DISCORD_CLIENT_ID');
        $permissions = 2210;
        $redirectUri = urlencode(env('DISCORD_REDIRECT_URI'));

        $url = "https://discord.com/oauth2/authorize?client_id={$clientId}&permissions={$permissions}&response_type=code&redirect_uri={$redirectUri}&integration_type=0&scope=identify+guilds+bot";

        return $url;
    }

    public function getDiscordUserInfo(string $accessToken)
    {
        // Faire une requête à l'API Discord pour obtenir les informations de l'utilisateur
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
        ])->get('https://discord.com/api/v10/users/@me');

        if ($response->successful()) {
            return $response->json(); // Retourne les informations de l'utilisateur
        }

        return null; // En cas d'échec, retourne null
    }


    public function getGuildInfo($guildId)
    {
        $botToken = env('DISCORD_BOT_TOKEN');

        $response = Http::withHeaders([
            'Authorization' => 'Bot ' . $botToken,
        ])->get('https://discord.com/api/guilds/' . $guildId);

        if ($response->successful()) {
            return $response->json();
        }

        return null;
    }

}
