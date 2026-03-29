import { defineStore } from 'pinia'
import { ref } from 'vue'
import api from '../api'

export const useGameStore = defineStore('game', () => {
  const levels = ref([])
  const currentQuestion = ref(null)
  const collection = ref({ collected: [], total_items: 0, collected_count: 0 })

  async function fetchLevels(mode) {
    const res = await api.get(`/api/game/${mode}/levels`)
    levels.value = res.data
    return res.data
  }

  async function fetchQuestion(mode, level) {
    const res = await api.get(`/api/game/${mode}/${level}/question`)
    currentQuestion.value = res.data
    return res.data
  }

  async function submitAnswer(mode, level, questionId, answer) {
    const res = await api.post(`/api/game/${mode}/${level}/answer`, {
      question_id: questionId,
      answer,
    })
    return res.data
  }

  async function resetLevel(mode, level) {
    const res = await api.post(`/api/game/${mode}/${level}/reset`)
    return res.data
  }

  async function fetchCollection() {
    const res = await api.get('/api/collection')
    collection.value = res.data
    return res.data
  }

  return { levels, currentQuestion, collection, fetchLevels, fetchQuestion, submitAnswer, resetLevel, fetchCollection }
})
