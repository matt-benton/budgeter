<template>
    <Layout>
        <h2>{{ expense.name }}</h2>
        <h3>${{ formatAmount(expense.amount) }}</h3>
        <h4 class="text-muted">{{ expense.category.name }}</h4>
        <h4>{{ formatDate(expense.date) }}</h4>
        <Link :href="`/expenses/${expense.id}/edit`">Edit Expense</Link>
    </Layout>
</template>

<script>
import Layout from '../../Shared/Layout.vue'
import formatMixin from '../../Mixins/formatMixin'
import { format } from 'date-fns'
import { Link } from '@inertiajs/inertia-vue3'

export default {
    methods: {
        formatDate(date) {
            return format(new Date(`${date} 00:00:00`), 'MMMM d, yyyy')
        },
    },
    props: ['expense'],
    components: {
        Layout,
        Link,
    },
    mixins: [formatMixin],
}
</script>
