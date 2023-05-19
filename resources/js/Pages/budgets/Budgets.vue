<template>
    <Layout>
        <div class="w-600 m-auto">
            <h2>Budgets</h2>
            <Link href="/budgets/create">New Budget</Link>
            <div v-if="budgets.length > 0">
                <div class="card" v-for="budget in budgets">
                    <Link :href="`/budgets/${budget.id}`">{{ budget.name }}</Link>
                </div>
            </div>
            <div v-else>No budgets found.</div>
        </div>
    </Layout>
</template>

<script>
import Layout from '../../Shared/Layout.vue'
import { Link } from '@inertiajs/vue3'

export default {
    components: {
        Layout,
        Link,
    },
    props: ['budgets'],
}
</script>
