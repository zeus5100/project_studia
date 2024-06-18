<script setup>
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
</script>

<template>
  <ResponsiveNavLink
    :href="route('admin.dashboard')"
    :active="route().current('admin.dashboard')"
  >
    Panel Główny
  </ResponsiveNavLink>
  <ResponsiveNavLink
    :href="route('register')"
    :active="route().current('register')"
  >
    Rejestracja użytkownika
  </ResponsiveNavLink>

  <ResponsiveNavLink
    :href="route('events.create')"
    :active="route().current('events.create')"
  >
    Rejestracja wydarzenia
  </ResponsiveNavLink>

  <ResponsiveNavLink
    :href="route('activities.create')"
    :active="route().current('activities.create')"
  >
    Tworzenie zajęć
  </ResponsiveNavLink>
  <ResponsiveNavLink
    :href="route('admin.manage', { table: 'teachers' })"
    :active="route().current('admin.manage')"
  >
    Zarządzaj
  </ResponsiveNavLink>
</template>
