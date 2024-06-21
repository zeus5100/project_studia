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
import { ref } from 'vue';

const props = defineProps({
  students: {
    type: Object,
    required: true,
  },
  studentClass: {
    type: Object,
    required: true,
  },
});
</script>

<template>
  <Head title="Moja klasa" />
  <AuthenticatedLayout>
    <template #header>
      <div class="flex justify-between">
        <p class="text-lg font-semibold">
          {{ studentClass.name }} - {{ studentClass.academic_year }}
        </p>
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
            <!-- <p class="text-center" v-if="students.data.length == 0">
              Żadna lekcja nie została jeszcze wpisana
            </p> -->
            <table class="min-w-full divide-y divide-gray-200 dark:bg-gray-900">
              <thead>
                <tr>
                  <th class="px-4 py-2"></th>
                  <th class="px-4 py-2">Imię i nazwisko</th>
                  <th class="px-4 py-2">Komentarze</th>
                  <th class="px-4 py-2"></th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="(row, rowIndex) in students" :key="rowIndex">
                  <td class="whitespace-nowrap p-2 text-center">
                    {{ rowIndex + 1 }}
                  </td>
                  <td class="whitespace-nowrap p-2 text-center">
                    {{ row.first_name }} {{ row.last_name }}
                  </td>
                  <td class="whitespace-nowrap p-2 text-center">
                    {{ row.comments }}
                  </td>
                  <td class="flex justify-center my-1">
                    <Link
                      :href="route('student.grades', { student: row.id })"
                      class="inline-flex items-center px-4 mx-2 py-2 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 bg-green-700"
                      >Oceny</Link
                    >
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
