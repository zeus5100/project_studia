<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import NavLink from '@/Components/NavLink.vue';
</script>

<template>
  <Head title="Panel Nauczyciela" />

  <AuthenticatedLayout>
    <template #header>
      <h2
        class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
      >
        Panel Główny
      </h2>
    </template>

    <template #nav>
      <NavLink
        :href="route('teacher.dashboard')"
        :active="route().current('teacher.dashboard')"
      >
        Panel Główny
      </NavLink>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div
          class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg"
        >
          <div class="p-6 text-gray-900 dark:text-gray-100">
            Jesteś zalogowany jako nauczyciel!
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
