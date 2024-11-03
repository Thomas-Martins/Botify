<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import {Head, useForm} from '@inertiajs/vue3';

const props = defineProps({
    email: {
        type: String,
        required: true,
    },
    token: {
        type: String,
        required: true,
    },
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.store'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Reset Password"/>

        <!-- Formulaire de réinitialisation du mot de passe -->
        <form @submit.prevent="submit">
            <!-- Champ Email -->
            <div>
                <v-text-field
                    v-model="form.email"
                    label="Email"
                    id="email"
                    type="email"
                    required
                    autofocus
                    autocomplete="username"
                    :error-messages="form.errors.email ? [form.errors.email] : []"
                ></v-text-field>
            </div>

            <!-- Champ Mot de passe -->
            <div class="mt-4">
                <v-text-field
                    v-model="form.password"
                    label="Password"
                    id="password"
                    type="password"
                    required
                    autocomplete="new-password"
                    :error-messages="form.errors.password ? [form.errors.password] : []"
                ></v-text-field>
            </div>

            <!-- Champ Confirmation mot de passe -->
            <div class="mt-4">
                <v-text-field
                    v-model="form.password_confirmation"
                    label="Confirm Password"
                    id="password_confirmation"
                    type="password"
                    required
                    autocomplete="new-password"
                    :error-messages="form.errors.password_confirmation ? [form.errors.password_confirmation] : []"
                ></v-text-field>
            </div>

            <!-- Bouton de réinitialisation -->
            <div class="mt-4 flex items-center justify-end">
                <v-btn
                    :loading="form.processing"
                    :disabled="form.processing"
                    color="primary"
                    @click="submit"
                >
                    Reset Password
                </v-btn>
            </div>
        </form>
    </GuestLayout>
</template>
