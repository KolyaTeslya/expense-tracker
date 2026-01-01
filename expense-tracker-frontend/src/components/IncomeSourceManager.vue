<template>
  <div class="income-sources">
    <h3>Income Sources</h3>

    <div class="source-list">
      <div
        v-for="source in sources"
        :key="source.id"
        class="source-row"
      >
        <input
          v-model="source.name"
          @blur="updateSource(source)"
        />
            <button class="danger" @click="deleteSource(source.id)">✕</button>
      </div>
    </div>
  </div>
</template>


<script setup>
import { ref, onMounted } from 'vue'
import api from '../api/api'

const emit = defineEmits(['updated'])
const sources = ref([])

const loadSources = async () => {
  const res = await api.get('/income-sources')
  sources.value = res.data
}

const updateSource = async (source) => {
  await api.put(`/income-sources/${source.id}`, {
    name: source.name
  })
  emit('updated')
}

const deleteSource = async (id) => {
  await api.delete(`/income-sources/${id}`)
  await loadSources()
  emit('updated')
}

onMounted(loadSources)
</script>
