<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { Head, Link } from "@inertiajs/vue3";
</script>

<template>
    <Head title="Events|Index" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                All Events
            </h2>
        </template>
    </AuthenticatedLayout>
</template>
