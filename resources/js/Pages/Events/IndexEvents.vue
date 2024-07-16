<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
    events: Array,
});

const truncateText = (t) => {
    if (t !== null) {
        return t.substring(0, 50) + "...";
    } else {
        return "No description provided to this event";
    }
};

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
                <th class="bg-blue-100 border text-left px-3 py-2">Id</th>
                <th class="bg-blue-100 border text-left px-3 py-2">Name</th>
                <th class="bg-blue-100 border text-left px-3 py-2">
                    Description
                </th>
                <th class="bg-blue-100 border text-left px-3 py-2">
                    Start Date
                </th>

                <th class="bg-blue-100 border text-left px-3 py-2">End Date</th>
                <th class="bg-blue-100 border text-left px-3 py-2">
                    Meeting Room
                </th>
                <th class="bg-blue-100 border text-left px-3 py-2">Actions</th>
            </tr>

            <tr v-for="event in events" :key="event.id">
                <td
                    :style="{ background: event.color }"
                    class="border px-3 py-2"
                >
                    <span class="text-white"> {{ event.id }} </span>
                </td>

                <td class="border px-3 py-2 cursor-pointer">
                    <Link
                        :href="
                            route(`dashboard.events.show`, { slug: event.slug })
                        "
                    >
                        {{ event.name }}
                    </Link>
                </td>

                <td class="border px-3 py-2 desc">
                    {{ truncateText(event.description) }}
                </td>
                <td class="border px-3 py-2">
                    {{ event.start_date }}
                </td>
                <td class="border px-3 py-2">
                    {{ event.end_date }}
                </td>
                <td class="border px-3 py-2">
                    {{ event.meetingroom.id }} |
                    {{ event.meetingroom.name }}
                </td>
                <td class="border px-3 py-2">Delete Edit</td>
            </tr>
        </table>
    </AuthenticatedLayout>
</template>
<style>
/* .desc {
    text-overflow: ellipsis;
} */
td {
    font-size: 1rem;
}
</style>
