<template>
  <v-container class="py-8">
    <v-btn variant="text" @click="$router.push('/')" class="mb-4">
      <v-icon start>mdi-arrow-left</v-icon>
      もどる / Back
    </v-btn>

    <div class="text-center mb-8">
      <h1 class="text-h4 font-weight-bold mb-2">
        {{ modeName }}
      </h1>
      <p class="text-body-2 text-grey-darken-1">
        レベルをえらんでね / Choose a level
      </p>
      <v-chip-group class="justify-center mt-2">
        <v-chip size="small" variant="outlined">Lv1-2: N5</v-chip>
        <v-chip size="small" variant="outlined">Lv3-4: N4</v-chip>
        <v-chip size="small" variant="outlined">Lv5-6: N3</v-chip>
        <v-chip size="small" variant="outlined">Lv7-8: N2</v-chip>
        <v-chip size="small" variant="outlined">Lv9-10: N1</v-chip>
      </v-chip-group>
    </div>

    <v-row justify="center">
      <v-col cols="12" md="10" lg="8">
        <div class="level-road">
          <div
            v-for="lvl in levels"
            :key="lvl.level"
            class="level-node mb-4"
            :class="{
              'level-completed': lvl.is_completed,
              'level-current': !lvl.is_completed && lvl.is_unlocked,
              'level-locked': !lvl.is_unlocked,
            }"
          >
            <v-card
              :disabled="!lvl.is_unlocked"
              class="pa-4"
              :class="{
                'border-success': lvl.is_completed,
                'border-primary': !lvl.is_completed && lvl.is_unlocked,
              }"
              :elevation="lvl.is_unlocked ? 3 : 1"
              @click="lvl.is_unlocked && goToLevel(lvl.level)"
              :style="lvl.is_unlocked ? 'cursor: pointer' : ''"
            >
              <v-row align="center" no-gutters>
                <v-col cols="auto" class="mr-4">
                  <v-avatar
                    :color="lvl.is_completed ? 'success' : (lvl.is_unlocked ? 'primary' : 'grey-lighten-2')"
                    size="56"
                  >
                    <v-icon v-if="lvl.is_completed" color="white" size="large">mdi-check</v-icon>
                    <v-icon v-else-if="!lvl.is_unlocked" color="grey" size="large">mdi-lock</v-icon>
                    <span v-else class="text-h6 text-white font-weight-bold">{{ lvl.level }}</span>
                  </v-avatar>
                </v-col>

                <v-col>
                  <div class="text-h6 font-weight-bold">
                    レベル {{ lvl.level }}
                    <v-chip size="x-small" class="ml-2" variant="tonal" :color="jlptColor(lvl.level)">
                      {{ jlptLevel(lvl.level) }}
                    </v-chip>
                  </div>
                  <v-progress-linear
                    v-if="lvl.is_unlocked"
                    :model-value="lvl.total_questions > 0 ? (lvl.current_question / lvl.total_questions) * 100 : 0"
                    :color="lvl.is_completed ? 'success' : 'primary'"
                    height="8"
                    rounded
                    class="mt-2 mb-1"
                  />
                  <div class="text-caption text-grey">
                    <span v-if="lvl.is_completed">✅ クリア！ / Completed!</span>
                    <span v-else-if="lvl.is_unlocked">
                      {{ lvl.current_question }} / {{ lvl.total_questions }} もんだい / questions
                    </span>
                    <span v-else>🔒 前のレベルをクリアしてね / Clear previous level</span>
                  </div>
                </v-col>

                <v-col cols="auto" v-if="lvl.is_unlocked">
                  <v-btn
                    v-if="lvl.is_completed"
                    icon="mdi-refresh"
                    variant="tonal"
                    color="grey"
                    size="small"
                    @click.stop="handleReset(lvl.level)"
                  />
                  <v-icon v-else color="primary" size="large">mdi-chevron-right</v-icon>
                </v-col>
              </v-row>
            </v-card>
          </div>
        </div>
      </v-col>
    </v-row>

    <!-- Reset dialog -->
    <v-dialog v-model="resetDialog" max-width="400">
      <v-card class="pa-4">
        <v-card-title>リセットする？ / Reset Level?</v-card-title>
        <v-card-text>
          このレベルの進捗がリセットされます。<br>
          Your progress for this level will be reset.
        </v-card-text>
        <v-card-actions>
          <v-spacer />
          <v-btn variant="text" @click="resetDialog = false">やめる / Cancel</v-btn>
          <v-btn color="error" @click="confirmReset">リセット / Reset</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-container>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useGameStore } from '../store/game'

const route = useRoute()
const router = useRouter()
const gameStore = useGameStore()

const mode = computed(() => route.params.mode)
const levels = ref([])
const resetDialog = ref(false)
const resetLevelNum = ref(null)

const modeName = computed(() => {
  return mode.value === 'aru_iru' ? 'ある / いる モード' : 'だし / し モード'
})

function jlptLevel(lvl) {
  if (lvl <= 2) return 'N5'
  if (lvl <= 4) return 'N4'
  if (lvl <= 6) return 'N3'
  if (lvl <= 8) return 'N2'
  return 'N1'
}

function jlptColor(lvl) {
  if (lvl <= 2) return 'green'
  if (lvl <= 4) return 'teal'
  if (lvl <= 6) return 'blue'
  if (lvl <= 8) return 'purple'
  return 'red'
}

function goToLevel(level) {
  router.push(`/mode/${mode.value}/level/${level}/play`)
}

function handleReset(level) {
  resetLevelNum.value = level
  resetDialog.value = true
}

async function confirmReset() {
  try {
    await gameStore.resetLevel(mode.value, resetLevelNum.value)
    await loadLevels()
  } catch (e) {}
  resetDialog.value = false
}

async function loadLevels() {
  try {
    levels.value = await gameStore.fetchLevels(mode.value)
  } catch (e) {}
}

onMounted(loadLevels)
</script>

<style scoped>
.level-road {
  position: relative;
}
.level-road::before {
  content: '';
  position: absolute;
  left: 52px;
  top: 0;
  bottom: 0;
  width: 4px;
  background: linear-gradient(to bottom, #E8594F, #F5A623, #4CAF50);
  border-radius: 2px;
  z-index: 0;
}
.level-node {
  position: relative;
  z-index: 1;
}
.border-success {
  border-left: 4px solid #4CAF50 !important;
}
.border-primary {
  border-left: 4px solid #E8594F !important;
}
</style>
