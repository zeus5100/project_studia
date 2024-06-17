<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
  subject: {
    type: Object,
    required: true,
  },
});

const form = useForm({
  identifier: props.subject.id.toString(),
  name: props.subject.name,
});

const submit = () => {
  form.put(route('subjects.update', { subject: props.subject.id }));
};
</script>

<template>
  <GuestLayout>
    <Head title="Tworzenie wydarzenia" />

    <form @submit.prevent="submit">
      <div>
        <InputLabel for="identifier" value="Identyfikator przedmiotu" />

        <TextInput
          id="identifier"
          type="text"
          class="mt-1 block w-full"
          v-model="form.identifier"
          required
          readonly
          autocomplete="identifier"
        />

        <InputError class="mt-2" :message="form.errors.identyficator" />
      </div>

      <div class="mt-4">
        <InputLabel for="name" value="Nazwa przedmiotu" />

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

      <div class="flex items-center justify-end mt-4">
        <Link
          :href="route('admin.manage', { table: 'subjects' })"
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
