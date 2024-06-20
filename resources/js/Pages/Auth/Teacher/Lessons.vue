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
  activity: {
    type: Object,
    required: false,
  },
  lessons: {
    type: Object,
    required: false,
  },
});

const tableData = ref(props.lessons);
const tablePage = ref(1);

const loadAnotherPage = (page = 1) => {
  tablePage.value = page;
  axios
    .get(route('getLessons', { activity: props.activity.id }), {
      params: {
        page: page,
      },
    })
    .then(({ data }) => {
      tableData.value = data;
    });
};

const modalVisible = ref(false);
const modalMessage = ref('');
const deleteTableRow = (id) => {
  axios
    .delete(route(`lesson.destroy`, { lesson: id }))
    .then(async ({ data }) => {
      await loadAnotherPage(tablePage.value);
      modalMessage.value = data.message;
      modalVisible.value = true;
    })
    .catch((response) => {
      console.log('Wystąpił error: ' + response);
    });
};
</script>

<template>
  <Head title="Plan zajęć" />
  <AuthenticatedLayout>
    <Modal :show="modalVisible" maxWidth="2xl" @close="modalVisible = false">
      <template #default>
        <div class="p-6 w-full">
          <p>{{ modalMessage }}</p>
        </div>
        <PrimaryButton @click="modalVisible = false">Okej</PrimaryButton>
      </template>
    </Modal>
    <template #header>
      <div class="flex justify-between">
        <p class="text-lg font-semibold">
          {{ activity.subject.name }}, {{ activity.student_class.name }} w sali
          <span class="text-blue-600">{{ activity.room.room_number }}</span>
          - od {{ activity.start_time }} do {{ activity.end_time }}
        </p>
        <Link
          :href="route('lesson', { activity: activity.id })"
          class="inline-flex items-center px-4 mx-2 py-2 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 bg-orange-300"
          >Nowa lekcja</Link
        >
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
            <p class="text-center" v-if="tableData.data.length == 0">
              Żadna lekcja nie została jeszcze wpisana
            </p>
            <table
              v-else
              class="min-w-full divide-y divide-gray-200 dark:bg-gray-900"
            >
              <thead>
                <tr>
                  <th class="px-4 py-2">Numer lekcji</th>
                  <th class="px-4 py-2">Temat zajęć</th>
                  <th class="px-4 py-2">Data wpisu</th>
                  <th class="px-4 py-2">Komentarze</th>
                  <th class="px-4 py-2"></th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="(row, rowIndex) in tableData.data" :key="rowIndex">
                  <td class="whitespace-nowrap p-2 text-center">
                    {{ tableData.total - tableData.from - rowIndex + 1 }}
                  </td>
                  <td class="whitespace-nowrap p-2 text-center">
                    {{ row.lesson_topic }}
                  </td>
                  <td class="whitespace-nowrap p-2 text-center">
                    {{ row.lesson_datetime }}
                  </td>
                  <td class="whitespace-nowrap p-2 text-center">
                    {{ row.comments }}
                  </td>
                  <td class="flex justify-center my-1">
                    <Link
                      :href="route('attendence', { lesson: row.id })"
                      class="inline-flex items-center px-4 mx-2 py-2 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 bg-blue-400"
                      >Frekwencja</Link
                    >
                    <PrimaryButton
                      class="bg-red-400"
                      @click="deleteTableRow(row.id)"
                      >Usuń</PrimaryButton
                    >
                  </td>
                </tr>
              </tbody>
            </table>

            <TailwindPagination
              :limit="1"
              :keepLength="true"
              :data="tableData"
              class="border-1 mt-2"
              :active-classes="[]"
              @pagination-change-page="loadAnotherPage"
            />
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
