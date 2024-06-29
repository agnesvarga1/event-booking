<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
//import SecondaryButton from "@/Components/SecondaryButton.vue";
import { Head, Link } from "@inertiajs/vue3";

const imgUrl = "http://127.0.0.1:8000/storage/";
defineProps({ event: Object });
</script>

<template>
    <Head title="Event" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 leading-tight text-center"
            >
                {{ event.name }}
            </h2>
        </template>
        <div class="mt-5 mx-auto w-1/2">
            <h3>From: {{ event.start_date }}</h3>
            <h3>Until: {{ event.end_date }}</h3>
            <p>Where: {{ event.meetingroom.name }}</p>
            <p>
                Capacity: max. {{ event.meetingroom.available_places }} person
            </p>
            <img class="mt-3 w-1/2" :src="`${imgUrl}${event.image}`" alt="" />

            <h3>{{ event.name }}</h3>
            <p>{{ event.description }}</p>
        </div>
    </AuthenticatedLayout>
</template>
