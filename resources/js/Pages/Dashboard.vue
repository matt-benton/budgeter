<template>
    <Layout>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Category</th>
                    <th class="text-right">Percent</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="cat in displayedCategories">
                    <td>{{ cat.name }}</td>
                    <td class="text-right">{{ getCategoryPercent(cat.id) }}%</td>
                    <td class="text-right">{{ formatAmount(getCategoryTotal(cat.id)) }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td class="text-right">
                        <b>{{ formatAmount(allExpensesTotal) }}</b>
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Expense</th>
                    <th>Category</th>
                    <th class="text-right">Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="exp in expenses">
                    <td>{{ formatDate(exp.date) }}</td>
                    <td>{{ exp.name }}</td>
                    <td>{{ exp.category.name }}</td>
                    <td class="text-right">{{ formatAmount(exp.amount) }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="text-right">
                        <b>{{ formatAmount(allExpensesTotal) }}</b>
                    </td>
                </tr>
            </tbody>
        </table>
    </Layout>
</template>

<script>
import Layout from '../Shared/Layout.vue'
import { format } from 'date-fns'

export default {
    computed: {
        allExpensesTotal() {
            return this.sumExpenses(this.expenses)
        },
        displayedCategories() {
            return this.categories.filter(cat => this.getCategoryTotal(cat.id) > 0)
        },
    },
    methods: {
        getCategoryTotal(categoryId) {
            return this.sumExpenses(this.expenses.filter(exp => exp.category_id === categoryId))
        },
        getCategoryPercent(categoryId) {
            let categoryTotal = this.getCategoryTotal(categoryId)

            return Math.round((categoryTotal / this.allExpensesTotal) * 100)
        },
        sumExpenses(expenses) {
            return expenses.reduce((acc, currentExpense) => acc + currentExpense.amount, 0)
        },
        formatAmount(amount) {
            return amount / 100
        },
        formatDate(date) {
            return format(new Date(date), 'MMM do')
        },
    },
    components: {
        Layout,
    },
    props: ['expenses', 'categories'],
}
</script>
