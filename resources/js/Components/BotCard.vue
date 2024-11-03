<script setup>
import {ref} from 'vue';
import InformationDialog from "@/Components/dialogs/InformationDialog.vue";

const props = defineProps(['botInfo', 'serveurConnected']);

// Reactive state for dialog visibility
const dialog = ref(false);

// Function to open the dialog
const openDialog = () => {
    dialog.value = true;
};

</script>

<template>
    <div class="py-4 text-gray-900 w-full transition card">
        <div class="flex shadow-md border rounded-lg p-4 justify-space-between w-full">
            <div class="flex w-full">
                <img
                    class="h-20 w-auto rounded-lg mr-2"
                    :src="`https://cdn.discordapp.com/avatars/${botInfo.id}/${botInfo.avatar}.png`"
                    alt="bot_avatar">
                <div class="flex justify-space-between items-center align-center w-full">
                    <div>
                        <h2 class="text-lg font-semibold">{{ botInfo?.username }}</h2>
                        <div class="flex justify-end gap-2 mt-5">
                            <p>Connecté au serveur : </p>
                            <div class="flex gap-2 align-center items-center">
                                <div v-if="serveurConnected.guild_icon">
                                    <img
                                        class="h-5 w-5 rounded-lg"
                                        :src="`https://cdn.discordapp.com/icons/${serveurConnected.guild_id}/${serveurConnected.guild_icon}.png`"
                                        alt="serveur_icon">
                                </div>
                                <p>{{ serveurConnected.guild_name }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col justify-space-between items-center">
                        <v-badge color="success" dot>
                            <v-chip color="green">
                                connecté
                            </v-chip>
                        </v-badge>
                        <!-- Delete button triggers dialog -->
                        <v-btn icon="mdi-information-outline" class="hover-show" color="black" variant="plain"
                               @click="openDialog">
                        </v-btn>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pass the dialog state as a prop to the DeleteConfirmationDialog component -->
    <InformationDialog
        :model-value="dialog"
        @update:model-value="dialog = $event"
        text="Pour supprimer la connexion, rendez-vous sur votre serveur Discord et supprimez le bot en allant dans les paramètres du serveur, dans la section intégrations."
    />
</template>

<style scoped>
.hover-show {
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s ease, visibility 0.3s ease;
}

.card:hover .hover-show {
    opacity: 1;
    visibility: visible;
}
</style>
