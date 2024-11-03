<script setup>
import {ref} from 'vue';
import {useForm} from '@inertiajs/vue3';

// Références pour les champs de mot de passe
const passwordInput = ref(null);
const currentPasswordInput = ref(null);

// Formulaire avec Inertia
const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

// Fonction pour mettre à jour le mot de passe
const updatePassword = () => {
    form.put(route('password.update'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value.focus();
            }
            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value.focus();
            }
        },
    });
};
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Update Password</h2>
            <p class="mt-1 text-sm text-gray-600">
                Ensure your account is using a long, random password to stay secure.
            </p>
        </header>

        <form @submit.prevent="updatePassword" class="mt-6 space-y-6">
            <div>
                <!-- Label et champ pour le mot de passe actuel -->
                <v-text-field
                    v-model="form.current_password"
                    ref="currentPasswordInput"
                    label="Current Password"
                    type="password"
                    :error-messages="form.errors.current_password ? [form.errors.current_password] : []"
                    autocomplete="current-password"
                    variant="outlined"
                ></v-text-field>
            </div>

            <div>
                <!-- Label et champ pour le nouveau mot de passe -->
                <v-text-field
                    v-model="form.password"
                    ref="passwordInput"
                    label="New Password"
                    type="password"
                    :error-messages="form.errors.password ? [form.errors.password] : []"
                    autocomplete="new-password"
                    variant="outlined"
                ></v-text-field>
            </div>

            <div>
                <!-- Label et champ pour la confirmation du mot de passe -->
                <v-text-field
                    v-model="form.password_confirmation"
                    label="Confirm Password"
                    type="password"
                    :error-messages="form.errors.password_confirmation ? [form.errors.password_confirmation] : []"
                    autocomplete="new-password"
                    variant="outlined"
                ></v-text-field>
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
