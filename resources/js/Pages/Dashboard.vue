<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { Head, Link } from "@inertiajs/vue3";
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">You're logged in!</div>
                </div>
            </div>
        </div>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div>
                    <Link :href="route('dashboard.meetingrooms.index')">
                        <h2 class="p-6 text-indigo-700 text-2xl">
                            Add a new meeting room
                            <span
                                class="text-white text-center bg-indigo-700 px-4 py-2 rounded-full ml-3 font-bold"
                                >&plus;</span
                            >
                        </h2></Link
                    >
                </div>
            </div>
        </div>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div>
                    <Link :href="route('dashboard.events.create')">
                        <h2 class="p-6 text-indigo-700 text-2xl">
                            Create a new event
                            <span
                                class="text-white text-center bg-indigo-700 px-4 py-2 rounded-full ml-3 font-bold"
                                >&plus;</span
                            >
                        </h2></Link
                    >
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
