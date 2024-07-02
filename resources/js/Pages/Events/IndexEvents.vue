<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
    events: Array,
});

const events = ref(props.events);
</script>

<template>
    <Head title="Events|Index" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                All Events
            </h2>
        </template>
        <table class="shadow-lg bg-white mx-auto mt-3 max-w-7xl">
            <tr>
                <th class="bg-blue-100 border text-left px-8 py-4">Id</th>
                <th class="bg-blue-100 border text-left px-8 py-4">Name</th>
                <th class="bg-blue-100 border text-left px-8 py-4">
                    Description
                </th>
                <th class="bg-blue-100 border text-left px-8 py-4">
                    Start Date
                </th>

                <th class="bg-blue-100 border text-left px-8 py-4">End Date</th>
                <th class="bg-blue-100 border text-left px-8 py-4">
                    Meeting Room
                </th>
                <th class="bg-blue-100 border text-left px-8 py-4">Actions</th>
            </tr>
            <tr v-for="event in events" :key="event.id">
                <td class="border px-8 py-4">{{ event.id }}</td>
                <td class="border px-8 py-4">{{ event.name }}</td>
                <td class="border px-8 py-4">{{ event.description }}</td>
                <td class="border px-8 py-4">
                    {{ event.start_date }}
                </td>
                <td class="border px-8 py-4">
                    {{ event.end_date }}
                </td>
                <td class="border px-8 py-4">
                    {{ event.meetingroom.id }} | {{ event.meetingroom.name }}
                </td>
                <td class="border px-8 py-4">Delete Edit</td>
            </tr>
        </table>
    </AuthenticatedLayout>
</template>
