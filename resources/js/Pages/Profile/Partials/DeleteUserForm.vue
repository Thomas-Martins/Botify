<script setup>
import {nextTick, ref} from 'vue';
import {useForm} from '@inertiajs/vue3';

// Variables pour le modal et la gestion des entrées utilisateur
const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);

// Utilisation de Inertia form pour la gestion du formulaire
const form = useForm({
    password: '',
});

// Fonction pour ouvrir le modal de confirmation
const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;
    nextTick(() => passwordInput.value.focus());
};

// Fonction pour supprimer l'utilisateur
const deleteUser = () => {
    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

// Fonction pour fermer le modal
const closeModal = () => {
    confirmingUserDeletion.value = false;
    form.clearErrors();
    form.reset();
};
</script>

<template>
    <section class="space-y-6">
        <header>
            <h2 class="text-lg font-medium text-gray-900">Delete Account</h2>
            <p class="mt-1 text-sm text-gray-600">
                Once your account is deleted, all of its resources and data will be permanently deleted.
                Before deleting your account, please download any data or information that you wish to retain.
            </p>
        </header>

        <!-- Bouton de suppression de compte -->
        <v-btn color="error" @click="confirmUserDeletion">Delete Account</v-btn>

        <!-- Modal de confirmation de suppression -->
        <v-dialog v-model="confirmingUserDeletion" max-width="500px">
            <v-card>
                <v-card-title class="text-h6">Are you sure you want to delete your account?</v-card-title>
                <v-card-text>
                    <p class="text-sm">
                        Once your account is deleted, all of its resources and data will be permanently deleted.
                        Please enter your password to confirm you would like to permanently delete your account.
                    </p>

                    <!-- Champ mot de passe -->
                    <v-text-field
                        v-model="form.password"
                        ref="passwordInput"
                        type="password"
                        label="Password"
                        placeholder="Password"
                        :error-messages="form.errors.password ? [form.errors.password] : []"
                        @keyup.enter="deleteUser"
                    ></v-text-field>
                </v-card-text>

                <!-- Boutons de confirmation et annulation -->
                <v-card-actions>
                    <v-btn text @click="closeModal">Cancel</v-btn>
                    <v-btn color="error" @click="deleteUser" :loading="form.processing" :disabled="form.processing">
                        Delete Account
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </section>
</template>
