<template>
  <div class="income-table">
    <h2>Income</h2>

    <table>
      <thead>
        <tr>
          <th>Source</th>
          <th>Amount</th>
        </tr>
      </thead>
<tbody>
  <tr v-for="income in incomes" :key="income.id">
    <td>
      <select v-model="income.income_source_id" @change="updateIncome(income)">
        <option v-for="s in sources" :key="s.id" :value="s.id">
          {{ s.name }}
        </option>
      </select>
    </td>
    <td>
      <input
        type="number"
        v-model="income.amount"
        @blur="updateIncome(income)"
      />
    </td>
    <td>
      <button @click="deleteIncome(income.id)">✕</button>
    </td>
  </tr>
</tbody>

    </table>

    <div class="add-income">
      <select v-model="newIncome.sourceId">
        <option value="">Select source</option>
        <option v-for="s in sources" :key="s.id" :value="s.id">
          {{ s.name }}
        </option>
      </select>

      <input
        type="number"
        placeholder="Amount"
        v-model="newIncome.amount"
      />

      <button @click="addIncome">Add</button>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '../api/api'

const props = defineProps({
  year: Number,
  month: Number
})

const emit = defineEmits(['updated'])

const incomes = ref([])
const sources = ref([])

const newIncome = ref({
  sourceId: '',
  amount: ''
})

const loadSources = async () => {
  const res = await api.get('/income-sources')
  sources.value = res.data
}

const loadIncomes = async () => {
  const res = await api.get('/incomes', {
    params: { year: props.year, month: props.month }
  })
  incomes.value = res.data
}

const addIncome = async () => {
  await api.post('/incomes', {
    income_source_id: newIncome.value.sourceId,
    year: props.year,
    month: props.month,
    amount: newIncome.value.amount
  })

  newIncome.value.amount = ''
  newIncome.value.sourceId = ''

  await loadIncomes()
  emit('updated')
}

const updateIncome = async (income) => {
  await api.put(`/incomes/${income.id}`, {
    income_source_id: income.income_source_id,
    year: props.year,
    month: props.month,
    amount: income.amount
  })

  emit('updated')
}

const deleteIncome = async (id) => {
  await api.delete(`/incomes/${id}`)
  await loadIncomes()
  emit('updated')
}


onMounted(() => {
  loadSources()
  loadIncomes()
})
</script>
