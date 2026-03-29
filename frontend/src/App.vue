<template>
  <v-app>
    <!-- Top navigation bar -->
    <v-app-bar v-if="authStore.isLoggedIn" color="primary" density="comfortable" flat>
      <v-app-bar-title class="font-weight-bold">
        🗾 日本語ロード
      </v-app-bar-title>
      <template v-slot:append>
        <v-btn icon="mdi-book-open-variant" @click="$router.push('/collection')" />
        <v-btn icon="mdi-logout" @click="handleLogout" />
      </template>
    </v-app-bar>

    <v-main>
      <router-view />
    </v-main>

    <!-- Snackbar for notifications -->
    <v-snackbar v-model="snackbar.show" :color="snackbar.color" :timeout="2000" location="top">
      {{ snackbar.text }}
    </v-snackbar>
  </v-app>
</template>

<script setup>
import { reactive } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from './store/auth'

const router = useRouter()
const authStore = useAuthStore()
const snackbar = reactive({ show: false, text: '', color: 'success' })

authStore.init()

async function handleLogout() {
  await authStore.logout()
  router.push('/login')
}
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700;900&family=Dela+Gothic+One&display=swap');

html, body {
  font-family: 'Noto Sans JP', sans-serif;
  background-color: #FFF8F0;
}

.v-app-bar-title {
  font-family: 'Dela Gothic One', cursive;
  letter-spacing: 0.05em;
}
</style>
