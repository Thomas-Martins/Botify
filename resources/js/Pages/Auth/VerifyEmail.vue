<script setup>
import {computed} from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import {Head, Link, useForm} from '@inertiajs/vue3';

const props = defineProps({
    status: {
        type: String,
    },
    isBlocked: {
        type: Boolean,
    },
});

const form = useForm({});

const submit = () => {
    form.post(route('verification.send'));
};

const verificationLinkSent = computed(
    () => props.status === 'verification-link-sent',
);
</script>

<template>
    <GuestLayout>
        <Head title="Email Verification"/>
        <div v-if="$props.isBlocked === true">
            <!-- Message et instructions -->
            <div class="mb-4 text-sm text-gray-600">
                Merci de vous être inscrit chez nous! Malheureusement, avant de pouvoir continuer, vous devez vérifier
                votre adresse e-mail en cliquant sur le lien que nous venons de vous envoyer. Si vous n'avez pas reçu
                l'e-mail, nous vous en enverrons un autre avec plaisir.
            </div>
            <!-- Message de confirmation d'envoi d'un nouveau lien -->
            <div
                class="mb-4 text-sm font-medium text-green-600"
                v-if="verificationLinkSent"
            >
                A new verification link has been sent to the email address you
                provided during registration.
            </div>

            <!-- Formulaire de renvoi de lien de vérification -->
            <form @submit.prevent="submit">
                <div class="mt-4 flex items-center justify-between">
                    <!-- Bouton de renvoi d'email avec VBtn -->
                    <v-btn
                        :loading="form.processing"
                        :disabled="form.processing"
                        color="primary"
                        @click="submit"
                    >
                        Renvoyer l'e-mail de vérification
                    </v-btn>

                    <!-- Lien de déconnexion -->
                    <Link
                        :href="route('logout')"
                        method="post"
                        as="button"
                        class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    >
                        Se déconnecter
                    </Link>
                </div>
            </form>
        </div>
        <div v-else>
            <!-- Message de remerciement et instructions -->
            <div class="mb-4 text-sm text-gray-600">
                Merci pour votre inscription ! Avant de commencer, pourriez-vous vérifier votre adresse email en
                cliquant sur le lien que nous venons de vous envoyer ? Si vous n'avez pas reçu l'email, nous vous
                renverrons volontiers un autre.
            </div>

            <!-- Message de confirmation d'envoi d'un nouveau lien -->
            <div
                class="mb-4 text-sm font-medium text-green-600"
                v-if="verificationLinkSent"
            >
                Un nouveau lien de vérification a été envoyé à l'adresse email que vous avez fournie lors de votre
                inscription.
            </div>

            <!-- Formulaire de renvoi de lien de vérification -->
            <form @submit.prevent="submit">
                <div class="mt-4 flex items-center justify-between">
                    <!-- Bouton de renvoi d'email avec VBtn -->
                    <v-btn
                        :loading="form.processing"
                        :disabled="form.processing"
                        color="primary"
                        @click="submit"
                    >
                        Renvoyer l'e-mail de vérification
                    </v-btn>

                    <!-- Lien de déconnexion -->
                    <Link
                        :href="route('logout')"
                        method="post"
                        as="button"
                        class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    >
                        Se déconnecter
                    </Link>
                </div>
            </form>
        </div>
    </GuestLayout>
</template>
