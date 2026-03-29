import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '../store/auth'

const routes = [
  {
    path: '/login',
    name: 'Login',
    component: () => import('../views/LoginView.vue'),
    meta: { guest: true },
  },
  {
    path: '/register',
    name: 'Register',
    component: () => import('../views/RegisterView.vue'),
    meta: { guest: true },
  },
  {
    path: '/',
    name: 'Home',
    component: () => import('../views/HomeView.vue'),
    meta: { auth: true },
  },
  {
    path: '/mode/:mode/levels',
    name: 'LevelSelect',
    component: () => import('../views/LevelSelectView.vue'),
    meta: { auth: true },
  },
  {
    path: '/mode/:mode/level/:level/play',
    name: 'GamePlay',
    component: () => import('../views/GamePlayView.vue'),
    meta: { auth: true },
  },
  {
    path: '/collection',
    name: 'Collection',
    component: () => import('../views/CollectionView.vue'),
    meta: { auth: true },
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

router.beforeEach((to, from, next) => {
  const authStore = useAuthStore()
  if (to.meta.auth && !authStore.isLoggedIn) {
    next('/login')
  } else if (to.meta.guest && authStore.isLoggedIn) {
    next('/')
  } else {
    next()
  }
})

export default router
