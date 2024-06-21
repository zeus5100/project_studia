<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { TailwindPagination } from 'laravel-vue-pagination';
import DashboardNav from '@/Components/Teacher/DashboardNav.vue';
import ResponsiveDashboardNav from '@/Components/Teacher/ResponsiveDashboardNav.vue';
import Modal from '@/Components/Modal.vue';
import {
  Notivue,
  Notification,
  NotivueSwipe,
  NotificationProgress,
  push,
} from 'notivue';
import { ref } from 'vue';

const props = defineProps({
  activity: {
    type: Object,
    required: true,
  },
  lesson: {
    type: Object,
    required: true,
  },
  students: {
    type: Object,
    required: true,
  },
  attendenceStatuses: {
    type: Array,
    required: true,
  },
});

const form = useForm({
  lesson_id: props.lesson.id,
  attendance: {},
});

const submitAttendance = () => {
  if (Object.keys(form.attendance).length != props.students.length) {
    push.error({
      title: 'Błąd',
      message: 'Nie wszystkie pola zostały poprawnie wypełnione',
    });
    return;
  }
  form.post(route('attendence.store'), {
    onSuccess: () => {
      window.location.href = route('lessons', {
        id: props.activity.id,
      });
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
  <Head title="Plan zajęć" />
  <AuthenticatedLayout>
    <Notivue v-slot="item">
      <NotivueSwipe :item="item">
        <Notification :item="item">
          <NotificationProgress :item="item" />
        </Notification>
      </NotivueSwipe>
    </Notivue>
    <template #header>
      <div class="flex justify-between">
        <!-- <p class="text-lg font-semibold">
          {{ studentClass.name }} - {{ studentClass.academic_year }}
        </p> -->
      </div>
    </template>
    <template #main>
      <Link :href="route('home')">
        <ApplicationLogo
          class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200"
        />
      </Link>
    </template>
    <template #nav>
      <DashboardNav />
    </template>

    <template #responsiveNav>
      <ResponsiveDashboardNav />
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div
          class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg"
        >
          <div class="p-6 text-gray-900 dark:text-gray-100 overflow-auto">
            <form @submit.prevent="submitAttendance">
              <div v-for="(student, key) in students" :key="key" class="">
                <label
                  class="text-gray-700 flex justify-between w-full border-b-2 p-2 items-center"
                >
                  {{ key + 1 }}. {{ student.first_name }}
                  {{ student.last_name }}
                  <select
                    v-model="form.attendance[student.id]"
                    :id="student.id"
                    class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-1/2"
                  >
                    <option disabled value="">Wybierz</option>
                    <option
                      v-for="status in attendenceStatuses"
                      :key="status"
                      :value="status.id"
                      required
                    >
                      {{ status.name }}
                    </option>
                  </select>
                </label>
              </div>
              <button
                type="submit"
                class="bg-blue-500 text-white py-2 px-4 mt-2 float-right rounded"
              >
                Zapisz frekwencję
              </button>
            </form>
            <Link
              :href="route('lessons', { activity: activity.id })"
              class="inline-flex items-center px-2 mx-1 mt-4 py-2 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 bg-orange-300"
              >Powrót do lekcji</Link
            >
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
