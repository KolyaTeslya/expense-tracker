<template>
  <div class="expense-table">
    <h2>Expenses</h2>

    <table>
      <thead>
        <tr>
          <th>Category</th>
          <th>Amount</th>
        </tr>
      </thead>
<tbody>
  <tr v-for="expense in expenses" :key="expense.id">
    <td>
      <select
        v-model="expense.expense_category_id"
        @change="updateExpense(expense)"
      >
        <option v-for="c in categories" :key="c.id" :value="c.id">
          {{ c.name }}
        </option>
      </select>
    </td>
    <td>
      <input
        type="number"
        v-model="expense.amount"
        @blur="updateExpense(expense)"
      />
    </td>
    <td>
      <button @click="deleteExpense(expense.id)">✕</button>
    </td>
  </tr>
</tbody>

    </table>

    <div class="add-expense">
      <select v-model="newExpense.categoryId">
        <option value="">Select category</option>
        <option v-for="c in categories" :key="c.id" :value="c.id">
          {{ c.name }}
        </option>
      </select>

      <input
        type="number"
        placeholder="Amount"
        v-model="newExpense.amount"
      />

      <button @click="addExpense">Add</button>
    </div>

    <div class="add-category">
      <input
        type="text"
        placeholder="New category"
        v-model="newCategory"
      />
      <button @click="addCategory">Add category</button>
    </div>
  </div>
  <div v-for="c in categories" :key="c.id" class="category-row">
  <input v-model="c.name" @blur="updateCategory(c)" />
  <button @click="deleteCategory(c.id)">✕</button>
</div>

</template>

<script setup>
import { ref, onMounted, watch } from 'vue'
import api from '../api/api'

const props = defineProps({
  year: Number,
  month: Number
})

const emit = defineEmits(['updated'])

const expenses = ref([])
const categories = ref([])

const newExpense = ref({
  categoryId: '',
  amount: ''
})

const newCategory = ref('')

const loadCategories = async () => {
  const res = await api.get('/expense-categories')
  categories.value = res.data
}

const loadExpenses = async () => {
  const res = await api.get('/expenses', {
    params: { year: props.year, month: props.month }
  })
  expenses.value = res.data
}

const addExpense = async () => {
  await api.post('/expenses', {
    expense_category_id: newExpense.value.categoryId,
    year: props.year,
    month: props.month,
    amount: newExpense.value.amount
  })

  newExpense.value.amount = ''
  newExpense.value.categoryId = ''

  await loadExpenses()
  emit('updated')
}

const addCategory = async () => {
  if (!newCategory.value) return

  await api.post('/expense-categories', {
    name: newCategory.value
  })

  newCategory.value = ''
  await loadCategories()
}

const updateExpense = async (expense) => {
  await api.put(`/expenses/${expense.id}`, {
    expense_category_id: expense.expense_category_id,
    year: props.year,
    month: props.month,
    amount: expense.amount
  })

  emit('updated')
}

const updateCategory = async (category) => {
  await api.put(`/expense-categories/${category.id}`, {
    name: category.name
  })
}

const deleteCategory = async (id) => {
  await api.delete(`/expense-categories/${id}`)
  await loadCategories()
  await loadExpenses()
  emit('updated')
}

const deleteExpense = async (id) => {
  await api.delete(`/expenses/${id}`)
  await loadExpenses()
  emit('updated')
}


onMounted(() => {
  loadCategories()
  loadExpenses()
})

watch(
  () => [props.year, props.month],
  () => loadExpenses()
)
</script>
