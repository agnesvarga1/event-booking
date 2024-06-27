<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

const form = useForm({
    name: "",
    description: "",
    available_places: "",
});

const submitRoom = () => {
    form.post(route("dashboard.meetingrooms.store"));
};
</script>
<template>
    <AuthenticatedLayout>
        <Head title="Add meeting room" />
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Form to create a new meeting room
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <form class="w-4/5 mx-auto" @submit.prevent="submitRoom()">
                    <div>
                        <InputLabel for="name" value="Meeting room name" />

                        <TextInput
                            id="name"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.name"
                            required
                            autofocus
                            placeholder="Kate"
                        />

                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="description" value="Description" />
                        <textarea
                            id="description"
                            name="description"
                            rows="4"
                            cols="50"
                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            v-model="form.description"
                            placeholder="Meeting room description"
                        >
                        </textarea>

                        <!-- <InputError class="mt-2" :message="form.errors.password" />-->
                    </div>

                    <div class="mt-4">
                        <InputLabel
                            for="available_places"
                            value="Available Places"
                        />

                        <!-- <TextInput
                            id="available_places"
                            type="number"
                            class="mt-1 block w-full"
                            v-model="form.available_places"
                            required
                            autocomplete="new-password"
                            placeholder="45"
                        /> -->
                        <input
                            id="available_places"
                            type="number"
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"
                            v-model="form.available_places"
                            required
                            placeholder="45"
                        />

                        <!-- <InputError
                    class="mt-2"
                    :message="form.errors.password_confirmation"
                /> -->
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <PrimaryButton
                            class="ms-4"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                        >
                            Add
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
