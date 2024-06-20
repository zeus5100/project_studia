<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { lessonTimers, daysOfWeek, updateEndTime } from '@/data.js';

import {
  Notivue,
  Notification,
  NotivueSwipe,
  NotificationProgress,
  push,
} from 'notivue';

const props = defineProps({
  activity: {
    type: Object,
    required: true,
  },
  students: {
    type: Array,
    required: true,
  },
});

const activity_name = props.activity.subject.name;
const now = new Date();
now.setHours(now.getHours() + 2);
const formattedDateTime = now.toISOString().slice(0, 16);

const form = useForm({
  activity_id: props.activity.id,
  student_id: '',
  grade_date: formattedDateTime,
  grade_value: '',
  grade_weight: '',
  description: '',
});

const submit = () => {
  form.post(route('grade.store'), {
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
</script>

<template>
  <GuestLayout>
    <Head title="Wpisywanie oceny" />

    <Notivue v-slot="item">
      <NotivueSwipe :item="item">
        <Notification :item="item">
          <NotificationProgress :item="item" />
        </Notification>
      </NotivueSwipe>
    </Notivue>
    <form @submit.prevent="submit">
      <div>
        <InputLabel for="activity_id" value="Zajęcia" />

        <TextInput
          id="activity_id"
          type="text"
          class="mt-1 block w-full"
          v-model="activity_name"
          required
          readonly
        />
      </div>

      <div class="mt-4">
        <InputLabel for="student_id" value="Wybierz ucznia" />
        <select
          v-model="form.student_id"
          id="student_id"
          required
          class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full"
        >
          <option disabled value="">Wybierz</option>
          <option
            v-for="student in students"
            :value="student.id"
            :key="student"
          >
            {{ student.id }}. {{ student.first_name }} {{ student.last_name }}
          </option>
        </select>
        <InputError class="mt-2" :message="form.errors.student_id" />
      </div>

      <div class="mt-4">
        <InputLabel for="grade_value" value="Ocena" />

        <TextInput
          id="grade_value"
          type="text"
          class="mt-1 block w-full"
          v-model="form.grade_value"
          required
        />
        <InputError class="mt-2" :message="form.errors.grade_value" />
      </div>

      <div class="mt-4">
        <InputLabel for="grade_value" value="Waga" />

        <TextInput
          id="grade_weight"
          type="text"
          class="mt-1 block w-full"
          v-model="form.grade_weight"
          required
        />
        <InputError class="mt-2" :message="form.errors.grade_weight" />
      </div>
      <div class="mt-4">
        <InputLabel for="description" value="Opis oceny" />
        <textarea
          placeholder="Krótki opis oceny..."
          id="description"
          type="text"
          class="mt-1 block w-full"
          v-model="form.description"
        ></textarea>
      </div>
      <div class="flex items-center justify-end mt-4">
        <Link
          :href="route('activities.students.grades', { activity: activity.id })"
          class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
        >
          Powrót do ocen
        </Link>

        <PrimaryButton
          class="ms-4"
          :class="{ 'opacity-25': form.processing }"
          :disabled="form.processing"
        >
          Dodaj ocenę
        </PrimaryButton>
      </div>
    </form>
  </GuestLayout>
</template>
