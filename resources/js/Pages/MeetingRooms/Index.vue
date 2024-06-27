<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { ref } from "vue";
//mport { usePage } from "@inertiajs/inertia-vue3";
import { Head, Link } from "@inertiajs/vue3";
const props = defineProps({
    meetingrooms: Array,
});

const meetingrooms = ref(props.meetingrooms);
</script>
<template>
    <AuthenticatedLayout>
        <Head title="Meeting Rooms" />
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <Link :href="route('dashboard.meetingrooms.create')">
                    <button
                        class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    >
                        ADD MEETING ROOM
                    </button>
                </Link>
            </div>
        </div>

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Meeting Rooms
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
                    Available places
                </th>
                <th class="bg-blue-100 border text-left px-8 py-4">Actions</th>
            </tr>
            <tr v-for="meetingroom in meetingrooms" :key="meetingroom.id">
                <td class="border px-8 py-4">{{ meetingroom.id }}</td>
                <td class="border px-8 py-4">{{ meetingroom.name }}</td>
                <td class="border px-8 py-4">{{ meetingroom.description }}</td>
                <td class="border px-8 py-4">
                    {{ meetingroom.available_places }}
                </td>

                <td class="border px-8 py-4">Delete Edit</td>
            </tr>
        </table>
    </AuthenticatedLayout>
</template>
