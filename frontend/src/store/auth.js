import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import api from '../api'

export const useAuthStore = defineStore('auth', () => {
  const user = ref(null)
  const token = ref(null)

  const isLoggedIn = computed(() => !!token.value)

  function init() {
    const savedToken = localStorage.getItem('token')
    const savedUser = localStorage.getItem('user')
    if (savedToken) {
      token.value = savedToken
      api.defaults.headers.common['Authorization'] = `Bearer ${savedToken}`
    }
    if (savedUser) {
      try { user.value = JSON.parse(savedUser) } catch(e) {}
    }
  }

  async function login(email, password) {
    const res = await api.post('/api/login', { email, password })
    setAuth(res.data)
    return res.data
  }

  async function register(name, email, password, password_confirmation) {
    const res = await api.post('/api/register', { name, email, password, password_confirmation })
    setAuth(res.data)
    return res.data
  }

  async function logout() {
    try { await api.post('/api/logout') } catch(e) {}
    clearAuth()
  }

  function setAuth(data) {
    user.value = data.user
    token.value = data.token
    localStorage.setItem('token', data.token)
    localStorage.setItem('user', JSON.stringify(data.user))
    api.defaults.headers.common['Authorization'] = `Bearer ${data.token}`
  }

  function clearAuth() {
    user.value = null
    token.value = null
    localStorage.removeItem('token')
    localStorage.removeItem('user')
    delete api.defaults.headers.common['Authorization']
  }

  return { user, token, isLoggedIn, init, login, register, logout }
})
