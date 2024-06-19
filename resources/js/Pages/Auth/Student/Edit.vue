<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
  student: {
    type: Object,
    required: true,
  },
  classes: {
    type: Array,
    required: true,
  },
});

const form = useForm({
  identifier: props.student.id.toString(),
  first_name: props.student.first_name,
  last_name: props.student.last_name,
  student_class_id: props.student.student_class_id,
  comments: props.student.comments,
});

const submit = () => {
  form.put(route('students.update', { student: props.student.id }));
};
</script>

<template>
  <GuestLayout>
    <Head title="Tworzenie wydarzenia" />

    <form @submit.prevent="submit">
      <div>
        <InputLabel for="identifier" value="Identyfikator nauczyciela" />
        <TextInput
          id="identifier"
          type="text"
          class="mt-1 block w-full"
          v-model="form.identifier"
          required
          readonly
        />
      </div>

      <div class="mt-4">
        <InputLabel for="first_name" value="Imię" />

        <TextInput
          id="first_name"
          type="text"
          class="mt-1 block w-full"
          v-model="form.first_name"
          required
          autofocus
          autocomplete="first_name"
        />

        <InputError class="mt-2" :message="form.errors.first_name" />
      </div>

      <div class="mt-4">
        <InputLabel for="last_name" value="Nazwisko" />

        <TextInput
          id="last_name"
          type="text"
          class="mt-1 block w-full"
          v-model="form.last_name"
          required
          autocomplete="last_name"
        />

        <InputError class="mt-2" :message="form.errors.last_name" />
      </div>

      <div class="mt-4">
        <InputLabel for="student_class_id" value="Wybierz klase" />
        <select
          v-model="form.student_class_id"
          id="student_class_id"
          required
          class="select-default"
        >
          <option disabled value="">Wybierz</option>
          <option
            v-for="singleClass in classes"
            :value="singleClass.id"
            :key="singleClass"
          >
            {{ singleClass.name + ' - ' + singleClass.academic_year }}
          </option>
        </select>
        <InputError class="mt-2" :message="form.errors.student_class_id" />
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
