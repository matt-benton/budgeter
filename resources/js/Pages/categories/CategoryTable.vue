<template>
    <table class="table table-striped">
        <thead>
            <tr>
                <th @click="sortBy = 'name'"><span class="click-text">Category</span></th>
                <th class="text-right" @click="sortBy = 'percent'">
                    <span class="click-text">Percent</span>
                </th>
                <th class="text-right" @click="sortBy = 'total'">
                    <span class="click-text">Total</span>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="cat in table">
                <td>{{ cat.name }}</td>
                <td class="text-right">{{ cat.percent }}%</td>
                <td class="text-right">{{ cat.total }}</td>
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
</template>

<script>
import formatMixin from '../../Mixins/formatMixin'
import expenseMixin from '../../Mixins/expenseMixin'

export default {
    data() {
        return {
            sortBy: 'name',
        }
    },
    computed: {
        allExpensesTotal() {
            return this.sumExpenses(this.expenses)
        },
        table() {
            return this.sortTable(
                this.categories
                    .filter(cat => this.getCategoryTotal(cat.id) > 0)
                    .map(cat => {
                        return {
                            name: cat.name,
                            percent: this.getCategoryPercent(cat.id),
                            total: this.formatAmount(this.getCategoryTotal(cat.id)),
                        }
                    }),
            )
        },
    },
    methods: {
        getCategoryPercent(categoryId) {
            let categoryTotal = this.getCategoryTotal(categoryId)

            return Math.round((categoryTotal / this.allExpensesTotal) * 100)
        },
        getCategoryTotal(categoryId) {
            return this.sumExpenses(this.expenses.filter(exp => exp.category_id === categoryId))
        },
        sortTable(categories) {
            switch (this.sortBy) {
                case 'name':
                    return categories.sort((a, b) => a.name.localeCompare(b.name))
                case 'percent':
                    return categories.sort((a, b) => b.percent - a.percent)
                case 'total':
                    return categories.sort((a, b) => b.total - a.total)
                default:
                    return categories
            }
        },
    },
    props: ['categories', 'expenses'],
    mixins: [formatMixin, expenseMixin],
}
</script>

<style scoped>
.click-text {
    cursor: pointer;
}
</style>
