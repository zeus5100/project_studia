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
import { ref } from 'vue';
import { lessonTimers, daysOfWeek } from '@/data.js';

const props = defineProps({
  teacher: {
    type: Object,
    required: false,
  },
});

const hasLesson = (dayId, timeSlot) => {
  return props.teacher.activities.some(
    (lesson) =>
      lesson.day_of_week == dayId && lesson.start_time === timeSlot.start
  );
};

const getLesson = (dayId, timeSlot) => {
  const lesson = props.teacher.activities.find(
    (lesson) =>
      lesson.day_of_week == dayId && lesson.start_time === timeSlot.start
  );
  return lesson || null;
};
</script>

<template>
  <Head title="Plan zajęć" />
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
            <table
              class="min-w-full bg-white border-gray-200 shadow-sm rounded-lg"
            >
              <thead>
                <tr class="bg-gray-100 border-b border-gray-300">
                  <th class="px-4 py-2 text-left">Godzina</th>
                  <th
                    v-for="(day, index) in daysOfWeek"
                    :key="index"
                    class="px-4 py-2 text-left"
                  >
                    {{ day.name }}
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="timeSlot in lessonTimers" :key="timeSlot">
                  <td class="border px-4 py-2">
                    {{ timeSlot.start }} - {{ timeSlot.end }}
                  </td>
                  <td
                    v-for="(day, index) in daysOfWeek"
                    :key="index"
                    class="border text-center"
                  >
                    <div
                      v-if="hasLesson(day.id, timeSlot)"
                      class="px-4 py-2 hover:bg-gray-200 cursor-pointer"
                    >
                      <template v-if="getLesson(day.id, timeSlot)">
                        <Link
                          class="text-blue-500 block"
                          :href="
                            route('lessons', {
                              id: getLesson(day.id, timeSlot).id,
                            })
                          "
                        >
                          {{ getLesson(day.id, timeSlot).subject.name }}
                          <span class="text-black"
                            >[{{
                              getLesson(day.id, timeSlot).room.room_number
                            }}]</span
                          >
                          <br />{{
                            getLesson(day.id, timeSlot).student_class.name
                          }}
                        </Link>
                      </template>
                    </div>
                    <div v-else class="px-4 py-2 text-gray-400">Brak zajęć</div>
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
