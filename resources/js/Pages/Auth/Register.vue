<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import {Head, Link, useForm} from '@inertiajs/vue3';
import {ref} from "vue";


const showPassword = ref(false);
const showPasswordConfirmation = ref(false);

const form = useForm({
    username: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};

const togglePassword = () => {
    showPassword.value = !showPassword.value;
};
const togglePasswordConfirmation = () => {
    showPasswordConfirmation.value = !showPasswordConfirmation.value;
};
</script>

<template>
    <GuestLayout>
        <Head title="Register"/>

        <form @submit.prevent="submit" class="mt-6 overflow-hidden bg-white px-6 py-8 shadow-md rounded-lg">
            <div>
                <v-text-field
                    v-model="form.username"
                    label="Username"
                    required
                    autofocus
                    autocomplete="username"
                    :error-messages="form.errors.username ? [form.errors.username] : []"
                    variant="outlined"
                />
            </div>

            <div class="mt-4">
                <v-text-field
                    v-model="form.email"
                    label="Email"
                    type="email"
                    required
                    autocomplete="username"
                    :error-messages="form.errors.email ? [form.errors.email] : []"
                    variant="outlined"
                />
            </div>

            <div class="mt-4">
                <v-text-field
                    v-model="form.password"
                    label="Password"
                    :type="showPassword ? 'text' : 'password'"
                    required
                    autocomplete="new-password"
                    :error-messages="form.errors.password ? [form.errors.password] : []"
                    variant="outlined"
                    :append-inner-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                    :on-click:append-inner="togglePassword"
                />
            </div>

            <div class="mt-4">
                <v-text-field
                    v-model="form.password_confirmation"
                    label="Confirm Password"
                    :type="showPasswordConfirmation ? 'text' : 'password'"
                    required
                    autocomplete="new-password"
                    :error-messages="form.errors.password_confirmation ? [form.errors.password_confirmation] : []"
                    variant="outlined"
                    :append-inner-icon="showPasswordConfirmation ? 'mdi-eye' : 'mdi-eye-off'"
                    :on-click:append-inner="togglePasswordConfirmation"
                />
            </div>

            <div class="mt-4 flex items-center justify-end">
                <Link
                    :href="route('login')"
                    class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                >
                    Already registered?
                </Link>

                <v-btn
                    class="ms-4"
                    :loading="form.processing"
                    :disabled="form.processing"
                    color="black"
                    @click="submit"
                >
                    Register
                </v-btn>
            </div>
        </form>
    </GuestLayout>
</template>
