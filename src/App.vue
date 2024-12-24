<script setup>
import { RouterLink, RouterView } from "vue-router";
import { useAuthStore } from "./stores/auth";
import '@fortawesome/fontawesome-free/css/all.css';

const authStore = useAuthStore();
</script>

<template>
  <header>
    <nav>
      <div class="flex justify-start gap-4">
  <RouterLink :to="{ name: 'home' }" class="nav-link">Home</RouterLink>
  <RouterLink :to="{ name: 'diet' }" class="nav-link">Diet</RouterLink>
</div>

      <div v-if="authStore.user" class="flex items-center space-x-6">
        <p class="text-sm text-slate-300">
          Welcome back {{ authStore.user.name }}
        </p>
        <RouterLink :to="{ name: 'create' }" class="nav-link">
          New Post
        </RouterLink>
        <form @submit.prevent="authStore.logout">
          <button class="nav-link">Logout</button>
        </form>
      </div>

      <div v-else class="space-x-6">
        <RouterLink :to="{ name: 'register' }" class="nav-link">
          Register
        </RouterLink>
        <RouterLink :to="{ name: 'login' }" class="nav-link">
          Login
        </RouterLink>

      </div>
    </nav>
  </header>

  <RouterView />
</template>