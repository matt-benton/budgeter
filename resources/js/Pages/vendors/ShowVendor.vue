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
            <ExpenseTable :expenses="vendor.expenses" />
        </div>
    </Layout>
</template>

<script>
import Layout from '../../Shared/Layout.vue'
import ExpenseTable from '../expenses/ExpenseTable.vue'
import { Link } from '@inertiajs/inertia-vue3'

export default {
    components: {
        Layout,
        ExpenseTable,
        Link,
    },
    props: ['vendor'],
}
</script>
