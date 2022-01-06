<template>
    <div class="card">
        <form class="form-inline">
            <div class="form-group w-300 ml-auto">
                <label for="budget">Budget</label>
                <select
                    class="form-control"
                    id="budget"
                    v-model="selectedBudgetId"
                    @change="saveSelectedBudgetId"
                >
                    <option v-for="bud in budgets" :value="bud.id">
                        {{ bud.name }}
                    </option>
                </select>
            </div>
        </form>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th @click="sortBy = 'name'"><span class="click-text">Category</span></th>
                    <th @click="sortBy = 'three_month_avg'" class="text-right">
                        <span class="click-text">Prev 3 Month Avg</span>
                    </th>
                    <th class="text-right" @click="sortBy = 'budget'">
                        <span class="click-text">Budget</span>
                    </th>
                    <th class="text-right" @click="sortBy = 'total'">
                        <span class="click-text">Total</span>
                    </th>
                    <th class="text-right" @click="sortBy = 'percent'">
                        <span class="click-text">Percent</span>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="cat in table">
                    <td>{{ cat.name }}</td>
                    <td class="text-right">{{ formatAmount(cat.three_month_avg) }}</td>
                    <td class="text-right">
                        <span v-if="cat.budget_amount">
                            {{ formatAmount(cat.budget_amount) }}
                        </span>
                    </td>
                    <td
                        class="text-right"
                        :class="{
                            'text-danger':
                                cat.budget_amount && isOverBudget(cat.budget_amount, cat.total),
                        }"
                    >
                        {{ formatAmount(cat.total) }}
                    </td>
                    <td class="text-right">{{ cat.percent }}%</td>
                </tr>
                <tr>
                    <td></td>
                    <td class="text-right">{{ formatAmount(threeMonthAvgTotal) }}</td>
                    <td></td>
                    <td class="text-right">
                        <b>{{ formatAmount(allExpensesTotal) }}</b>
                    </td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import formatMixin from '../../Mixins/formatMixin'
import expenseMixin from '../../Mixins/expenseMixin'

export default {
    data() {
        return {
            sortBy: localStorage.getItem('budgeterCategoryTableSortBy')
                ? JSON.parse(localStorage.getItem('budgeterCategoryTableSortBy'))
                : 'name',
            selectedBudgetId: localStorage.getItem('selectedBudgetId')
                ? JSON.parse(localStorage.getItem('selectedBudgetId'))
                : this.budgets[0].id,
        }
    },
    computed: {
        allExpensesTotal() {
            return this.sumExpenses(this.expenses)
        },
        threeMonthAvgTotal() {
            return this.table.reduce((acc, currentRow) => acc + currentRow.three_month_avg, 0)
        },
        table() {
            return this.sortTable(
                this.categories
                    .filter(cat => cat.three_month_avg > 0 || this.hasExpenses(cat))
                    .map(cat => {
                        return {
                            name: cat.name,
                            three_month_avg: cat.three_month_avg,
                            percent: this.getCategoryPercent(cat.id),
                            total: this.getCategoryTotal(cat.id),
                            budget_amount: this.getBudgetAmount(cat.id),
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
        getBudgetAmount(categoryId) {
            let selectedBudget = this.budgets.find(bud => bud.id === this.selectedBudgetId)
            let budgetCategoryAmount = selectedBudget.budget_category_amounts.find(
                bca => bca.category_id === categoryId,
            )

            return budgetCategoryAmount ? budgetCategoryAmount.amount : null
        },
        sortTable(categories) {
            this.saveSortBy()

            switch (this.sortBy) {
                case 'name':
                    return categories.sort((a, b) => a.name.localeCompare(b.name))
                case 'percent':
                    return categories.sort((a, b) => b.percent - a.percent)
                case 'total':
                    return categories.sort((a, b) => b.total - a.total)
                case 'three_month_avg':
                    return categories.sort((a, b) => b.three_month_avg - a.three_month_avg)
                case 'budget':
                    return categories.sort((a, b) => b.budget_amount - a.budget_amount)
                default:
                    return categories
            }
        },
        isOverBudget(budgetAmount, spentAmount) {
            let total = spentAmount - budgetAmount
            return total > 0 ? total : null
        },
        saveSelectedBudgetId() {
            localStorage.setItem('selectedBudgetId', this.selectedBudgetId)
        },
        saveSortBy() {
            localStorage.setItem('budgeterCategoryTableSortBy', JSON.stringify(this.sortBy))
        },
        hasExpenses(category) {
            return this.expenses.find(exp => exp.category_id === category.id)
        },
    },
    props: ['categories', 'expenses', 'budgets'],
    mixins: [formatMixin, expenseMixin],
}
</script>

<style scoped>
.click-text {
    cursor: pointer;
}
</style>
