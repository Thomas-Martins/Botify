<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import {Head, Link, useForm} from '@inertiajs/vue3';
import {ref} from "vue";

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const showPassword = ref(false);

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};

const togglePassword = () => {
    showPassword.value = !showPassword.value;
};
</script>

<template>
    <GuestLayout>
        <Head title="Log in"/>

        <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit"
              class="mt-6 overflow-hidden bg-white px-6 py-4 shadow-md rounded-lg">

            <!-- Champ email avec VTextField -->
            <v-text-field
                v-model="form.email"
                label="Email"
                type="email"
                required
                :error-messages="form.errors.email ? [form.errors.email] : []"
                class="mt-1 block w-full"
                variant="outlined"
            />

            <!-- Champ mot de passe avec VTextField -->
            <v-text-field
                v-model="form.password"
                label="Password"
                :type="showPassword ? 'text' : 'password'"
                required
                :error-messages="form.errors.password ? [form.errors.password] : []"
                :append-inner-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                :on-click:append-inner="togglePassword"
                clearable
                variant="outlined"
            />

            <!-- Checkbox 'Remember me' avec VCheckbox -->
            <v-checkbox
                v-model="form.remember"
                label="Remember me"
                class="mt-4"
            />

            <!-- Lien et bouton de soumission -->
            <div class="flex items-center justify-end">
                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                >
                    Forgot your password?
                </Link>

                <!-- Remplace PrimaryButton par VBtn -->
                <v-btn
                    class="ms-4"
                    :loading="form.processing"
                    :disabled="form.processing"
                    color="black"
                    @click="submit"
                >
                    Login
                </v-btn>
            </div>
        </form>

        <!-- Lien pour l'inscription -->
        <div class="text-center mt-5">
            <Link
                :href="route('register')"
                class="text-md text-gray-600 underline hover:text-gray-900 focus:outline-none"
            >
                You don't have an account?
            </Link>
        </div>
    </GuestLayout>
</template>
