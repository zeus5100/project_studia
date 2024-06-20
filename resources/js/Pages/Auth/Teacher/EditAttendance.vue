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
import { reactive, ref } from 'vue';

const props = defineProps({
  lesson: {
    type: Object,
    required: true,
  },
  students: {
    type: Object,
    required: true,
  },
  existingAttendance: {
    type: Object,
    required: true,
  },
  attendanceStatuses: {
    type: Array,
    required: true,
  },
});

const form = useForm({
  lesson_id: props.lesson.id,
  attendance: {},
});

Object.keys(props.existingAttendance).forEach((studentId) => {
  form.attendance[parseInt(studentId) + 1] =
    props.existingAttendance[studentId].attendance_status_id;
});

const submitAttendance = () => {
  form.put(route('attendence.update', { lesson: props.lesson.id }));
};
</script>

<template>
  <Head title="Plan zajęć" />
  <AuthenticatedLayout>
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
              <div v-for="(student, index) in students" :key="index" class="">
                <label
                  class="text-gray-700 flex justify-between w-full border-b-2 p-2 items-center"
                >
                  {{ index + 1 }}. {{ student.first_name }}
                  {{ student.last_name }}
                  <select v-model="form.attendance[student.id]" class="w-1/2">
                    <option
                      v-for="status in attendanceStatuses"
                      :key="status.id"
                      :value="status.id"
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
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
