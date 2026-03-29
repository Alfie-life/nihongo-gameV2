<template>
  <v-container class="fill-height" fluid>
    <v-row justify="center" align="center">
      <v-col cols="12" sm="8" md="5" lg="4">
        <div class="text-center mb-8">
          <div class="text-h2 mb-2">🗾</div>
          <h1 class="game-title text-h4 text-primary">日本語ロード</h1>
          <p class="text-body-2 text-grey mt-1">Japanese Grammar Road</p>
        </div>

        <v-card class="pa-6" elevation="4">
          <v-card-title class="text-h6 text-center pb-4">
            ログイン / Login
          </v-card-title>

          <v-form @submit.prevent="handleLogin" :disabled="loading">
            <v-text-field
              v-model="email"
              label="メール / Email"
              type="email"
              prepend-inner-icon="mdi-email"
              variant="outlined"
              class="mb-2"
              :error-messages="errors.email"
            />
            <v-text-field
              v-model="password"
              label="パスワード / Password"
              type="password"
              prepend-inner-icon="mdi-lock"
              variant="outlined"
              class="mb-4"
              :error-messages="errors.password"
            />
            <v-btn
              type="submit"
              color="primary"
              size="large"
              block
              :loading="loading"
            >
              ログイン / Login
            </v-btn>
          </v-form>

          <v-divider class="my-4" />

          <div class="text-center">
            <span class="text-body-2">アカウントがない？ / No account?</span>
            <v-btn variant="text" color="primary" @click="$router.push('/register')" size="small">
              登録 / Register
            </v-btn>
          </div>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script setup>
import { ref, reactive } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '../store/auth'

const router = useRouter()
const authStore = useAuthStore()

const email = ref('')
const password = ref('')
const loading = ref(false)
const errors = reactive({ email: [], password: [] })

async function handleLogin() {
  loading.value = true
  errors.email = []
  errors.password = []
  try {
    await authStore.login(email.value, password.value)
    router.push('/')
  } catch (e) {
    if (e.response?.data?.errors) {
      Object.assign(errors, e.response.data.errors)
    } else if (e.response?.data?.message) {
      errors.email = [e.response.data.message]
    } else {
      errors.email = ['ログインに失敗しました / Login failed']
    }
  } finally {
    loading.value = false
  }
}
</script>

<style scoped>
.game-title {
  font-family: 'Dela Gothic One', cursive;
}
</style>
