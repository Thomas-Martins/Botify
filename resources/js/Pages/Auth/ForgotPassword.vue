<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import {Head, useForm} from '@inertiajs/vue3';

defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <GuestLayout>
        <Head title="Forgot Password"/>

        <!-- Message d'information -->
        <div class="mb-4 text-sm text-gray-600">
            Forgot your password? No problem. Just let us know your email
            address and we will email you a password reset link that will allow
            you to choose a new one.
        </div>

        <!-- Message de statut (succès) -->
        <div
            v-if="status"
            class="mb-4 text-sm font-medium text-green-600"
        >
            {{ status }}
        </div>

        <!-- Formulaire de demande de réinitialisation -->
        <form @submit.prevent="submit">
            <div>
                <!-- Champ email avec VTextField -->
                <v-text-field
                    v-model="form.email"
                    label="Email"
                    type="email"
                    required
                    autofocus
                    autocomplete="username"
                    :error-messages="form.errors.email ? [form.errors.email] : []"
                    class="mt-1 block w-full"
                />
            </div>

            <!-- Bouton d'envoi avec VBtn -->
            <div class="mt-4 flex items-center justify-end">
                <v-btn
                    :loading="form.processing"
                    :disabled="form.processing"
                    color="primary"
                    @click="submit"
                >
                    Email Password Reset Link
                </v-btn>
            </div>
        </form>
    </GuestLayout>
</template>
