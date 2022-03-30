<template>
    <Layout>
        <div class="content">
            <nav>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><Link href="/vendors">Vendors</Link></li>
                    <li class="breadcrumb-item active">{{ vendor.name }}</li>
                </ul>
            </nav>
            <div class="card">
                <h2>{{ vendor.name }}</h2>
                <Link :href="`/vendors/${vendor.id}/edit`">Edit Vendor</Link>
            </div>
            <div class="card">
                <p>
                    You have purchased from this vendor <b>{{ stats.num_purchases }}</b> times.
                </p>
                <p>
                    You spend <b>${{ formatAmount(stats.avg_purchase_amount) }}</b> on average when
                    you buy from this vendor.
                </p>
                <p>
                    You have spent a total of
                    <b>${{ formatAmount(stats.total_amount_spent) }}</b> at this vendor
                </p>
            </div>
            <ExpenseTable :expenses="vendor.expenses" />
        </div>
    </Layout>
</template>

<script>
import Layout from '../../Shared/Layout.vue'
import ExpenseTable from '../expenses/ExpenseTable.vue'
import { Link } from '@inertiajs/inertia-vue3'
import formatMixin from '../../Mixins/formatMixin'

export default {
    components: {
        Layout,
        ExpenseTable,
        Link,
    },
    mixins: [formatMixin],
    props: ['vendor', 'stats'],
}
</script>
