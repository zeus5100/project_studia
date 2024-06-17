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
  <NavLink :href="route('register')" :active="route().current('register')">
    Rejestracja użytkownika
  </NavLink>

  <NavLink :href="route('event')" :active="route().current('event')">
    Rejestracja wydarzenia
  </NavLink>

  <NavLink :href="route('activity')" :active="route().current('activity')">
    Tworzenie zajęć
  </NavLink>
  <NavLink
    :href="route('admin.manage', { table: 'teachers' })"
    :active="route().current('admin.manage', { table: 'teachers' })"
  >
    Zarządzaj
  </NavLink>
</template>
