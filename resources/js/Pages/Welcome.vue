<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
  canLogin: {
    type: Boolean,
  },
  canRegister: {
    type: Boolean,
  },
  laravelVersion: {
    type: String,
    required: true,
  },
  phpVersion: {
    type: String,
    required: true,
  },
});

function handleImageError() {
  document.getElementById('screenshot-container')?.classList.add('!hidden');
  document.getElementById('docs-card')?.classList.add('!row-span-1');
  document.getElementById('docs-card-content')?.classList.add('!flex-row');
  document.getElementById('background')?.classList.add('!hidden');
}
</script>

<template>
  <Head title="Witamy w naszej szkole" />
  <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
    <div
      class="min-h-screen bg-gray-100 flex flex-col justify-center items-center"
    >
      <header class="w-full bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
          <h1 class="text-3xl font-bold text-gray-900">
            Witamy w naszej szkole - Zespół Szkół Technicznych nr 2
          </h1>
        </div>
      </header>

      <main class="flex-grow flex flex-col justify-center items-center py-12">
        <div class="max-w-4xl mx-auto text-center">
          <h2 class="text-2xl md:text-4xl font-extrabold text-gray-900">
            Przygotowujemy Uczniów na Świetlaną Przyszłość
          </h2>
          <p class="mt-4 text-lg text-gray-600">
            Nasza szkoła średnia oferuje wszechstronny program nauczania,
            zaprojektowany tak, aby przygotować uczniów do wyzwań przyszłości.
            Dołącz do nas, aby wspierać doskonałość akademicką i rozwój
            osobisty.
          </p>
          <div class="mt-8">
            <a
              href="#"
              class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
            >
              <nav v-if="canLogin" class="-mx-3 flex flex-1 justify-end">
                <Link
                  :href="route('login')"
                  class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                >
                  Login
                </Link>
              </nav>
            </a>
          </div>
        </div>
      </main>

      <footer class="w-full bg-white shadow">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
          <p class="text-center text-gray-600 text-sm">
            &copy; 2024 Zespół Szkół Technicznych nr 2. Wszelkie prawa
            zastrzeżone.
          </p>
        </div>
      </footer>
    </div>
    <img
      id="background"
      class="absolute -left-80 top-0 max-w-[877px] h-full"
      src="https://laravel.com/assets/img/welcome/background.svg"
    />
  </div>
</template>
