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

  <NavLink
    :href="route('teacher.activities')"
    :active="route().current('teacher.activities')"
  >
    Plan zajęć
  </NavLink>
  <NavLink :href="route('students')" :active="route().current('students')">
    Moja klasa
  </NavLink>
</template>
