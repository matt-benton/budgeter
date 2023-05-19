<template>
    <Layout>
        <div class="card">
            <h2>{{ expense.name }}</h2>
            <h3>${{ formatAmount(expense.amount) }}</h3>
            <h4 class="text-muted">{{ expense.category.name }}</h4>
            <h4 class="text-muted">
                {{ formatDate(expense.date) }}
                <span v-if="expense.vendor">from {{ expense.vendor.name }}</span>
            </h4>
            <Link :href="`/expenses/${expense.id}/edit`">Edit Expense</Link>
        </div>
        <div class="card">
            <h4>Similar Expenses</h4>
            <ExpenseTable :expenses="similarExpenses" />
        </div>
    </Layout>
</template>

<script>
import Layout from '../../Shared/Layout.vue'
import formatMixin from '../../Mixins/formatMixin'
import ExpenseTable from './ExpenseTable.vue'
import { format } from 'date-fns'
import { Link } from '@inertiajs/vue3'

export default {
    methods: {
        formatDate(date) {
            return format(new Date(`${date} 00:00:00`), 'MMMM d, yyyy')
        },
    },
    props: ['expense', 'similarExpenses'],
    components: {
        Layout,
        Link,
        ExpenseTable,
    },
    mixins: [formatMixin],
}
</script>
