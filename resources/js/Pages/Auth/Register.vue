<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import {
  Notivue,
  Notification,
  NotivueSwipe,
  NotificationProgress,
  push,
} from 'notivue';

const form = useForm({
  first_name: '',
  last_name: '',
  phone: '',
  email: '',
  login: '',
  password: '',
  password_confirmation: '',
  comments: '',
  selected_role: '',
  class_id: '',
});

const optionsRole = ref([
  { text: 'Nauczyciel', value: '1' },
  { text: 'Uczeń', value: '2' },
]);

const allClasses = ref({});
const getAllClasses = async () => {
  await axios.get(route(`classes.select`)).then(({ data }) => {
    allClasses.value = data;
  });
};

const submit = () => {
  form.post(route('register'), {
    onSuccess: () => {
      push.success({
        title: 'Sukces',
        message:
          'Pomyślnie dodano nowego użytkownika(' +
          optionsRole.value[form.selected_role - 1].text +
          ')',
      });
      form.reset();
    },
    onError: () => {
      push.error({
        title: 'Błąd',
        message: 'Nie wszystkie pola zostały poprawnie wypełnione',
      });
    },
    onFinish: () => form.reset('password', 'password_confirmation'),
  });
};

onMounted(() => {
  getAllClasses();
});
</script>

<template>
  <GuestLayout>
    <Head title="Rejestracja użytkownika" />
    <Notivue v-slot="item">
      <NotivueSwipe :item="item">
        <Notification :item="item">
          <NotificationProgress :item="item" />
        </Notification>
      </NotivueSwipe>
    </Notivue>
    <form @submit.prevent="submit">
      <div>
        <InputLabel for="selected_role" value="Wybierz role" />
        <select
          v-model="form.selected_role"
          id="selected_role"
          required
          class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full"
        >
          <option disabled value="">Wybierz</option>
          <option
            v-for="option in optionsRole"
            :value="option.value"
            :key="option"
          >
            {{ option.text }}
          </option>
        </select>
        <InputError class="mt-2" :message="form.errors.selected_role" />
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
          autofocus
          autocomplete="last_name"
        />

        <InputError class="mt-2" :message="form.errors.last_name" />
      </div>

      <div class="mt-4" v-if="form.selected_role == 1">
        <InputLabel for="phone" value="Numer telefonu" />

        <TextInput
          id="phone"
          type="text"
          class="mt-1 block w-full"
          v-model="form.phone"
          required
          autofocus
          autocomplete="phone"
        />

        <InputError class="mt-2" :message="form.errors.phone" />
      </div>

      <div class="mt-4" v-if="form.selected_role == 2">
        <InputLabel for="class_id" value="Wybierz klase" />
        <select
          v-model="form.class_id"
          id="class_id"
          required
          class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full"
        >
          <option disabled value="">Wybierz</option>
          <option
            v-for="studentClass in allClasses"
            :value="studentClass.id"
            :key="studentClass"
          >
            {{ studentClass.name }} - {{ studentClass.academic_year }}
          </option>
        </select>
        <InputError class="mt-2" :message="form.errors.class_id" />
      </div>

      <div class="mt-4">
        <InputLabel for="email" value="Adres e-mail" />

        <TextInput
          id="email"
          type="email"
          class="mt-1 block w-full"
          v-model="form.email"
          required
          autocomplete="username"
        />

        <InputError class="mt-2" :message="form.errors.email" />
      </div>

      <div class="mt-4">
        <InputLabel for="login" value="Login do systemu" />

        <TextInput
          id="login"
          type="text"
          class="mt-1 block w-full"
          v-model="form.login"
          required
          autofocus
          autocomplete="login"
        />

        <InputError class="mt-2" :message="form.errors.login" />
      </div>

      <div class="mt-4">
        <InputLabel for="password" value="Hasło" />

        <TextInput
          id="password"
          type="password"
          class="mt-1 block w-full"
          v-model="form.password"
          required
          autocomplete="new-password"
        />

        <InputError class="mt-2" :message="form.errors.password" />
      </div>

      <div class="mt-4">
        <InputLabel for="password_confirmation" value="Powtórz hasło" />

        <TextInput
          id="password_confirmation"
          type="password"
          class="mt-1 block w-full"
          v-model="form.password_confirmation"
          required
          autocomplete="new-password"
        />

        <InputError class="mt-2" :message="form.errors.password_confirmation" />
      </div>
      <div class="mt-4">
        <InputLabel for="comments" value="Dodaj swoje uwagi" />
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
          Zarejestruj
        </PrimaryButton>
      </div>
    </form>
  </GuestLayout>
</template>
