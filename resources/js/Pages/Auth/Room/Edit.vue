<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
  room: {
    type: Object,
    required: true,
  },
});

const form = useForm({
  identifier: props.room.id.toString(),
  room_number: props.room.room_number,
  capacity: props.room.capacity,
  description: props.room.description,
});

const submit = () => {
  form.put(route('rooms.update', { room: props.room.id }));
};
</script>

<template>
  <GuestLayout>
    <Head title="Edycja sali" />

    <form @submit.prevent="submit">
      <div>
        <InputLabel for="identifier" value="Identyfikator sali" />

        <TextInput
          id="identifier"
          type="text"
          class="mt-1 block w-full"
          v-model="form.identifier"
          required
          readonly
          autocomplete="identifier"
        />
      </div>

      <div class="mt-4">
        <InputLabel for="room_number" value="Numer sali" />

        <TextInput
          id="room_number"
          type="text"
          class="mt-1 block w-full"
          v-model="form.room_number"
          required
          autofocus
          autocomplete="room_number"
        />

        <InputError class="mt-2" :message="form.errors.room_number" />
      </div>

      <div class="mt-4">
        <InputLabel for="capacity" value="Liczba miejsc" />

        <TextInput
          id="capacity"
          type="text"
          class="mt-1 block w-full"
          v-model="form.capacity"
          required
          autofocus
          autocomplete="capacity"
        />

        <InputError class="mt-2" :message="form.errors.capacity" />
      </div>

      <div class="mt-4">
        <InputLabel for="description" value="Opis sali" />
        <textarea
          placeholder="Tutaj wpisz opis..."
          id="description"
          type="text"
          class="mt-1 block w-full"
          v-model="form.description"
          autocomplete="new-password"
        ></textarea>
      </div>

      <div class="flex items-center justify-end mt-4">
        <Link
          :href="route('admin.manage', { table: 'directions' })"
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
