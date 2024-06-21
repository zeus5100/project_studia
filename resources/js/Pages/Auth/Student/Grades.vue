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
import DashboardNav from '@/Components/Student/DashboardNav.vue';
import ResponsiveDashboardNav from '@/Components/Student/ResponsiveDashboardNav.vue';
import { ref } from 'vue';
import { lessonTimers, daysOfWeek } from '@/data.js';

const props = defineProps({
  grades: {
    type: Object,
    required: false,
  },
  subjects: {
    type: Object,
    required: false,
  },
});
</script>

<template>
  <Head title="Moje oceny" />
  <AuthenticatedLayout>
    <template #header> </template>
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
              <table
                class="min-w-full divide-y divide-gray-200 dark:divide-gray-700"
              >
                <thead class="bg-gray-50 dark:bg-gray-800">
                  <tr>
                    <th
                      scope="col"
                      class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider"
                    >
                      Przedmiot
                    </th>
                    <th
                      scope="col"
                      class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider"
                    >
                      Oceny
                    </th>
                  </tr>
                </thead>
                <tbody
                  class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700"
                >
                  <template v-for="subject in subjects" :key="subject">
                    <tr>
                      <td
                        class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100"
                      >
                        {{ subject.name }}
                      </td>
                      <td
                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400"
                      >
                        <template v-if="subject.name in grades">
                          <span
                            v-for="(grade, index) in grades[subject.name]"
                            :key="index"
                          >
                            <span class="text-orange-400">{{
                              grade.grade_value
                            }}</span>
                            -
                            {{ grade.description }}
                            <span v-if="index < grades[subject.name].length - 1"
                              >,
                            </span>
                          </span>
                          <span
                            v-if="grades[subject.name].length === 0"
                            class="text-gray-500 dark:text-gray-400"
                            >brak</span
                          >
                        </template>
                        <template v-else>
                          <span class="text-gray-500 dark:text-gray-400"
                            >brak</span
                          >
                        </template>
                      </td>
                    </tr>
                  </template>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
