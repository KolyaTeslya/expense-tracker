<template>
  <div class="dashboard">
    <MonthSelector @change="changeMonth" />

    <div class="summary">
      <SummaryCard title="Total Income" :value="summary.total_income" />
      <SummaryCard title="Total Expenses" :value="summary.total_expenses" />
      <SummaryCard title="Balance" :value="summary.balance" />
    </div>

    <div class="content">
      <IncomeTable
        :year="year"
        :month="month"
        @updated="reload"
      />

      <div class="right">
        <ExpensePieChart :expenses="expenses" />

        <ExpenseTable
          :year="year"
          :month="month"
          @updated="reload"
        />
      </div>
    </div>
  </div>
</template>



<script setup>
import { ref } from 'vue'
import api from '../api/api'
import SummaryCard from '../components/SummaryCard.vue'
import MonthSelector from '../components/MonthSelector.vue'
import IncomeTable from '../components/IncomeTable.vue'
import ExpenseTable from '../components/ExpenseTable.vue'
import ExpensePieChart from '../components/ExpensePieChart.vue'

const year = ref(2025)
const month = ref(1)

const summary = ref({
  total_income: 0,
  total_expenses: 0,
  balance: 0
})

const expenses = ref([])

const loadDashboard = async () => {
  const res = await api.get('/dashboard', {
    params: { year: year.value, month: month.value }
  })
  summary.value = res.data
}

const loadExpenses = async () => {
  const res = await api.get('/expenses', {
    params: { year: year.value, month: month.value }
  })
  expenses.value = res.data
}

const reload = async () => {
  await loadDashboard()
  await loadExpenses()
}

const changeMonth = ({ year: y, month: m }) => {
  year.value = y
  month.value = m
  reload()
}

reload()
</script>


