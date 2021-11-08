<template>
    <Layout>
        <div class="content">
            <nav>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><Link href="/budgets">Budgets</Link></li>
                    <li class="breadcrumb-item active">{{ budget.name }}</li>
                </ul>
            </nav>
            <div class="card">
                <h2>{{ budget.name }}</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="amount in budget.budget_category_amounts">
                            <td>{{ amount.category.name }}</td>
                            <td>{{ formatAmount(amount.amount) }}</td>
                        </tr>
                    </tbody>
                </table>
                <div class="text-right">
                    <Link :href="`/budget/${budget.id}/edit`" class="ml-auto">Edit Budget</Link>
                </div>
            </div>
        </div>
    </Layout>
</template>

<script>
import Layout from '../../Shared/Layout.vue'
import { Link } from '@inertiajs/inertia-vue3'
import formatMixin from '../../Mixins/formatMixin'

export default {
    props: ['budget'],
    components: {
        Layout,
        Link,
    },
    mixins: [formatMixin],
}
</script>
