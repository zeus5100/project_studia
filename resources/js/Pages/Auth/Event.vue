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
  room_id: '',
  name: '',
  date: '',
  description: '',
});

const allRooms = ref({});
const getAllRooms = async () => {
  await axios.get(route(`rooms.select`)).then(({ data }) => {
    allRooms.value = data;
  });
};

const submit = () => {
  form.post(route('events.store'), {
    onSuccess: () => {
      push.success({
        title: 'Sukces',
        message: 'Pomyślnie dodano nowe wydarzenie!',
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

onMounted(() => {
  getAllRooms();
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
        <InputLabel for="name" value="Nazwa wydarzenia" />

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
        <InputLabel for="date" value="Nazwisko" />

        <input
          type="datetime-local"
          id="date"
          v-model="form.date"
          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
        />

        <InputError class="mt-2" :message="form.errors.date" />
      </div>

      <div class="mt-4">
        <InputLabel for="description" value="Opis wydarzenia" />

        <textarea
          placeholder="Tutaj wpisz uwagi..."
          id="description"
          type="text"
          class="mt-1 block w-full"
          v-model="form.description"
          autocomplete="new-password"
        ></textarea>
        <InputError class="mt-2" :message="form.errors.description" />
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
          Dodaj wydarzenie
        </PrimaryButton>
      </div>
    </form>
  </GuestLayout>
</template>
