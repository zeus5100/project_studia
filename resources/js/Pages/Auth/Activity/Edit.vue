<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { lessonTimers, daysOfWeek, updateEndTime } from '@/data.js';

const props = defineProps({
  activity: {
    type: Object,
    required: true,
  },
  classes: {
    type: Array,
    required: true,
  },
  subjects: {
    type: Array,
    required: true,
  },
  rooms: {
    type: Array,
    required: true,
  },
  teachers: {
    type: Array,
    required: true,
  },
});

const form = useForm({
  identifier: props.activity.id.toString(),
  student_class_id: props.activity.student_class_id,
  subject_id: props.activity.subject_id,
  room_id: props.activity.room_id,
  teacher_id: props.activity.teacher_id,
  start_time: props.activity.start_time,
  end_time: props.activity.end_time,
  day_of_week: props.activity.day_of_week,
  comments: props.activity.comments,
});

const submit = () => {
  form.put(route('activities.update', { activity: props.activity.id }));
};
</script>

<template>
  <GuestLayout>
    <Head title="Edycja zajęć" />

    <form @submit.prevent="submit">
      <div>
        <InputLabel for="identifier" value="Identyfikator zajęć" />

        <TextInput
          id="identifier"
          type="text"
          class="mt-1 block w-full"
          v-model="form.identifier"
          required
          readonly
          autocomplete="identifier"
        />

        <InputError class="mt-2" :message="form.errors.identifier" />
      </div>

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
            v-for="singleClass in classes"
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
            v-for="subject in subjects"
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
          <option v-for="room in rooms" :value="room.id" :key="room">
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
            v-for="teacher in teachers"
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
          @change="updateEndTime(form)"
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
        ></textarea>
      </div>

      <div class="flex items-center justify-end mt-4">
        <Link
          :href="route('admin.manage', { table: 'activities' })"
          class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
        >
          Powrót do zarządzania
        </Link>

        <PrimaryButton
          class="ms-4"
          :class="{ 'opacity-25': form.processing }"
          :disabled="form.processing"
        >
          Zapisz
        </PrimaryButton>
      </div>
    </form>
  </GuestLayout>
</template>
