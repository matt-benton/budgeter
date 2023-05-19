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
                <CategoryTable :categories="categories" :expenses="expenses" :budgets="budgets" />
                <h3 class="font-size-22">Expenses</h3>
                <ExpenseTable :expenses="expenses" />
            </div>
            <div class="card" v-else>
                <p>No expenses found within date range</p>
            </div>
        </div>
    </Layout>
</template>

<script>
import Layout from '../Shared/Layout.vue'
import CategoryTable from './categories/CategoryTable.vue'
import ExpenseTable from './expenses/ExpenseTable.vue'
import { format, addMonths, subMonths, startOfMonth, endOfMonth } from 'date-fns'
import { Link } from '@inertiajs/vue3'
import formatMixin from '../Mixins/formatMixin'
import expenseMixin from '../Mixins/expenseMixin'

export default {
    computed: {
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
    mixins: [formatMixin, expenseMixin],
    components: {
        Layout,
        Link,
        CategoryTable,
        ExpenseTable,
    },
    props: ['expenses', 'categories', 'budgets'],
}
</script>
