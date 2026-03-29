<template>
  <v-container class="fill-height" fluid>
    <v-row justify="center" align="center">
      <v-col cols="12" sm="8" md="5" lg="4">
        <div class="text-center mb-8">
          <div class="text-h2 mb-2">🗾</div>
          <h1 class="game-title text-h4 text-primary">日本語ロード</h1>
          <p class="text-body-2 text-grey mt-1">Create your account</p>
        </div>

        <v-card class="pa-6" elevation="4">
          <v-card-title class="text-h6 text-center pb-4">
            登録 / Register
          </v-card-title>

          <v-form @submit.prevent="handleRegister" :disabled="loading">
            <v-text-field
              v-model="name"
              label="名前 / Name"
              prepend-inner-icon="mdi-account"
              variant="outlined"
              class="mb-2"
              :error-messages="errors.name"
            />
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
              label="パスワード / Password (6+)"
              type="password"
              prepend-inner-icon="mdi-lock"
              variant="outlined"
              class="mb-2"
              :error-messages="errors.password"
            />
            <v-text-field
              v-model="password_confirmation"
              label="パスワード確認 / Confirm Password"
              type="password"
              prepend-inner-icon="mdi-lock-check"
              variant="outlined"
              class="mb-4"
            />
            <v-btn
              type="submit"
              color="primary"
              size="large"
              block
              :loading="loading"
            >
              登録する / Register
            </v-btn>
          </v-form>

          <v-divider class="my-4" />

          <div class="text-center">
            <span class="text-body-2">すでにアカウントがある？ / Have account?</span>
            <v-btn variant="text" color="primary" @click="$router.push('/login')" size="small">
              ログイン / Login
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

const name = ref('')
const email = ref('')
const password = ref('')
const password_confirmation = ref('')
const loading = ref(false)
const errors = reactive({ name: [], email: [], password: [] })

async function handleRegister() {
  loading.value = true
  errors.name = []
  errors.email = []
  errors.password = []
  try {
    await authStore.register(name.value, email.value, password.value, password_confirmation.value)
    router.push('/')
  } catch (e) {
    if (e.response?.data?.errors) {
      Object.assign(errors, e.response.data.errors)
    } else {
      errors.email = ['登録に失敗しました / Registration failed']
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
