<template>
  <v-container class="py-8">
    <v-btn variant="text" @click="$router.push('/')" class="mb-4">
      <v-icon start>mdi-arrow-left</v-icon>
      もどる / Back
    </v-btn>

    <div class="text-center mb-6">
      <h1 class="text-h4 font-weight-bold mb-2">📖 食べ物図鑑</h1>
      <p class="text-body-1 text-grey-darken-1">Food Collection / たべもの ずかん</p>
      <v-chip color="primary" variant="tonal" class="mt-2" size="large">
        <v-icon start>mdi-star</v-icon>
        {{ collection.collected_count }} / {{ collection.total_items }} ゲット済み
      </v-chip>

      <v-progress-linear
        :model-value="collection.total_items > 0 ? (collection.collected_count / collection.total_items) * 100 : 0"
        color="primary"
        height="12"
        rounded
        class="mt-4 mx-auto"
        style="max-width: 400px"
      />
    </div>

    <!-- Filter tabs -->
    <v-tabs v-model="filterTab" centered color="primary" class="mb-6">
      <v-tab value="all">すべて / All</v-tab>
      <v-tab value="aru_iru">ある/いる</v-tab>
      <v-tab value="dashi_shi">だし/し</v-tab>
    </v-tabs>

    <!-- Category filter -->
    <div class="text-center mb-4">
      <v-chip-group v-model="selectedCategory" selected-class="text-primary" mandatory>
        <v-chip value="all" variant="outlined" filter>全部 / All</v-chip>
        <v-chip value="sweets" variant="outlined" filter>🍰 スイーツ</v-chip>
        <v-chip value="japanese" variant="outlined" filter>🍣 和食</v-chip>
        <v-chip value="drinks" variant="outlined" filter>🍵 飲み物</v-chip>
        <v-chip value="fruits" variant="outlined" filter>🍓 果物</v-chip>
      </v-chip-group>
    </div>

    <!-- Collection grid -->
    <v-row v-if="filteredItems.length > 0">
      <v-col
        v-for="item in filteredItems"
        :key="item.id"
        cols="6"
        sm="4"
        md="3"
        lg="2"
      >
        <v-card class="food-card pa-3 text-center" elevation="2" hover>
          <div class="food-emoji">{{ item.emoji }}</div>
          <div class="text-body-2 font-weight-bold mt-1">{{ item.name }}</div>
          <div class="text-caption text-grey">{{ item.name_en }}</div>
          <v-chip size="x-small" variant="tonal" class="mt-1"
            :color="item.mode === 'aru_iru' ? 'red' : 'blue'"
          >
            Lv{{ item.level }}
          </v-chip>
        </v-card>
      </v-col>
    </v-row>

    <v-card v-else class="pa-8 text-center" variant="tonal" color="grey-lighten-4">
      <div class="text-h2 mb-4">🔍</div>
      <p class="text-body-1">
        まだ食べ物がありません。ゲームをあそんでゲットしよう！<br>
        No food yet. Play the game to collect food!
      </p>
      <v-btn color="primary" class="mt-4" @click="$router.push('/')">
        あそぶ / Play
      </v-btn>
    </v-card>

    <!-- Completion message -->
    <v-card
      v-if="collection.collected_count > 0 && collection.collected_count === collection.total_items"
      class="pa-6 text-center mt-8 complete-card"
      elevation="4"
    >
      <div class="text-h1 mb-2">🏆</div>
      <h2 class="text-h5 font-weight-bold">コンプリート！/ Complete!</h2>
      <p class="text-body-1 mt-2">
        すべての食べ物をゲットしました！おめでとう！<br>
        You collected all the food! Congratulations!
      </p>
    </v-card>
  </v-container>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useGameStore } from '../store/game'

const gameStore = useGameStore()

const collection = ref({ collected: [], total_items: 0, collected_count: 0 })
const filterTab = ref('all')
const selectedCategory = ref('all')

const filteredItems = computed(() => {
  let items = collection.value.collected || []

  if (filterTab.value !== 'all') {
    items = items.filter(item => item.mode === filterTab.value)
  }

  if (selectedCategory.value !== 'all') {
    items = items.filter(item => item.category === selectedCategory.value)
  }

  return items
})

onMounted(async () => {
  try {
    collection.value = await gameStore.fetchCollection()
  } catch (e) {}
})
</script>

<style scoped>
.food-card {
  transition: transform 0.2s ease;
  border: 2px solid transparent;
}

.food-card:hover {
  transform: translateY(-4px);
  border-color: #F5A623;
}

.food-emoji {
  font-size: 2.5rem;
}

.complete-card {
  background: linear-gradient(135deg, #FFF8E1, #E8F5E9);
  border: 3px solid #F5A623;
}
</style>
