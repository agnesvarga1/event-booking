<template>
    <Head title="WeeklyView | Events" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Weekly Schedule Events and Meetingrooms
            </h2>
        </template>
        <div
            class="controls mx-auto mt-3 max-w-7xl text-center flex justify-center"
        >
            <SecondaryButton @click="prevWeek">Previous Week</SecondaryButton>
            <h2 class="mx-3">Search Events</h2>
            <SecondaryButton @click="nextWeek">Next Week</SecondaryButton>
        </div>
        <table class="shadow-lg bg-white mx-auto mt-3 max-w-7xl">
            <tr>
                <th class="bg-blue-100 border text-left px-3 py-2">
                    Meetingroom name
                </th>
                <th
                    v-for="day in weekDays"
                    :key="day.date"
                    class="bg-blue-100 border text-left px-3 py-2"
                >
                    <span class="block">
                        {{ day.name }}
                    </span>
                    <span class="block">
                        {{ day.date }}
                    </span>
                </th>
            </tr>
        </table>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, computed } from "vue";
import moment from "moment";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

const currentWeekStart = ref(moment().startOf("week"));

const weekDays = computed(() => {
    let days = [];
    for (let i = 0; i < 7; i++) {
        const day = moment(currentWeekStart.value).add(i, "days");
        days.push({
            name: day.format("dddd"),
            date: day.format("MMMM D YYYY"),
        });
    }
    return days;
});

const nextWeek = () => {
    currentWeekStart.value = moment(currentWeekStart.value).add(1, "weeks");
};

const prevWeek = () => {
    currentWeekStart.value = moment(currentWeekStart.value).subtract(
        1,
        "weeks"
    );
};

// return {
//     weekDays,
//     nextWeek,
//     prevWeek,
// };
</script>

<style scoped>
.schedule {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.controls {
    margin-bottom: 20px;
}

.week {
    display: flex;
    justify-content: space-around;
    width: 100%;
}

.day {
    text-align: center;
}
</style>
