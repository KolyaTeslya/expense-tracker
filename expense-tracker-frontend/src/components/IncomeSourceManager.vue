<template>
  <div class="income-sources">
    <h3>Income Sources</h3>

    <!-- ADD NEW SOURCE -->
    <div class="add-source">
      <input
        v-model="newSource"
        placeholder="New income source"
      />
      <button class="btn btn-green" @click="createSource">
        Add source
      </button>
    </div>

    <!-- LIST -->
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
        <button
          class="danger"
          @click="deleteSource(source.id)"
        >
          ✕
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '../api/api'

const emit = defineEmits(['updated'])

const sources = ref([])
const newSource = ref('')

const loadSources = async () => {
  const res = await api.get('/income-sources')
  sources.value = res.data
}

const createSource = async () => {
  if (!newSource.value.trim()) return

  await api.post('/income-sources', {
    name: newSource.value
  })

  newSource.value = ''
  await loadSources()
  emit('updated')
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
