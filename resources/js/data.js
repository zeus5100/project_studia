import { ref } from 'vue';

export const lessonTimers = ref([
    { start: '08:00:00', end: '08:45:00' },
    { start: '08:50:00', end: '09:35:00' },
    { start: '09:45:00', end: '10:30:00' },
    { start: '10:40:00', end: '11:25:00' },
    { start: '11:40:00', end: '12:25:00' },
    { start: '12:35:00', end: '13:20:00' },
    { start: '13:30:00', end: '14:15:00' },
    { start: '14:20:00', end: '15:05:00' },
]);

export const daysOfWeek = ['Poniedziałek', 'Wtorek', 'Środa', 'Czwartek', 'Piątek'];

export const updateEndTime = (form) => {
    form.end_time = lessonTimers.value.find(
        (lesson) => lesson.start === form.start_time
    ).end;
};