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

  <ResponsiveNavLink :href="route('event')" :active="route().current('event')">
    Rejestracja wydarzenia
  </ResponsiveNavLink>

  <ResponsiveNavLink
    :href="route('activity')"
    :active="route().current('activity')"
  >
    Tworzenie zajęć
  </ResponsiveNavLink>
  <ResponsiveNavLink
    :href="route('admin.manage')"
    :active="route().current('admin.manage')"
  >
    Zarządzaj
  </ResponsiveNavLink>
</template>
