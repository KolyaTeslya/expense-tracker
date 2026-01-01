<template>
  <div class="month-selector">
    <select v-model="month" @change="emitChange">
      <option v-for="m in months" :key="m.value" :value="m.value">
        {{ m.label }}
      </option>
    </select>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const emit = defineEmits(['change'])

const month = ref(1)

const months = [
  { value: 1, label: 'January' },
  { value: 2, label: 'February' },
  { value: 3, label: 'March' },
  { value: 4, label: 'April' },
  { value: 5, label: 'May' },
  { value: 6, label: 'June' },
  { value: 7, label: 'July' },
  { value: 8, label: 'August' },
  { value: 9, label: 'September' },
  { value: 10, label: 'October' },
  { value: 11, label: 'November' },
  { value: 12, label: 'December' }
]

const emitChange = () => {
  emit('change', { year: 2025, month: month.value })
}
</script>
