<template>
    <table class="table table-striped">
        <thead>
            <tr>
                <th @click="sortBy = 'date'"><span class="click-text">Date</span></th>
                <th @click="sortBy = 'name'"><span class="click-text">Expense</span></th>
                <th @click="sortBy = 'category'"><span class="click-text">Category</span></th>
                <th @click="sortBy = 'amount'" class="text-right">
                    <span class="click-text">Amount</span>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="exp in sortedExpenses">
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
</template>

<script>
import formatMixin from '../../Mixins/formatMixin'
import expenseMixin from '../../Mixins/expenseMixin'
import { format, isBefore } from 'date-fns'

export default {
    data() {
        return {
            sortBy: 'date',
        }
    },
    computed: {
        sortedExpenses() {
            return this.sortExpenses(this.expenses)
        },
        allExpensesTotal() {
            return this.sumExpenses(this.expenses)
        },
    },
    methods: {
        formatDate(date) {
            return format(new Date(`${date} 00:00:00`), 'MMM do')
        },
        sortExpenses(expenses) {
            switch (this.sortBy) {
                case 'date':
                    return expenses.sort((a, b) =>
                        isBefore(new Date(`${b.date} 00:00:00`), new Date(`${a.date} 00:00:00`)),
                    )
                case 'name':
                    return expenses.sort((a, b) => a.name.localeCompare(b.name))
                case 'category':
                    return expenses.sort((a, b) => a.category.name.localeCompare(b.category.name))
                case 'amount':
                    return expenses.sort((a, b) => b.amount - a.amount)
                default:
                    return expenses
            }
        },
    },
    mixins: [formatMixin, expenseMixin],
    props: ['expenses'],
}
</script>

<style scoped>
.click-text {
    cursor: pointer;
}
</style>