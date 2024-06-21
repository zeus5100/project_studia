<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { onMounted, ref } from 'vue';
import { TailwindPagination } from 'laravel-vue-pagination';
import DashboardNav from '@/Components/DashboardNav.vue';
import Modal from '@/Components/Modal.vue';
import ResponsiveDashboardNav from '@/Components/ResponsiveDashboardNav.vue';
import {
  Notivue,
  Notification,
  NotivueSwipe,
  NotificationProgress,
  push,
} from 'notivue';

const props = defineProps({
  table: {
    type: String,
    required: false,
  },
  notification: {
    type: String,
    required: false,
  },
});

const form = useForm({
  table: props.table || 'teachers',
});

const tableList = ref([
  { name: 'teachers', text: 'Nauczyciele' },
  { name: 'subjects', text: 'Przedmioty' },
  { name: 'classes', text: 'Klasy' },
  { name: 'directions', text: 'Kierunki' },
  { name: 'students', text: 'Uczniowie' },
  { name: 'attendanceStatuses', text: 'Stany frekwencji' },
  { name: 'rooms', text: 'Sale' },
  { name: 'activities', text: 'Zajęcia' },
  { name: 'events', text: 'Wydarzenia' },
]);

const tableData = ref({});
const tableHeaders = ref({});

const submit = () => {
  window.location.href = route(`admin.manage`, { table: form.table });
};

const formatHeader = (header) => {
  return header.replace(/_/g, ' ').toUpperCase();
};

const tablePage = ref(1);

const loadAnotherPage = (page = 1) => {
  tablePage.value = page;
  axios
    .get(route(`${form.table}.index`), {
      params: {
        page: page,
      },
    })
    .then(({ data }) => {
      tableData.value = data;
      if (tableData.value.data.length > 0) {
        tableHeaders.value = Object.keys(tableData.value.data[0]);
      }
    });
};

const modalVisible = ref(false);
const modalMessage = ref('');

const deleteTableRow = (id) => {
  axios
    .delete(route(`${form.table}.destroy`, { id: id }))
    .then(async ({ data }) => {
      await loadAnotherPage(tablePage.value);
      modalMessage.value = data.message;
      modalVisible.value = true;
    })
    .catch((response) => {
      console.log('Wystąpił error: ' + response);
    });
};
onMounted(() => {
  loadAnotherPage(1);
  if (props.notification) {
    push.success({
      title: 'Sukces',
      message: 'Pomyślnie zaktualizowano ' + props.notification,
    });
  }
});
</script>

<template>
  <Head title="Zarządzanie" />
  <AuthenticatedLayout>
    <Notivue v-slot="item">
      <NotivueSwipe :item="item">
        <Notification :item="item">
          <NotificationProgress :item="item" />
        </Notification>
      </NotivueSwipe>
    </Notivue>
    <Modal :show="modalVisible" maxWidth="2xl" @close="modalVisible = false">
      <template #default>
        <div class="p-6 w-full">
          <p>{{ modalMessage }}</p>
        </div>
        <PrimaryButton @click="modalVisible = false">Okej</PrimaryButton>
      </template>
    </Modal>
    <template #header>
      <form @submit.prevent="submit">
        <div class="flex items-center justify-start space-x-2">
          <InputLabel for="table" value="Wybierz tabele" />
          <select
            v-model="form.table"
            id="table"
            required
            class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-3/5"
          >
            <option disabled value="">Wybierz</option>
            <option v-for="table in tableList" :value="table.name" :key="table">
              {{ table.text }}
            </option>
          </select>
          <InputError class="mt-2" :message="form.errors.table" />
          <PrimaryButton
            class="ms-4"
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
          >
            Wczytaj
          </PrimaryButton>
        </div>
      </form>
    </template>
    <template #main>
      <Link :href="route('home')" aria-label="home">
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
            <p class="text-center" v-if="form.table == ''">
              Aktualnie nie wczytano danych z żadnej tabeli
            </p>
            <p
              class="text-center"
              v-if="tableData.data && tableData.data.length == 0"
            >
              Wybrana tabela nie zawiera żadnych rekordów
            </p>
            <table class="min-w-full divide-y divide-gray-200 dark:bg-gray-900">
              <thead>
                <tr>
                  <th
                    v-for="header in tableHeaders"
                    :key="header"
                    class="px-4 py-2"
                  >
                    {{ formatHeader(header) }}
                  </th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="(row, rowIndex) in tableData.data" :key="rowIndex">
                  <td
                    v-for="(cell, cellIndex) in row"
                    :key="cellIndex"
                    class="whitespace-nowrap p-2 text-center"
                  >
                    {{ cell }}
                  </td>
                  <td class="whitespace-nowrap text-sm font-medium">
                    <Link
                      :href="route(`${form.table}.edit`, { id: row.id })"
                      class="inline-flex items-center px-4 mx-2 py-2 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 bg-orange-300"
                    >
                      Edytuj
                    </Link>
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
