<template>
  <canvas ref="canvas"></canvas>
</template>

<script setup>
import { ref, watch, onMounted } from 'vue'
import { Chart } from 'chart.js/auto'

const props = defineProps({
  expenses: Array
})

const canvas = ref(null)
let chart = null

const buildChart = () => {
  if (chart) chart.destroy()

  const grouped = {}
  props.expenses.forEach(e => {
    const name = e.category.name
    grouped[name] = (grouped[name] || 0) + Number(e.amount)
  })

  chart = new Chart(canvas.value, {
    type: 'pie',
    data: {
      labels: Object.keys(grouped),
      datasets: [
        {
          data: Object.values(grouped)
        }
      ]
    }
  })
}

onMounted(buildChart)

watch(
  () => props.expenses,
  () => buildChart(),
  { deep: true }
)
</script>
