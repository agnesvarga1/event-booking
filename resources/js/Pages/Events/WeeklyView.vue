<script setup>
import { ref, computed, onMounted } from "vue";
import moment from "moment";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { Head } from "@inertiajs/vue3";
import { Inertia } from "@inertiajs/inertia";
const props = defineProps({
    events: Array,
});

const currentWeekStart = ref(moment().startOf("week"));
let events = ref(props.events);

const weekDays = computed(() => {
    let days = [];
    for (let i = 0; i < 7; i++) {
        const day = moment(currentWeekStart.value).add(i, "days");
        days.push({
            name: day.format("dddd"),
            date: day.format("YYYY-MM-DD"),
        });
    }

    return days;
});

// onMounted(() => {
//     console.log(events.value);
// });

const sendData = (s, e) => {
    Inertia.post(
        "/dashboard/weeklyview",
        {
            startOfWeek: s,
            endOfWeek: e,
        }
        // {
        //     onSuccess: () => {
        //         events = props.events;
        //         // currentWeekStart.value = weekStart;
        //     },
        // }
    );
};

const nextWeek = () => {
    currentWeekStart.value = moment(currentWeekStart.value).add(1, "weeks");
    const endOfWeek = moment(currentWeekStart.value).endOf("week");

    sendData(currentWeekStart.value, endOfWeek);
};

const prevWeek = () => {
    currentWeekStart.value = moment(currentWeekStart.value).subtract(
        1,
        "weeks"
    );
};

const getEventColspan = (event, date) => {
    if (moment(event.start_date).format("YYYY-MM-DD") === date) {
        const eventEnd = moment(event.end_date);
        const endOfWeek = moment(currentWeekStart.value).endOf("week");

        return Math.min(
            endOfWeek.diff(moment(date), "days") + 1,
            eventEnd.diff(moment(date), "days") + 1
        );
    }
};

const isStartDate = (event, date) => {
    return moment(event.start_date).format("YYYY-MM-DD") === date; //boolean
};
</script>

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
            <thead>
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
            </thead>
            <tbody>
                <tr v-for="event in events" :key="event.id">
                    <td class="border px-3">
                        {{ event.meetingroom.name }}
                    </td>
                    <template v-for="day in weekDays" :key="day.date">
                        <td
                            v-if="!isStartDate(event, day.date)"
                            class="border px-3 relative"
                            colspan="1"
                        ></td>
                        <td
                            v-else
                            class="border px-3 relative"
                            :colspan="
                                isStartDate(event, day.date)
                                    ? getEventColspan(event, day.date)
                                    : 1
                            "
                        >
                            <div
                                :style="{ background: event.color }"
                                class="absolute top-0 left-0 w-full h-full font-bold text-center align-middle"
                            >
                                #{{ event.id }} {{ event.name }}
                            </div>
                        </td>
                    </template>
                </tr>
            </tbody>
        </table>
    </AuthenticatedLayout>
</template>

<style scoped>
tbody tr td {
    height: 3rem;
}
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
