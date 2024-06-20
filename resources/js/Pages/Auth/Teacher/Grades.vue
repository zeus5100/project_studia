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
    required: false,
  },
  activity: {
    type: Object,
    required: false,
  },
});
</script>

<template>
  <Head title="Plan zajęć" />
  <AuthenticatedLayout>
    <template #header>
      <div class="flex justify-between">
        <p class="text-lg font-semibold">
          {{ activity.name }}
        </p>
        <div class="flex justify-center space-x-4">
          <Link
            :href="route('grade.create', { activity: activity.id })"
            class="inline-flex items-center px-2 mx-1 py-2 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 bg-green-700"
            >Nowa ocena</Link
          >

          <Link
            :href="route('lessons', { activity: activity.id })"
            class="inline-flex items-center px-2 mx-1 py-2 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 bg-orange-300"
            >Powrót do lekcji</Link
          >
        </div>
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
            <div>
              <table class="table-auto w-full">
                <thead>
                  <tr>
                    <th class="border px-1 py-2">#</th>
                    <th class="border px-4 py-2">Imię i nazwisko</th>
                    <th class="border px-4 py-2">Oceny</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(studentData, index) in students" :key="index">
                    <td class="border px-1 text-center">
                      {{ parseInt(index) }}
                    </td>
                    <td class="border px-4 py-2">
                      {{ studentData.student.first_name }}
                      {{ studentData.student.last_name }}
                    </td>
                    <td class="border px-4 py-2">
                      <ul class="list-disc list-inside">
                        <li
                          v-for="(grade, gradeId) in studentData.grades"
                          :key="gradeId"
                        >
                          <span class="text-orange-600 bold"
                            >{{ grade.grade_value }}
                          </span>
                          -
                          {{ grade.description }}
                        </li>
                      </ul>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
