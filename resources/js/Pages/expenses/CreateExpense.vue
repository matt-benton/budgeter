<template>
    <Layout>
        <div class="w-600 m-auto" @keydown.alt.shift="onKeydown">
            <h2>Create Expense</h2>
            <div class="card">
                <form @submit.prevent="submitForm">
                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input
                            type="text"
                            class="form-control"
                            id="amount"
                            v-model="form.amount"
                            step="0.01"
                            @keydown="onAmountEvent"
                            autocomplete="off"
                        />
                        <ul id="expense-search-results" v-show="searchedExpenses.length > 0">
                            <li
                                v-for="exp in searchedExpenses"
                                @click="onExpenseClicked(exp)"
                                :class="{ selected: expenseIsSelected(exp) }"
                            >
                                <span>{{ (exp.amount / 100).toFixed(2) }}</span
                                ><span>{{ exp.name }}</span>
                            </li>
                        </ul>
                        <p class="text-danger" v-if="form.errors.amount">{{ form.errors.amount }}</p>
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" v-model="form.name" />
                        <p class="text-danger" v-if="form.errors.name">{{ form.errors.name }}</p>
                    </div>
                    <div class="form-group">
                        <label for="date">Date</label>
                        <input type="date" class="form-control" id="date" v-model="form.date" />
                        <p class="text-danger" v-if="form.errors.date">{{ form.errors.date }}</p>
                    </div>
                    <div class="form-group">
                        <label for="category">Category</label>
                        <select class="form-control" id="category" v-model="form.category_id">
                            <option v-for="category in categories" :value="category.id">
                                {{ category.name }}
                            </option>
                        </select>
                        <p class="text-danger" v-if="form.errors.category_id">{{ form.errors.category_id }}</p>
                    </div>
                    <div class="form-group">
                        <label for="vendor">Vendor</label>
                        <select class="form-control" id="vendor" v-model="form.vendor_id">
                            <option value="">No Vendor</option>
                            <option v-for="vendor in vendors" :value="vendor.id">
                                {{ vendor.name }}
                            </option>
                        </select>
                        <p class="text-danger" v-if="form.errors.vendor_id">{{ form.errors.vendor_id }}</p>
                    </div>
                    <div class="form-check" v-if="form.errors.date">
                        <input class="form-check-input" type="checkbox" v-model="form.override" id="override-checkbox">
                        <label class="form-check-label" for="override-checkbox">
                            Override Validation
                        </label>
                    </div>
                    <input type="submit" class="btn btn-primary" value="Add Expense" />
                </form>
            </div>
            <p class="text-muted"><kbd>alt</kbd> + <kbd>shift</kbd> to set date to today</p>
        </div>
        <hr />
        <h5>Recent Expenses</h5>
        <ExpenseTable :expenses="recentExpenses" />
    </Layout>
</template>

<script>
import Layout from '../../Shared/Layout.vue'
import ExpenseTable from './ExpenseTable.vue'
import { useForm } from '@inertiajs/vue3'
import { format } from 'date-fns'
import axios from 'axios'

export default {
    data() {
        return {
            timeout: null,
            searchedExpenses: [],
        }
    },
    setup() {
        const form = useForm({
            amount: null,
            name: null,
            date: null,
            category_id: null,
            vendor_id: null,
            override: false,
        })

        return { form }
    },
    methods: {
        submitForm() {
            this.form.post('/expenses', {
                onSuccess: this.onFormSuccess,
            })
        },
        onFormSuccess() {
            this.form.reset()
            document.querySelector('#amount').focus()
        },
        onAmountEvent(event) {
            switch (event.key) {
                case 'Tab':
                    clearTimeout(this.timeout)
                    this.searchedExpenses = []
                    break
                case 'ArrowDown':
                    this.selectNextExpense()
                    break
                case 'ArrowUp':
                    this.selectPrevExpense()
                    break
                case 'Escape':
                    this.searchedExpenses = []
                    break
                default:
                    this.searchExpensesAfterDelay()
            }
        },
        onExpenseClicked(exp) {
            this.form.amount = exp.amount / 100
            this.form.name = exp.name
            this.form.category_id = exp.category_id
            this.form.vendor_id = exp.vendor_id

            this.searchedExpenses = []
        },
        async fetchExpenses() {
            return await axios.get(`/expenses?search=${this.form.amount}`)
        },
        async searchExpenses() {
            if (this.form.amount) {
                let result = await this.fetchExpenses()
                this.searchedExpenses = result.data.expenses
            } else {
                this.searchedExpenses = []
            }
        },
        searchExpensesAfterDelay() {
            clearTimeout(this.timeout)
            this.timeout = setTimeout(this.searchExpenses, 500)
        },
        setExpense(exp) {
            this.form.amount = exp.amount / 100
            this.form.name = exp.name
            this.form.category_id = exp.category_id
            this.form.vendor_id = exp.vendor_id
        },
        selectNextExpense() {
            if (this.searchedExpenses.length > 0) {
                let currentExpenseIndex = this.searchedExpenses.findIndex(
                    exp => exp.name === this.form.name && this.form.amount * 100 === exp.amount,
                )

                if (
                    currentExpenseIndex === -1 ||
                    currentExpenseIndex >= this.searchedExpenses.length - 1
                ) {
                    this.setExpense(this.searchedExpenses[0])
                } else {
                    this.setExpense(this.searchedExpenses[currentExpenseIndex + 1])
                }
            }
        },
        selectPrevExpense() {
            if (this.searchedExpenses.length > 0) {
                let currentExpenseIndex = this.searchedExpenses.findIndex(
                    exp => exp.name === this.form.name && this.form.amount * 100 === exp.amount,
                )

                if (currentExpenseIndex === -1 || currentExpenseIndex <= 0) {
                    this.setExpense(this.searchedExpenses[this.searchedExpenses.length - 1])
                } else {
                    this.setExpense(this.searchedExpenses[currentExpenseIndex - 1])
                }
            }
        },
        expenseIsSelected(exp) {
            return this.form.name === exp.name && this.form.amount * 100 === exp.amount
        },
        onKeydown() {
            this.form.date = format(new Date(), 'yyyy-MM-dd')
        },
    },
    components: {
        Layout,
        ExpenseTable,
    },
    props: ['categories', 'recentExpenses', 'vendors'],
}
</script>

<style scoped>
#expense-search-results {
    background-color: var(--dark-color-light);
    list-style-type: none;
    padding: 4px;
}

#expense-search-results > li {
    display: flex;
    justify-content: space-between;
    cursor: pointer;
    padding: 4px 8px;
    border-radius: var(--base-border-radius);
}

#expense-search-results > li:hover,
.selected {
    background-color: var(--dark-color-dark);
}

#expense-search-results > li:last-of-type {
    margin-bottom: 0;
}
</style>
