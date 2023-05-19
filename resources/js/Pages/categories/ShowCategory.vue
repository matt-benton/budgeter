<template>
    <Layout>
        <div class="content">
            <nav>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><Link href="/categories">Categories</Link></li>
                    <li class="breadcrumb-item active">{{ category.name }}</li>
                </ul>
            </nav>
            <div class="card">
                <h2>{{ category.name }}</h2>
                <Link :href="`/categories/${category.id}/edit`">Edit Category</Link>
            </div>
            <ExpenseTable :expenses="category.expenses" />
        </div>
    </Layout>
</template>

<script>
import Layout from '../../Shared/Layout.vue'
import ExpenseTable from '../expenses/ExpenseTable.vue'
import { Link } from '@inertiajs/vue3'

export default {
    components: {
        Layout,
        ExpenseTable,
        Link,
    },
    props: ['category'],
}
</script>
