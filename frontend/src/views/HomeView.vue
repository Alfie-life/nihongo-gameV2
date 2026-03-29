<template>
  <v-container class="py-8">
    <div class="text-center mb-10">
      <h1 class="game-title text-h3 text-primary mb-2">日本語ロード</h1>
      <p class="text-body-1 text-grey-darken-1">
        Choose a mode and start walking! / モードをえらんで歩き出そう！
      </p>
      <p class="text-body-2 text-grey mt-1">
        Welcome, {{ authStore.user?.name }} 👋
      </p>
    </div>

    <v-row justify="center" class="mb-8">
      <!-- Mode 1: ある / いる -->
      <v-col cols="12" sm="6" md="5">
        <v-card
          class="mode-card pa-6 text-center cursor-pointer"
          :class="{ 'mode-card-hover': true }"
          @click="selectMode('aru_iru')"
          elevation="3"
          hover
        >
          <div class="mode-emoji mb-4">🏠 👤</div>
          <h2 class="text-h5 font-weight-bold mb-3">ある / いる</h2>
          <p class="text-body-2 text-grey-darken-1 mb-4">
            「ある」と「いる」のちがいを学ぼう！<br>
            Learn the difference between "aru" and "iru"!
          </p>
          <v-chip color="primary" variant="tonal" size="small">
            <v-icon start size="small">mdi-information</v-icon>
            ある = things / いる = living beings
          </v-chip>
          <div class="mt-4">
            <v-btn color="primary" size="large" block>
              <v-icon start>mdi-play</v-icon>
              あそぶ / Play
            </v-btn>
          </div>
        </v-card>
      </v-col>

      <!-- Mode 2: だし / し -->
      <v-col cols="12" sm="6" md="5">
        <v-card
          class="mode-card pa-6 text-center cursor-pointer"
          @click="selectMode('dashi_shi')"
          elevation="3"
          hover
        >
          <div class="mode-emoji mb-4">📝 ✨</div>
          <h2 class="text-h5 font-weight-bold mb-3">だし / し</h2>
          <p class="text-body-2 text-grey-darken-1 mb-4">
            「だし」と「し」のちがいを学ぼう！<br>
            Learn the difference between "dashi" and "shi"!
          </p>
          <v-chip color="primary" variant="tonal" size="small">
            <v-icon start size="small">mdi-information</v-icon>
            だし = na-adj/noun / し = i-adj
          </v-chip>
          <div class="mt-4">
            <v-btn color="primary" size="large" block>
              <v-icon start>mdi-play</v-icon>
              あそぶ / Play
            </v-btn>
          </div>
        </v-card>
      </v-col>
    </v-row>

    <!-- Quick stats -->
    <v-row justify="center">
      <v-col cols="12" md="10">
        <v-card class="pa-4" variant="tonal" color="primary">
          <v-row align="center" justify="center" no-gutters>
            <v-col cols="auto" class="text-center px-6">
              <div class="text-h5 font-weight-bold">{{ collectionCount }}</div>
              <div class="text-caption">ゲットした食べ物 / Food Collected</div>
            </v-col>
            <v-divider vertical class="mx-2" />
            <v-col cols="auto" class="text-center px-6">
              <div class="text-h5 font-weight-bold">{{ totalItems }}</div>
              <div class="text-caption">全部 / Total Items</div>
            </v-col>
            <v-divider vertical class="mx-2" />
            <v-col cols="auto" class="text-center px-6">
              <v-btn variant="text" color="primary" @click="$router.push('/collection')">
                <v-icon start>mdi-book-open-variant</v-icon>
                図鑑を見る / View Collection
              </v-btn>
            </v-col>
          </v-row>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '../store/auth'
import { useGameStore } from '../store/game'

const router = useRouter()
const authStore = useAuthStore()
const gameStore = useGameStore()

const collectionCount = ref(0)
const totalItems = ref(0)

function selectMode(mode) {
  router.push(`/mode/${mode}/levels`)
}

onMounted(async () => {
  try {
    const data = await gameStore.fetchCollection()
    collectionCount.value = data.collected_count
    totalItems.value = data.total_items
  } catch (e) {}
})
</script>

<style scoped>
.game-title {
  font-family: 'Dela Gothic One', cursive;
}
.mode-emoji {
  font-size: 3rem;
}
.mode-card {
  transition: transform 0.2s ease, box-shadow 0.2s ease;
  border: 2px solid transparent;
}
.mode-card:hover {
  transform: translateY(-4px);
  border-color: #E8594F;
}
.cursor-pointer {
  cursor: pointer;
}
</style>
