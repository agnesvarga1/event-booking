<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { Head, Link } from "@inertiajs/vue3";
</script>

<template>
    <Head title="Events|Create" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Add a new event
            </h2>
        </template>
    </AuthenticatedLayout>
</template>
