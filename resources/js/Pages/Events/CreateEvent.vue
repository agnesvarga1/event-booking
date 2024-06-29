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

let availableRooms = ref([]);
let selectedRoomId = null;
let selectedRoomName = "";
let isRoom = false;
let isErr = false;
let frontEndErrMsg = ref();

const form = useForm({
    name: "",
    description: "",
    image: "",
    start_date: "",
    end_date: "",
    meeting_room_id: "",
});

const clearErrs = () => {
    frontEndErrMsg = "";
    // isErr = false;
};

const checkValidDate = (start, end) => {
    clearErrs();
    let today = Date.now();
    start = new Date(start).getTime();
    end = new Date(end).getTime();
    if (start < today) {
        frontEndErrMsg = "The start date can NOT be before today";
        isErr = true;
    } else if (start > end) {
        frontEndErrMsg = "The end date can NOT be earlier start date";
        isErr = true;
    }
};

function searchMeetingRoom() {
    checkValidDate(form.start_date, form.end_date);
    //console.log(isErr);
    if (isErr) {
        setTimeout(clearErrs, 6000);
    }
    form.post("/filter", {
        onSuccess: (page) => {
            availableRooms.value = page.props.meetingrooms;
        },
    });
}

const selectMeetingRoom = (id, name) => {
    isRoom = true;
    availableRooms = ref([]);
    selectedRoomId = id;
    selectedRoomName = name;
};

const submitEvent = () => {
    //console.log(selectedRoomId);
    form.meeting_room_id = selectedRoomId;
    form.post(route("dashboard.events.store"), {
        forceFormData: true,
    });

    // router.post("dashboard/events", form, {
    //     forceFormData: true,
    // });
};
</script>

<template>
    <Head title="Events | Create" />

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
                        <InputError
                            class="mt-2"
                            :message="form.errors.description"
                        />
                    </div>
                    <div class="mt-4">
                        <InputLabel for="image" value="Event Flyer Image" />
                        <input
                            id="image"
                            type="file"
                            @input="form.image = $event.target.files[0]"
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"
                        />
                        <InputError class="mt-2" :message="form.errors.image" />
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
                            <InputError
                                class="mt-2"
                                :message="
                                    form.errors.start_date || frontEndErrMsg
                                "
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
                            <InputError
                                class="mt-2"
                                :message="form.errors.end_date"
                            />
                        </div>
                    </div>
                    <div v-if="selectedRoomName !== ''" class="w-1/2 mt-2">
                        <h4>Meeting Room Selected: {{ selectedRoomName }}</h4>
                    </div>
                    <div
                        v-if="
                            availableRooms.length > 0 &&
                            isRoom === false &&
                            isErr === false
                        "
                        class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-3"
                    >
                        <h2>Available Meeting Rooms</h2>
                        <h4 class="mt-2">
                            Meetingrooms ({{ availableRooms.length }})
                        </h4>
                        <div class="overflow-y-auto max-h-96">
                            <table
                                class="shadow-lg bg-white mx-auto mt-3 w-full"
                            >
                                <tr>
                                    <th
                                        class="bg-blue-100 border text-left px-8 py-4"
                                    >
                                        Name
                                    </th>
                                    <th
                                        class="bg-blue-100 border text-left px-8 py-4"
                                    >
                                        Description
                                    </th>
                                    <th
                                        class="bg-blue-100 border text-left px-8 py-4"
                                    >
                                        Available places
                                    </th>
                                    <th
                                        class="bg-blue-100 border text-left px-8 py-4"
                                    >
                                        Actions
                                    </th>
                                </tr>
                                <tr
                                    v-for="meetingroom in availableRooms"
                                    :key="meetingroom.id"
                                >
                                    <td class="border px-8 py-4">
                                        {{ meetingroom.name }}
                                    </td>
                                    <td class="border px-8 py-4">
                                        {{ meetingroom.description }}
                                    </td>
                                    <td class="border px-8 py-4">
                                        {{ meetingroom.available_places }}
                                    </td>

                                    <td class="border px-8 py-4">
                                        <PrimaryButton
                                            @click="
                                                selectMeetingRoom(
                                                    meetingroom.id,
                                                    meetingroom.name
                                                )
                                            "
                                            >Select</PrimaryButton
                                        >
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <SecondaryButton type="submit" class="mt-3"
                        >Search</SecondaryButton
                    >
                    <form class="inline mx-2" @submit.prevent="submitEvent()">
                        <input
                            id="meeting_room_id"
                            type="hidden"
                            :value="selectedRoomId"
                        />
                        <PrimaryButton
                            v-if="selectedRoomId !== null"
                            type="submit"
                            >Book event</PrimaryButton
                        >
                    </form>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
