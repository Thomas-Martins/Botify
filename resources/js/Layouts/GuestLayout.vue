<script setup>
import {Link} from '@inertiajs/vue3';
</script>

<template>
    <div
        class="min-h-screen flex flex-col items-center bg-gray-100 p-5 sm:justify-center"
    >
        <div>
            <Link href="/">
                <h1 class="font-bold text-7xl">Botify</h1>
            </Link>
        </div>
        <div
            class="w-full sm:max-w-md "
        >
            <slot/>
        </div>
    </div>
</template>
