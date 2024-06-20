<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
  activity: {
    type: Object,
    required: true,
  },
  activities: {
    type: Array,
    required: true,
  },
});

const now = new Date();
now.setHours(now.getHours() + 2);
const formattedDateTime = now.toISOString().slice(0, 16);

const form = useForm({
  activity_id: props.activity.id,
  lesson_topic: '',
  lesson_datetime: formattedDateTime,
  comments: '',
});

const submit = () => {
  form.post(route('lesson.store'), {
    onSuccess: () => {
      window.location.href = route('lessons', { activity: props.activity.id });
    },
  });
};
</script>

<template>
  <GuestLayout>
    <Head title="Nowa lekcja" />

    <form @submit.prevent="submit">
      <div>
        <InputLabel for="activity_id" value="Zajęcia" />
        <select
          v-model="form.activity_id"
          id="activity_id"
          required
          class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full"
        >
          <option disabled value="">Wybierz</option>
          <option
            v-for="activity in activities"
            :value="activity.id"
            :key="activity"
          >
            {{ activity.subject.name }} - {{ activity.student_class.name }}
          </option>
        </select>
        <InputError class="mt-2" :message="form.errors.activity_id" />
      </div>
      <div class="mt-4">
        <InputLabel for="lesson_topic" value="Temat lekcji" />

        <TextInput
          id="lesson_topic"
          type="text"
          class="mt-1 block w-full"
          v-model="form.lesson_topic"
          required
          autofocus
          autocomplete="lesson_topic"
        />

        <InputError class="mt-2" :message="form.errors.lesson_topic" />
      </div>
      <div class="mt-4">
        <InputLabel for="date" value="Data" />

        <input
          type="datetime-local"
          id="date"
          v-model="form.lesson_datetime"
          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
        />

        <InputError class="mt-2" :message="form.errors.date" />
      </div>
      <div class="mt-4">
        <InputLabel for="comments" value="Uwagi do zajęć" />
        <textarea
          placeholder="Tutaj wpisz uwagi..."
          id="comments"
          type="text"
          class="mt-1 block w-full"
          v-model="form.comments"
        ></textarea>
      </div>
      <div class="flex items-center justify-end mt-4">
        <Link
          :href="route('lessons', { activity: activity.id })"
          class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
        >
          Powrót do panelu
        </Link>

        <PrimaryButton
          class="ms-4"
          :class="{ 'opacity-25': form.processing }"
          :disabled="form.processing"
        >
          Wpisz lekcje
        </PrimaryButton>
      </div>
    </form>
  </GuestLayout>
</template>
