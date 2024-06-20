<script setup>
import NavLink from '@/Components/NavLink.vue';
</script>

<template>
  <NavLink
    :href="route('student.dashboard')"
    :active="route().current('student.dashboard')"
  >
    Panel Główny
  </NavLink>
  <NavLink :href="route('activities')" :active="route().current('activities')">
    Plan zajęć
  </NavLink>
  <NavLink :href="route('grades')" :active="route().current('grades')">
    Moje oceny
  </NavLink>
</template>
