<script setup>
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
</script>

<template>
  <ResponsiveNavLink
    :href="route('teacher.dashboard')"
    :active="route().current('teacher.dashboard')"
  >
    Panel Główny
  </ResponsiveNavLink>
  <ResponsiveNavLink
    :href="route('teacher.activities')"
    :active="route().current('teacher.activities')"
  >
    Moje zajęcia
  </ResponsiveNavLink>
  <ResponsiveNavLink
    :href="route('students')"
    :active="route().current('students')"
  >
    Moja klasa
  </ResponsiveNavLink>
</template>
