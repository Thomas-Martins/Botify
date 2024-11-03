<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head} from "@inertiajs/vue3";
</script>

<template>
    <Head title="Webhooks"/>

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Webhooks
            </h2>
        </template>
        <div>
            Webhooks Page
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
