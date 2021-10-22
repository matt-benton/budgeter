export default {
    methods: {
        sumExpenses(expenses) {
            return expenses.reduce((acc, currentExpense) => acc + currentExpense.amount, 0)
        },
    },
}
