<template>
  <v-container class="py-4" fluid>
    <!-- Level completed overlay -->
    <v-dialog v-model="levelCompleted" persistent max-width="500">
      <v-card class="pa-6 text-center">
        <div class="text-h1 mb-4">🎉</div>
        <h2 class="text-h4 font-weight-bold mb-2">レベルクリア！</h2>
        <p class="text-h6 text-grey-darken-1">Level Complete!</p>
        <p class="text-body-1 mt-4">
          全部の食べ物をゲットしました！<br>You collected all the food!
        </p>
        <v-btn color="primary" size="large" class="mt-6" @click="goBack">
          もどる / Back to Levels
        </v-btn>
      </v-card>
    </v-dialog>

    <!-- Game Over overlay -->
    <v-dialog v-model="gameOver" persistent max-width="500">
      <v-card class="pa-6 text-center game-over-card">
        <div class="text-h1 mb-4">💀</div>
        <h2 class="text-h4 font-weight-bold text-error mb-2">ゲームオーバー</h2>
        <p class="text-body-1 mb-2">Game Over!</p>
        <v-card variant="tonal" color="info" class="pa-3 mb-4 text-left">
          <div class="text-body-2 font-weight-bold mb-1">正解 / Correct answer:</div>
          <div class="text-h6">{{ lastCorrectAnswer }}</div>
          <div class="text-body-2 mt-2">{{ lastExplanation }}</div>
        </v-card>
        <v-btn color="primary" size="large" class="mt-2" block @click="retryQuestion">
          <v-icon start>mdi-refresh</v-icon>
          もう一回 / Try Again
        </v-btn>
        <v-btn variant="text" class="mt-2" block @click="goBack">
          レベルにもどる / Back to Levels
        </v-btn>
      </v-card>
    </v-dialog>

    <!-- Food reward overlay -->
    <v-dialog v-model="showReward" max-width="400">
      <v-card class="pa-6 text-center reward-card">
        <div class="reward-emoji">{{ rewardItem?.emoji }}</div>
        <h3 class="text-h5 font-weight-bold mt-2">{{ rewardItem?.name }}</h3>
        <p class="text-body-2 text-grey">{{ rewardItem?.name_en }}</p>
        <v-chip
          v-if="rewardItem?.is_new"
          color="accent"
          class="mt-2"
          size="small"
        >
          ✨ NEW! 図鑑に追加！
        </v-chip>
        <v-card variant="tonal" color="success" class="pa-3 mt-4 text-left">
          <div class="text-body-2">{{ lastExplanation }}</div>
        </v-card>
        <v-btn color="success" class="mt-4" size="large" block @click="nextQuestion">
          つぎへ / Next
        </v-btn>
      </v-card>
    </v-dialog>

    <!-- Main game area -->
    <div v-if="question && !levelCompleted" class="game-area">
      <!-- Question display -->
      <v-card class="question-card mx-auto mb-6 pa-4 text-center" max-width="600" elevation="4">
        <div class="text-overline text-grey mb-1">
          Q{{ questionNumber }} / {{ totalQuestions }}
          <v-chip size="x-small" class="ml-2" variant="tonal">{{ jlptLabel }}</v-chip>
        </div>
        <div class="text-h5 font-weight-bold question-text" v-html="question.sentence"></div>
      </v-card>

      <!-- Road scene -->
      <div class="road-scene mx-auto" :class="{ 'scene-choosing': !isWalking, 'scene-walking': isWalking }">
        <!-- Sky / background -->
        <div class="road-bg">
          <!-- Character -->
          <div
            class="character"
            :class="{
              'walking': isWalking,
              'walk-left': walkDirection === 'left',
              'walk-right': walkDirection === 'right',
              'crash': showCrash,
            }"
          >
            <div class="character-body">🚶</div>
          </div>

          <!-- Fork in the road -->
          <svg class="road-svg" viewBox="0 0 400 300" xmlns="http://www.w3.org/2000/svg">
            <!-- Main road -->
            <path d="M 200 300 L 200 180" stroke="#8B7355" stroke-width="40" fill="none" stroke-linecap="round"/>
            <!-- Left path -->
            <path d="M 200 180 Q 160 140 80 80" stroke="#8B7355" stroke-width="36" fill="none" stroke-linecap="round"/>
            <!-- Right path -->
            <path d="M 200 180 Q 240 140 320 80" stroke="#8B7355" stroke-width="36" fill="none" stroke-linecap="round"/>
            <!-- Road lines -->
            <path d="M 200 300 L 200 190" stroke="#FFF8DC" stroke-width="3" fill="none" stroke-dasharray="12,8"/>
            <!-- Trees/decoration -->
            <text x="40" y="140" font-size="28">🌳</text>
            <text x="340" y="140" font-size="28">🌳</text>
            <text x="10" y="60" font-size="22">🌸</text>
            <text x="370" y="60" font-size="22">🌸</text>
          </svg>

          <!-- Left choice button -->
          <div class="choice-left" @click="!isWalking && choose('left')">
            <v-btn
              :color="isWalking ? 'grey' : 'amber-darken-2'"
              size="large"
              :disabled="isWalking"
              class="choice-btn elevation-4"
              rounded="pill"
            >
              ⬅ {{ question.left_choice }}
            </v-btn>
          </div>

          <!-- Right choice button -->
          <div class="choice-right" @click="!isWalking && choose('right')">
            <v-btn
              :color="isWalking ? 'grey' : 'blue-darken-2'"
              size="large"
              :disabled="isWalking"
              class="choice-btn elevation-4"
              rounded="pill"
            >
              {{ question.right_choice }} ➡
            </v-btn>
          </div>

          <!-- Car (appears on wrong answer) -->
          <div v-if="showCrash" class="car-crash">
            <div class="car">🚗💨</div>
          </div>
        </div>
      </div>

      <!-- Instruction hint -->
      <p class="text-center text-body-2 text-grey mt-4" v-if="!isWalking">
        ← 左か右をえらんでね / Choose left or right →
      </p>
    </div>

    <!-- Loading state -->
    <div v-else-if="loading" class="text-center py-16">
      <v-progress-circular indeterminate color="primary" size="64" />
      <p class="text-body-1 mt-4">読み込み中... / Loading...</p>
    </div>

    <!-- Back button -->
    <div class="text-center mt-4" v-if="!levelCompleted">
      <v-btn variant="text" size="small" @click="goBack">
        <v-icon start>mdi-arrow-left</v-icon>
        レベルにもどる / Back
      </v-btn>
    </div>
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
const level = computed(() => parseInt(route.params.level))

const question = ref(null)
const questionNumber = ref(0)
const totalQuestions = ref(0)
const loading = ref(true)
const isWalking = ref(false)
const walkDirection = ref(null)
const showCrash = ref(false)
const gameOver = ref(false)
const levelCompleted = ref(false)
const showReward = ref(false)
const rewardItem = ref(null)
const lastCorrectAnswer = ref('')
const lastExplanation = ref('')

const jlptLabel = computed(() => {
  const l = level.value
  if (l <= 2) return 'JLPT N5'
  if (l <= 4) return 'JLPT N4'
  if (l <= 6) return 'JLPT N3'
  if (l <= 8) return 'JLPT N2'
  return 'JLPT N1'
})

async function loadQuestion() {
  loading.value = true
  try {
    const data = await gameStore.fetchQuestion(mode.value, level.value)
    if (data.completed) {
      levelCompleted.value = true
    } else {
      question.value = data.question
      questionNumber.value = data.question_number
      totalQuestions.value = data.total_questions
    }
  } catch (e) {
    console.error(e)
  } finally {
    loading.value = false
  }
}

function choose(direction) {
  if (isWalking.value) return

  // Determine which answer was chosen based on direction
  let chosenAnswer
  if (mode.value === 'aru_iru') {
    chosenAnswer = direction === 'left' ? 'ある' : 'いる'
  } else {
    chosenAnswer = direction === 'left' ? 'だし' : 'し'
  }

  walkDirection.value = direction
  isWalking.value = true

  // Submit answer after walk animation
  setTimeout(async () => {
    try {
      const result = await gameStore.submitAnswer(
        mode.value,
        level.value,
        question.value.id,
        chosenAnswer
      )

      if (result.correct) {
        lastExplanation.value = result.explanation || ''
        if (result.food_item) {
          rewardItem.value = result.food_item
          showReward.value = true
        } else if (result.level_completed) {
          levelCompleted.value = true
        } else {
          // Auto-advance if no food reward
          showReward.value = false
          await resetScene()
          await loadQuestion()
        }
      } else {
        lastCorrectAnswer.value = result.correct_answer
        lastExplanation.value = result.explanation || ''
        showCrash.value = true
        setTimeout(() => {
          gameOver.value = true
        }, 1200)
      }
    } catch (e) {
      console.error(e)
    }
  }, 1500)
}

async function nextQuestion() {
  showReward.value = false
  rewardItem.value = null
  await resetScene()
  await loadQuestion()
}

async function retryQuestion() {
  gameOver.value = false
  showCrash.value = false
  await resetScene()
  // Don't reload - same question since progress didn't advance
  isWalking.value = false
  walkDirection.value = null
}

async function resetScene() {
  isWalking.value = false
  walkDirection.value = null
  showCrash.value = false
}

function goBack() {
  router.push(`/mode/${mode.value}/levels`)
}

onMounted(loadQuestion)
</script>

<style scoped>
.game-area {
  max-width: 600px;
  margin: 0 auto;
}

.question-card {
  background: linear-gradient(135deg, #FFF8F0, #FFFFFF);
  border: 2px solid #E8594F;
}

.question-text {
  font-family: 'Noto Sans JP', sans-serif;
  line-height: 2.2;
  color: #2D2D2D;
}

.question-text ruby {
  ruby-align: center;
}

.question-text rt {
  font-size: 0.5em;
  color: #888;
  font-weight: normal;
}

/* Road scene */
.road-scene {
  position: relative;
  max-width: 400px;
  height: 340px;
  margin: 0 auto;
  overflow: hidden;
}

.road-bg {
  position: relative;
  width: 100%;
  height: 100%;
  background: linear-gradient(180deg, #87CEEB 0%, #98D8C8 40%, #7CB342 60%, #8BC34A 100%);
  border-radius: 16px;
  overflow: hidden;
}

.road-svg {
  position: absolute;
  bottom: 0;
  left: 0;
  width: 100%;
  height: 100%;
}

/* Character */
.character {
  position: absolute;
  bottom: 20px;
  left: 50%;
  transform: translateX(-50%);
  font-size: 2.5rem;
  z-index: 10;
  transition: all 1.5s ease-in-out;
}

.character.walking.walk-left {
  bottom: 180px;
  left: 22%;
  transform: translateX(-50%) scaleX(-1);
}

.character.walking.walk-right {
  bottom: 180px;
  left: 78%;
  transform: translateX(-50%);
}

.character.crash {
  animation: crash-spin 0.6s ease-out forwards;
}

@keyframes crash-spin {
  0% { transform: translateX(-50%) rotate(0deg); }
  50% { transform: translateX(-50%) rotate(180deg) scale(1.2); }
  100% { transform: translateX(-50%) rotate(360deg) scale(0.3); opacity: 0.3; }
}

.character-body {
  animation: bobble 0.6s ease-in-out infinite alternate;
}

.walking .character-body {
  animation: walk-bobble 0.3s ease-in-out infinite alternate;
}

@keyframes bobble {
  from { transform: translateY(0); }
  to { transform: translateY(-4px); }
}

@keyframes walk-bobble {
  from { transform: translateY(0) rotate(-5deg); }
  to { transform: translateY(-8px) rotate(5deg); }
}

/* Choice buttons */
.choice-left, .choice-right {
  position: absolute;
  top: 30px;
  z-index: 10;
}

.choice-left {
  left: 8px;
}

.choice-right {
  right: 8px;
}

.choice-btn {
  font-size: 1.1rem !important;
  font-weight: 700 !important;
  letter-spacing: 0.05em;
  text-shadow: 0 1px 2px rgba(0,0,0,0.2);
  min-width: 100px;
}

/* Car crash */
.car-crash {
  position: absolute;
  z-index: 20;
}

.walk-left ~ .car-crash {
  left: -60px;
  top: 80px;
  animation: car-from-left 0.8s ease-in forwards;
}

.walk-right ~ .car-crash {
  right: -60px;
  top: 80px;
  animation: car-from-right 0.8s ease-in forwards;
}

.car {
  font-size: 2.5rem;
}

@keyframes car-from-left {
  0% { left: -80px; }
  100% { left: 60px; }
}

@keyframes car-from-right {
  0% { right: -80px; }
  100% { right: 60px; }
}

/* Reward card */
.reward-card {
  background: linear-gradient(135deg, #FFF8E1, #FFFFFF);
}

.reward-emoji {
  font-size: 5rem;
  animation: reward-bounce 0.6s ease-out;
}

@keyframes reward-bounce {
  0% { transform: scale(0) rotate(-20deg); }
  60% { transform: scale(1.3) rotate(5deg); }
  100% { transform: scale(1) rotate(0deg); }
}

/* Game over */
.game-over-card {
  background: linear-gradient(135deg, #FFEBEE, #FFFFFF);
}
</style>
