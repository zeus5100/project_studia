<script setup>
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
</script>

<template>
  <ResponsiveNavLink
    :href="route('student.dashboard')"
    :active="route().current('student.dashboard')"
  >
    Panel Główny
  </ResponsiveNavLink>
  <ResponsiveNavLink
    :href="route('activities')"
    :active="route().current('activities')"
  >
    Panel Główny
  </ResponsiveNavLink>
  <ResponsiveNavLink
    :href="route('grades')"
    :active="route().current('grades')"
  >
    Panel Główny
  </ResponsiveNavLink>
</template>
