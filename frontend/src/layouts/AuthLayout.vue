<script setup>
import { onMounted } from 'vue';
import useAuth from '../composables/useAuth';

const { user, logout, isUserLoading } = useAuth();

</script>

<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow">
      <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8 flex justify-between items-center">
        <h1 class="text-2xl font-bold tracking-tight text-indigo-600 flex items-center">
          <span class="text-3xl mr-2">✅</span> 
          <router-link to="/dashboard" class="text-indigo-600 hover:text-indigo-500">Genius TodoList</router-link>
        </h1>
        <div class="flex items-center gap-4">
          <div v-if="!isUserLoading && user" class="text-sm text-gray-700">
            Hello, {{ user?.name }}
          </div>
          <button
            @click="logout"
            class="rounded-md bg-indigo-600 px-3.5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
          >
            Logout
          </button>
        </div>
      </div>
    </header>

    <!-- Main Content -->
    <main class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
      <router-view />
    </main>
  </div>
</template>
