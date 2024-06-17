<script setup>
import NavLink from '@/Components/NavLink.vue';
</script>

<template>
  <NavLink
    :href="route('admin.dashboard')"
    :active="route().current('admin.dashboard')"
  >
    Panel Główny
  </NavLink>
  <NavLink
    :href="route('register')"
    :active="route().current('register.create')"
  >
    Rejestracja użytkownika
  </NavLink>

  <NavLink
    :href="route('events.create')"
    :active="route().current('events.create')"
  >
    Rejestracja wydarzenia
  </NavLink>

  <NavLink
    :href="route('activities.create')"
    :active="route().current('activities')"
  >
    Tworzenie zajęć
  </NavLink>
  <NavLink
    :href="route('admin.manage', { table: 'teachers' })"
    :active="route().current('admin.manage', { table: 'teachers' })"
  >
    Zarządzaj
  </NavLink>
</template>
