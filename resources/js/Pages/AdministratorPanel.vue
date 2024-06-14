<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
  <Head title="Strona Główna" />
  <AuthenticatedLayout>
    <template #header>
      <h2
        class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
      >
        Panel Główny
      </h2>
    </template>
    <template #main>
      <Link :href="route('admin.dashboard')">
        <ApplicationLogo
          class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200"
        />
      </Link>
    </template>
    <template #nav>
      <NavLink
        :href="route('admin.dashboard')"
        :active="route().current('admin.dashboard')"
      >
        Panel Główny
      </NavLink>
      <NavLink :href="route('register')" :active="route().current('register')">
        Rejestracja użytkownika
      </NavLink>

      <NavLink :href="route('event')" :active="route().current('event')">
        Rejestracja wydarzenia
      </NavLink>

      <NavLink :href="route('activity')" :active="route().current('activity')">
        Tworzenie zajęć
      </NavLink>
      <NavLink :href="route('register')" :active="route().current('register')">
        Zarządzaj
      </NavLink>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div
          class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg"
        >
          <div class="p-6 text-gray-900 dark:text-gray-100">
            Jesteś zalogowany jako administrator!
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
