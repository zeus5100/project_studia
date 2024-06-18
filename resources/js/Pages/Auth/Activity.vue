<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';

import { Notivue, Notification, NotificationProgress, push } from 'notivue';

const form = useForm({
  student_class_id: '',
  subject_id: '',
  room_id: '',
  teacher_id: '',
  start_time: '',
  end_time: '',
  day_of_week: '',
  comments: '',
});

const updateEndTime = () => {
  form.end_time = lessonTimers.value.find(
    (lesson) => lesson.start === form.start_time
  ).end;
};

const lessonTimers = ref([
  { start: '08:00:00', end: '08:45:00' },
  { start: '08:50:00', end: '09:35:00' },
  { start: '09:45:00', end: '10:30:00' },
  { start: '10:40:00', end: '11:25:00' },
  { start: '11:40:00', end: '12:25:00' },
  { start: '12:35:00', end: '13:20:00' },
  { start: '13:30:00', end: '14:15:00' },
  { start: '14:20:00', end: '15:05:00' },
]);

const daysOfWeek = ['Poniedziałek', 'Wtorek', 'Środa', 'Czwartek', 'Piątek'];

const fetchData = async (url) => {
  const { data } = await axios.get(route(`${url}.select`));
  return data;
};

const allRooms = ref({});
const allClasses = ref({});
const allSubjects = ref({});
const allTeachers = ref({});

const submit = () => {
  form.post(route('activities.store'), {
    onSuccess: () => {
      push.success({
        title: 'Sukces',
        message: 'Pomyślnie dodano nowe zajęcia!',
      });
      form.reset();
    },
    onError: () => {
      push.error({
        title: 'Błąd',
        message: 'Nie wszystkie pola zostały poprawnie wypełnione',
      });
    },
  });
};

onMounted(async () => {
  allRooms.value = await fetchData('rooms');
  allClasses.value = await fetchData('classes');
  allSubjects.value = await fetchData('subjects');
  allTeachers.value = await fetchData('teachers');
});
</script>

<template>
  <GuestLayout>
    <Head title="Tworzenie wydarzenia" />

    <Notivue v-slot="item">
      <Notification :item="item">
        <NotificationProgress :item="item" />
      </Notification>
    </Notivue>
    <form @submit.prevent="submit">
      <div>
        <InputLabel for="student_class_id" value="Wybierz klase" />
        <select
          v-model="form.student_class_id"
          id="student_class_id"
          required
          class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full"
        >
          <option disabled value="">Wybierz</option>
          <option
            v-for="singleClass in allClasses"
            :value="singleClass.id"
            :key="singleClass"
          >
            {{ singleClass.name }} - {{ singleClass.academic_year }}
          </option>
        </select>
        <InputError class="mt-2" :message="form.errors.student_class_id" />
      </div>

      <div class="mt-4">
        <InputLabel for="subject_id" value="Wybierz przedmiot" />
        <select
          v-model="form.subject_id"
          id="subject_id"
          required
          class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full"
        >
          <option disabled value="">Wybierz</option>
          <option
            v-for="subject in allSubjects"
            :value="subject.id"
            :key="subject"
          >
            {{ subject.name }}
          </option>
        </select>
        <InputError class="mt-2" :message="form.errors.subject_id" />
      </div>

      <div class="mt-4">
        <InputLabel for="room_id" value="Wybierz sale" />
        <select
          v-model="form.room_id"
          id="room_id"
          required
          class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full"
        >
          <option disabled value="">Wybierz</option>
          <option v-for="room in allRooms" :value="room.id" :key="room">
            {{ room.room_number }} - {{ room.description }}
          </option>
        </select>
        <InputError class="mt-2" :message="form.errors.room_id" />
      </div>

      <div class="mt-4">
        <InputLabel for="teacher_id" value="Wybierz nauczyciela" />
        <select
          v-model="form.teacher_id"
          id="teacher_id"
          required
          class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full"
        >
          <option disabled value="">Wybierz</option>
          <option
            v-for="teacher in allTeachers"
            :value="teacher.id"
            :key="teacher"
          >
            {{ teacher.first_name }} - {{ teacher.last_name }}
          </option>
        </select>
        <InputError class="mt-2" :message="form.errors.teacher_id" />
      </div>

      <div class="mt-4">
        <InputLabel for="day_of_week" value="Dzień tygodnia" />
        <select
          v-model="form.day_of_week"
          id="day_of_week"
          required
          class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full"
        >
          <option disabled value="">Wybierz</option>
          <option v-for="(day, key) in daysOfWeek" :value="key + 1" :key="key">
            {{ day }}
          </option>
        </select>
        <InputError class="mt-2" :message="form.errors.start_time" />
      </div>

      <div class="mt-4">
        <InputLabel for="start_time" value="Wybierz lekcje" />
        <select
          v-model="form.start_time"
          id="start_time"
          required
          @change="updateEndTime"
          class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full"
        >
          <option disabled value="">Wybierz</option>
          <option
            v-for="(lesson, key) in lessonTimers"
            :value="lesson.start"
            :key="key"
          >
            {{ key + 1 }}. {{ lesson.start }} - {{ lesson.end }}
          </option>
        </select>
        <InputError class="mt-2" :message="form.errors.start_time" />
      </div>
      <div class="mt-4">
        <InputLabel for="comments" value="Uwagi do zajęć" />
        <textarea
          placeholder="Tutaj wpisz uwagi..."
          id="comments"
          type="text"
          class="mt-1 block w-full"
          v-model="form.comments"
          autocomplete="new-password"
        ></textarea>
      </div>
      <div class="flex items-center justify-end mt-4">
        <Link
          :href="route('admin.dashboard')"
          class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
        >
          Powrót do panelu
        </Link>

        <PrimaryButton
          class="ms-4"
          :class="{ 'opacity-25': form.processing }"
          :disabled="form.processing"
        >
          Dodaj zajęcie
        </PrimaryButton>
      </div>
    </form>
  </GuestLayout>
</template>
