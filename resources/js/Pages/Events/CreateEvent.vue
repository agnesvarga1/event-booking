<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

import { reactive, ref } from "vue";
import { router } from "@inertiajs/vue3";

const form = useForm({
    name: "",
    description: "",
    image: "",
    start_date: "",
    end_date: "",
});
const availableRooms = ref([]);

function searchMeetingRoom() {
    form.post("/filter", {
        onSuccess: (page) => {
            // console.log(page.props.meetingrooms);
            availableRooms.value = page.props.meetingrooms;
            console.log(availableRooms);
        },
    });
}

// const form = useForm({
//     name: "",
//     description: "",
//     image: "",
//     start_date: "",
//     end_date: "",
//     meeting_room_id: "",
// });
</script>

<template>
    <Head title="Events|Create" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Add a new event
            </h2>
        </template>
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <form
                    class="w-4/5 mx-auto"
                    @submit.prevent="searchMeetingRoom()"
                >
                    <h2
                        class="font-semibold text-xl text-gray-800 leading-tight"
                    >
                        Form
                    </h2>
                    <InputLabel for="name" value="Event name" />
                    <TextInput
                        id="name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.name"
                        required
                        autofocus
                        placeholder="My event title"
                    />

                    <InputError class="mt-2" :message="form.errors.name" />

                    <div class="mt-4">
                        <InputLabel for="description" value="Description" />
                        <textarea
                            id="description"
                            name="description"
                            rows="4"
                            cols="50"
                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            v-model="form.description"
                            placeholder="Description of the event"
                        >
                        </textarea>
                    </div>
                    <div class="mt-4">
                        <InputLabel for="image" value="Event Flyer Image" />
                        <input
                            id="image"
                            type="file"
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"
                        />
                    </div>
                    <div class="mt-4 flex">
                        <div class="w-1/2 mr-2">
                            <InputLabel
                                for="start_date"
                                value="Event Start Date"
                            />
                            <input
                                id="start_date"
                                type="date"
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"
                                v-model="form.start_date"
                                required
                            />
                        </div>

                        <div class="w-1/2">
                            <InputLabel for="end_date" value="Event end Date" />
                            <input
                                id="end_date"
                                type="date"
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"
                                v-model="form.end_date"
                                required
                            />
                        </div>
                    </div>

                    <SecondaryButton type="submit" class="mt-2"
                        >Search</SecondaryButton
                    >
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
