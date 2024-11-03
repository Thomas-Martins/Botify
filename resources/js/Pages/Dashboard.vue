<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, usePage} from '@inertiajs/vue3';
import {onMounted, ref} from 'vue';
import axios from 'axios';
import BotCard from "@/Components/BotCard.vue";

const {props} = usePage();
const successMessage = ref(props.flash.success); // Accéder directement aux valeurs
const errorMessage = ref(props.flash.error); // Accéder directement aux valeurs
const errorBotInfoMessage = ref(false)
const loadingBotInfo = ref(false)
const botInfo = ref(null);
const botConnections = ref([]);
const errorConnectionMessage = ref(null);
const guilds = ref([]);
const loading = ref(false);
const discordUserId = ref(props.auth.user.discord_user_id);

const getBotInfo = async () => {
    loadingBotInfo.value = true
    try {
        const response = await axios.get('/discord/bot-info');
        botInfo.value = response.data;
        console.log('BotInfo', botInfo);
    } catch (error) {
        errorBotInfoMessage.value = true;
        console.error('Error fetching bot info:', error);
    } finally {
        loadingBotInfo.value = false
    }
};

const getBotConnections = async () => {
    errorConnectionMessage.value = null; // Réinitialiser le message d'erreur
    try {
        const response = await axios.get('/bot-connections');
        botConnections.value = response.data;
    } catch (error) {
        console.error('Error fetching bot connections:', error);
        errorConnectionMessage.value = "Erreur lors de la récupération des connexions de bot. Merci de réessayer ultérieurement.";
    }
};


const connectUserToDiscord = async () => {
    // Set loading to true
    loading.value = true;
    try {
        // Make a request to connect to discord
        const response = await axios.get('/discord/connect-user');
        if (response.data.url) {
            window.location.href = response.data.url;
        }
    } catch (error) {
        console.error('Error connecting to discord:', error);
    } finally {
        // Set loading to false
        loading.value = false;
    }
};
const connectBotToDiscord = async () => {
    // Set loading to true
    loading.value = true;
    try {
        // Make a request to connect to discord
        const response = await axios.get('/discord/invite-bot');
        if (response.data.url) {
            window.location.href = response.data.url; // Redirect the user to the Discord invitation URL
        }
    } catch (error) {
        console.error('Error connecting to discord:', error);
    } finally {
        // Set loading to false
        loading.value = false;
    }
};

// Function to clear messages
const clearMessage = (messageRef) => {
    setTimeout(() => {
        messageRef.value = null;
    }, 3000); // 3000 ms = 3 seconds
};

onMounted(() => {
    getBotInfo();
    getBotConnections();

    console.log(Echo);
    window.Echo.channel('bot-connections')
        .listen('BotConnectionDeleted', (e) => {
            console.log('BotConnectionDeleted', e);
            window.location.reload();
        });

    if (successMessage.value) clearMessage(successMessage);
    if (errorMessage.value) clearMessage(errorMessage);
});

</script>

<template>
    <Head title="Dashboard"/>

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Dashboard
            </h2>
        </template>
        <div v-if="successMessage" class="p-4">
            <v-alert variant="tonal" border="start" type="success" dense dismissible>{{ successMessage }}</v-alert>
        </div>
        <div v-if="errorMessage" class="p-4">
            <v-alert variant="tonal" border="start" type="error" dense dismissible>{{ errorMessage }}</v-alert>
        </div>
        <div class="py-8">
            <div class="overflow-hidden bg-white shadow-sm rounded-lg">
                <!-- Show loader if botInfo is not yet loaded -->
                <div v-if="loadingBotInfo" class="text-center p-5 flex justify-center items-center ">
                    <v-progress-circular size="100" width="8" indeterminate color="black"></v-progress-circular>
                </div>

                <!-- Show content once botInfo is loaded -->
                <div v-else class="p-10 space-y-5">
                    <div class="text-gray-900 space-y-5 flex justify-space-between items-center gap-5">
                        <template v-if="discordUserId">
                            <v-chip color="green"><p>Connexion discord établie!</p></v-chip>
                        </template>
                        <template v-else>
                            <p>Veuillez connecter votre compte Discord pour continuer.</p>
                            <v-btn color="#5a64ea" class="text-none" @click="connectUserToDiscord"
                                   :loading="loading">
                                <div class="flex justify-center items-center gap-3">
                                    <p>Connecter discord</p>
                                    <i class="ri-discord-fill ri-2x"></i>
                                </div>
                            </v-btn>
                        </template>
                    </div>
                    <div v-if="errorBotInfoMessage" class="p-4">
                        <v-alert variant="tonal" border="start" type="error" dense dismissible>Une erreur est survenue,
                            merci de
                            réessayer ultérieurement.
                        </v-alert>
                    </div>
                    <div v-else>
                        <div
                            class=" text-gray-900 space-y-5 flex justify-space-between align-center items-center gap-5">
                            Bienvenue sur votre tableau de bord!
                            <div class="md:hidden">
                                <v-btn color="black" class="text-none" @click="connectBotToDiscord"
                                       :loading="loading"
                                       size="30"
                                       icon="mdi-plus">
                                </v-btn>
                            </div>
                            <div class="hidden md:flex my-auto items-center">
                                <v-btn color="black" class="text-none" @click="connectBotToDiscord"
                                       :loading="loading">
                                    Connecter un serveur Discord
                                </v-btn>
                            </div>
                        </div>

                        <!-- Display bot connections if available -->
                        <div v-if="botConnections.length > 0">
                            <div v-for="botConnection in botConnections" :key="botConnection.id">
                                <BotCard :botInfo="botInfo" :serveurConnected="botConnection"/>
                            </div>
                        </div>
                        <!-- Show message if no bot connections -->
                        <div v-else class="p-6 text-gray-900 text-center">
                            <p>Vous n'avez pas encore de serveur discord connectés.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
