<template>
  <div class="summary-card">
    <div class="title">{{ title }}</div>
    <div class="value">{{ value }}</div>
  </div>
</template>

<script setup>
defineProps({
  title: String,
  value: Number
})
</script>
