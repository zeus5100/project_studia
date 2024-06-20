<script setup>
import NavLink from '@/Components/NavLink.vue';
</script>

<template>
  <NavLink
    :href="route('teacher.dashboard')"
    :active="route().current('teacher.dashboard')"
  >
    Panel Główny
  </NavLink>

  <NavLink :href="route('activities')" :active="route().current('activities')">
    Plan zajęć
  </NavLink>
</template>
