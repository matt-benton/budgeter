<template>
    <Layout>
        <div class="content">
            <div class="d-flex justify-content-between align-items-center">
                <Link :href="`/?start=${prevMonthStart}&end=${prevMonthEnd}`">Prev</Link>
                <h2>{{ month }} {{ year }}</h2>
                <Link :href="`/?start=${nextMonthStart}&end=${nextMonthEnd}`">Next</Link>
            </div>
            <div v-if="expenses.length > 0">
                <h3 class="font-size-22">Categories</h3>
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
                <h3 class="font-size-22">Expenses</h3>
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
            </div>
            <div class="card" v-else>
                <p>No expenses found within date range</p>
            </div>
        </div>
    </Layout>
</template>

<script>
import Layout from '../Shared/Layout.vue'
import { format, addMonths, subMonths, startOfMonth, endOfMonth } from 'date-fns'
import { Link } from '@inertiajs/inertia-vue3'

export default {
    computed: {
        allExpensesTotal() {
            return this.sumExpenses(this.expenses)
        },
        displayedCategories() {
            return this.categories.filter(cat => this.getCategoryTotal(cat.id) > 0)
        },
        startDate() {
            let params = new URLSearchParams(window.location.search)
            let start = params.get('start')

            if (start) {
                return new Date(`${params.get('start')} 00:00:00`)
            }

            return startOfMonth(new Date())
        },
        endDate() {
            let params = new URLSearchParams(window.location.search)
            let end = params.get('end')

            if (end) {
                return new Date(`${params.get('end')} 00:00:00`)
            }

            return endOfMonth(new Date())
        },
        prevMonthStart() {
            return format(startOfMonth(subMonths(this.startDate, 1)), 'yyyy-MM-dd')
        },
        prevMonthEnd() {
            return format(endOfMonth(subMonths(this.endDate, 1)), 'yyyy-MM-dd')
        },
        nextMonthStart() {
            return format(startOfMonth(addMonths(this.startDate, 1)), 'yyyy-MM-dd')
        },
        nextMonthEnd() {
            return format(endOfMonth(addMonths(this.endDate, 1)), 'yyyy-MM-dd')
        },
        month() {
            return format(this.startDate, 'MMMM')
        },
        year() {
            return format(this.startDate, 'yyyy')
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
        Link,
    },
    props: ['expenses', 'categories'],
}
</script>
