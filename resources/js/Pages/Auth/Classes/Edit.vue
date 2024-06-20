<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
  student_class: {
    type: Object,
    required: true,
  },
  directions: {
    type: Array,
    required: true,
  },
  teachers: {
    type: Array,
    required: true,
  },
});

const form = useForm({
  identifier: props.student_class.id.toString(),
  academic_year: props.student_class.academic_year,
  name: props.student_class.name,
  student_count: props.student_class.student_count.toString(),
  comments: props.student_class.comments,
  study_direction_id: props.student_class.study_direction_id,
  teacher_id: props.student_class.teacher_id,
});

const submit = () => {
  form.put(route('classes.update', { studentClass: props.student_class.id }));
};
</script>

<template>
  <GuestLayout>
    <Head title="Edycja klasy" />

    <form @submit.prevent="submit">
      <div>
        <InputLabel for="identifier" value="Identyfikator klasy" />

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

      <div class="mt-4">
        <InputLabel for="study_direction_id" value="Wybierz kierunek" />
        <select
          v-model="form.study_direction_id"
          id="study_direction_id"
          required
          class="select-default"
        >
          <option disabled value="">Wybierz</option>
          <option
            v-for="direction in directions"
            :value="direction.id"
            :key="direction"
          >
            {{ direction.name }}
          </option>
        </select>
        <InputError class="mt-2" :message="form.errors.study_direction_id" />
      </div>

      <div class="mt-4">
        <InputLabel for="teacher_id" value="Wybierz nauczyciela" />
        <select
          v-model="form.teacher_id"
          id="teacher_id"
          required
          class="select-default"
        >
          <option disabled value="">Wybierz</option>
          <option
            v-for="teacher in teachers"
            :value="teacher.id"
            :key="teacher"
          >
            {{ teacher.first_name + ' ' + teacher.last_name }}
          </option>
        </select>
        <InputError class="mt-2" :message="form.errors.teacher_id" />
      </div>

      <div class="mt-4">
        <InputLabel for="name" value="Nazwa klasy" />

        <TextInput
          id="name"
          type="text"
          class="mt-1 block w-full"
          v-model="form.name"
          required
          autofocus
          autocomplete="name"
        />

        <InputError class="mt-2" :message="form.errors.name" />
      </div>

      <div class="mt-4">
        <InputLabel for="academic_year" value="Rok akademicki" />

        <TextInput
          id="academic_year"
          type="text"
          class="mt-1 block w-full"
          v-model="form.academic_year"
          required
          autocomplete="academic_year"
        />

        <InputError class="mt-2" :message="form.errors.academic_year" />
      </div>

      <div class="mt-4">
        <InputLabel for="student_count" value="Liczba uczniów" />

        <TextInput
          id="student_count"
          type="text"
          class="mt-1 block w-full"
          v-model="form.student_count"
          required
          readonly
          autocomplete="student_count"
        />

        <InputError class="mt-2" :message="form.errors.student_count" />
      </div>

      <div class="mt-4">
        <InputLabel for="comments" value="Uwagi" />

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
          :href="route('admin.manage', { table: 'teachers' })"
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
