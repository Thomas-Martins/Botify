<?php

namespace App\Console\Commands;

use App\Events\BotConnectionDeleted;
use App\Models\BotConnection;
use Discord\Discord;
use Discord\WebSockets\Event;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class DiscordService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:discord-service';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Démarre le service Discord';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        // Initialiser le bot avec le token
        $discord = new Discord([
            'token' => env('DISCORD_BOT_TOKEN'),
        ]);

        $discord->on('ready', function ($discord) {
            $this->info("Bot connecté !");

            // Événement quand le bot est ajouté à un serveur
            $discord->on(Event::GUILD_CREATE, function ($guild) {
                $this->info("Bot ajouté au serveur : {$guild->name}");
                // Code pour stocker les informations en DB ici
            });

            // Événement quand le bot est retiré d'un serveur
            $discord->on(Event::GUILD_DELETE, function ($guild) {
                $this->info("Bot retiré du serveur : {$guild->name}");

                
                try {
                    BotConnection::where('guild_id', $guild->id)->delete();
                    $this->info("Connexion supprimée pour le serveur : {$guild->name}");
                    event(new BotConnectionDeleted($guild->id));
                    Log::info("Événement BotConnectionDeleted émis pour le serveur ID : {$guild->id}");

                } catch (\Exception $e) {
                    $this->error("Erreur lors de la suppression : " . $e->getMessage());
                }

            });
        });

        // Démarre la boucle du bot
        $discord->run();

    }
}
