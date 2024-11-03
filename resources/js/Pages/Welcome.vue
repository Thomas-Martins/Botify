<script setup>
import {Head, Link} from '@inertiajs/vue3';
import {ref} from 'vue';

// Ref pour gérer l'ouverture/fermeture du drawer (menu mobile)
const drawer = ref(false);
</script>

<template>
    <Head title="Welcome"/>
    <v-app>
        <!-- App Bar -->
        <v-app-bar flat app color="white">
            <h1 class="text-4xl ml-4">Botify</h1>

            <v-spacer></v-spacer>
            <div class="hidden-sm-and-down flex justify-end gap-5 ">
                <v-btn color="black">
                    <Link :href="route('login')">Log in</Link>
                </v-btn>
                <v-btn color="black">
                    <Link :href="route('register')">Register</Link>
                </v-btn>
            </div>
            <v-app-bar-nav-icon @click="drawer = !drawer" class="hidden-md-and-up"></v-app-bar-nav-icon>
        </v-app-bar>

        <!-- Menu Mobile (Navigation Drawer) -->
        <v-navigation-drawer v-model="drawer" app temporary location="right">
            <v-list>
                <v-list-item>
                    <Link :href="route('login')">
                        <v-list-item-title>Log in</v-list-item-title>
                    </Link>
                </v-list-item>
                <v-list-item>
                    <Link :href="route('register')">
                        <v-list-item-title>Register</v-list-item-title>
                    </Link>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>

        <!-- Contenu principal -->
        <v-main class="p-5">
            <div class="text-center space-y-10 p-5">
                <h1 class="text-5xl">Bienvenue</h1>
                <p class="text-md">Botify est une petite app permettant de connecter un bot sur un serveur
                    discord et de
                    recevoir des messages lors de vos déploiements d'applications réussis !</p>
            </div>
        </v-main>
    </v-app>
</template>
