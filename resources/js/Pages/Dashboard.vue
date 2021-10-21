<template>
    <Layout>
        <table class="table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Expense</th>
                    <th>Amount</th>
                    <th>Category</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="exp in expenses">
                    <td>{{ exp.date }}</td>
                    <td>{{ exp.name }}</td>
                    <td>{{ exp.amount }}</td>
                    <td>{{ exp.category.name }}</td>
                </tr>
            </tbody>
        </table>
    </Layout>
</template>

<script>
import Layout from '../Shared/Layout.vue'

export default {
    components: {
        Layout,
    },
    props: ['expenses'],
}
</script>
