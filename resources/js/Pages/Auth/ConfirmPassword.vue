<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import {Head, useForm} from '@inertiajs/vue3';

const form = useForm({
    password: '',
});

const submit = () => {
    form.post(route('password.confirm'), {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Confirm Password"/>

        <!-- Message d'information -->
        <div class="mb-4 text-sm text-gray-600">
            This is a secure area of the application. Please confirm your
            password before continuing.
        </div>

        <!-- Formulaire de confirmation -->
        <form @submit.prevent="submit">
            <div>
                <!-- Champ mot de passe avec VTextField -->
                <v-text-field
                    v-model="form.password"
                    label="Password"
                    type="password"
                    required
                    autocomplete="current-password"
                    autofocus
                    :error-messages="form.errors.password ? [form.errors.password] : []"
                    class="mt-1 block w-full"
                />
            </div>

            <!-- Bouton de confirmation avec VBtn -->
            <div class="mt-4 flex justify-end">
                <v-btn
                    class="ms-4"
                    :loading="form.processing"
                    :disabled="form.processing"
                    color="primary"
                    @click="submit"
                >
                    Confirm
                </v-btn>
            </div>
        </form>
    </GuestLayout>
</template>
