<?php

use App\Http\Controllers\BotConnection\BotConnectionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Discord\DiscordController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Broadcast::routes();

Route::get('/', function () {
    return Inertia::render('Welcome');
})->middleware('guest')->name('welcome');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/webhooks', function () {
        return Inertia::render('Webhooks');
    })->name('webhooks');
    //profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //discord
    Route::get('/discord/connect-user', [DiscordController::class, 'connectToDiscord'])->name('discord.connect-user');
    Route::get('/discord/bot-info', [DiscordController::class, 'getBotInfo']);
    Route::get('/discord/guilds', [DiscordController::class, 'getGuilds']);
    Route::get('/discord/invite-bot', [DiscordController::class, 'getInviteLink']);
    Route::get('/discord/callback', [DiscordController::class, 'handleDiscordCallback'])->name('discord.callback');
    Route::post('/discord/disconnect-bot/{id}', [DiscordController::class, 'disconnectBot']);

    //bot connections
    Route::get('/bot-connections', [BotConnectionController::class, 'index']);
    Route::delete('/bot-connection/{id}', [BotConnectionController::class, 'delete']);
});


require __DIR__ . '/auth.php';
