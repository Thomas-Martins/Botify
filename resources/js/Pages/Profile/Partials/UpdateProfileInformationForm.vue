<script setup>
import {useForm, usePage} from '@inertiajs/vue3';

// Props pour vérifier l'email et gérer le statut
defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

// Récupération des informations de l'utilisateur depuis les props de la page
const user = usePage().props.auth.user;

// Formulaire avec Inertia
const form = useForm({
    username: user.username,
    email: user.email,
});
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                Profile Information
            </h2>
            <p class="mt-1 text-sm text-gray-600">
                Update your account's profile information and email address.
            </p>
        </header>

        <!-- Formulaire pour mettre à jour le profil -->
        <form @submit.prevent="form.patch(route('profile.update'))" class="mt-6 space-y-6">
            <div>
                <!-- Label et champ pour le nom -->
                <v-text-field
                    v-model="form.username"
                    label="Name"
                    required
                    :error-messages="form.errors.username ? [form.errors.username] : []"
                    autofocus
                    autocomplete="name"
                    variant="outlined"

                ></v-text-field>
            </div>

            <div>
                <!-- Label et champ pour l'email -->
                <v-text-field
                    v-model="form.email"
                    label="Email"
                    type="email"
                    required
                    :error-messages="form.errors.email ? [form.errors.email] : []"
                    autocomplete="username"
                    variant="outlined"
                ></v-text-field>
            </div>

            <!-- Vérification de l'email si non vérifié -->
            <div v-if="mustVerifyEmail && user.email_verified_at === null">
                <p class="mt-2 text-sm text-gray-800">
                    Your email address is unverified.
                    <v-btn
                        color="primary"
                        text
                        @click="$inertia.post(route('verification.send'))"
                    >
                        Click here to re-send the verification email.
                    </v-btn>
                </p>
                <!-- Statut de lien de vérification envoyé -->
                <v-alert
                    v-show="status === 'verification-link-sent'"
                    type="success"
                    dense
                    class="mt-2"
                >
                    A new verification link has been sent to your email address.
                </v-alert>
            </div>

            <div class="flex items-center gap-4">
                <!-- Bouton de sauvegarde -->
                <v-btn :loading="form.processing" :disabled="form.processing" color="black">
                    Save
                </v-btn>

                <!-- Message de confirmation -->
                <transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">
                        Saved.
                    </p>
                </transition>
            </div>
        </form>
    </section>
</template>
