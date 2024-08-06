<script setup>
import { ref, computed, watch } from "vue";
import moment from "moment";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { Head, router } from "@inertiajs/vue3";

const props = defineProps({
    events: Array,
});
//event dates in week

const currentWeekStart = ref(moment().startOf("week"));
const currWeekEnd = moment(currentWeekStart.value).endOf("week");
let events = ref(props.events);
let colspanVal = 1;
let weekDays = computed(() => {
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

const funGetWeekDays = () => {
    let days = [];
    for (let i = 0; i < 7; i++) {
        const day = moment(currentWeekStart.value).add(i, "days");
        days.push({
            name: day.format("dddd"),
            date: day.format("YYYY-MM-DD"),
        });
    }
    //console.log(days);
    return days;
};
//send data to backend logic
const sendData = (s, e) => {
    router.post(
        "/dashboard/weeklyview",
        {
            startOfWeek: s.format("YYYY-MM-DD"),
            endOfWeek: e.format("YYYY-MM-DD"),
        },
        {
            //     preserveState: true,
            onSuccess: (page) => {
                events.value = page.props.events;
            },
        }
    );
};

const nextWeek = () => {
    currentWeekStart.value = moment(currentWeekStart.value).add(1, "weeks");
    const endOfWeek = moment(currentWeekStart.value).endOf("week");
    //sending data
    sendData(currentWeekStart.value, endOfWeek);
    weekDays = funGetWeekDays();
};

const prevWeek = () => {
    currentWeekStart.value = moment(currentWeekStart.value).subtract(
        1,
        "weeks"
    );
    const endOfWeek = moment(currentWeekStart.value).endOf("week");
    sendData(currentWeekStart.value, endOfWeek);
    weekDays = funGetWeekDays();
};

const getEventColspan = (event, date) => {
    const eventEnd = moment(event.end_date);
    const eventStart = moment(event.start_date);
    const currentDate = moment(date);
    const endOfWeek = moment(currentWeekStart.value).endOf("week");

    if (currentDate.isBetween(eventStart, eventEnd, "days", "[]")) {
        if (eventStart.isBefore(currentWeekStart.value)) {
            colspanVal = Math.min(
                eventEnd.diff(currentDate, "days") + 1,
                endOfWeek.diff(currentDate, "days") + 1
            );
        } else {
            colspanVal = Math.min(
                eventEnd.diff(eventStart, "days") + 1,
                endOfWeek.diff(eventStart, "days") + 1
            );
        }
        return colspanVal;
    }
    return 1;
};

const isStartDate = (event, date) => {
    const eventStartDate = moment(event.start_date).format("YYYY-MM-DD");
    const eventEndDate = moment(event.end_date).format("YYYY-MM-DD");
    const currentWeekStartDate = moment(currentWeekStart.value).format(
        "YYYY-MM-DD"
    );

    // Check if the event starts on the given date
    if (eventStartDate === date) {
        //  console.log(eventStartDate);
        return true;
    }

    if (
        eventStartDate < currentWeekStartDate &&
        eventEndDate >= date &&
        date === currentWeekStartDate
    ) {
        return true;
    }
    return false;
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
                    <td class="border px-3 relative">
                        <div
                            class="absolute top-0 left-0 w-full h-full font-bold text-center bg-slate-300 pt-2"
                        >
                            {{ event.meetingroom.name }}
                        </div>
                    </td>
                    <template v-for="day in weekDays" :key="day.date">
                        <td
                            v-if="
                                event.start_date > day.date ||
                                event.end_date < day.date ||
                                day.date >= weekDays[6]
                            "
                            class="border px-3 relative"
                            colspan="1"
                        ></td>
                        <td
                            class="border px-3 eventcell relative"
                            :colspan="
                                isStartDate(event, day.date)
                                    ? getEventColspan(event, day.date)
                                    : 1
                            "
                        >
                            <div
                                v-if="isStartDate(event, day.date)"
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
.eventcell:not(:has(div)) {
    display: none;
}
</style>
