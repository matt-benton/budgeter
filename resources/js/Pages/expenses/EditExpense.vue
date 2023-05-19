<template>
    <Layout>
        <div class="content">
            <nav>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><Link href="/">Home</Link></li>
                    <li class="breadcrumb-item">
                        <Link :href="`/expenses/${expense.id}`">{{ expense.name }}</Link>
                    </li>
                    <li class="breadcrumb-item active">Edit</li>
                </ul>
            </nav>
            <h2>Edit Expense</h2>
            <div class="card">
                <form @submit.prevent="editForm.put(`/expenses/${expense.id}`)">
                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input
                            type="text"
                            id="amount"
                            v-model="editForm.amount"
                            class="form-control"
                        />
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" v-model="editForm.name" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label for="date">Date</label>
                        <input type="date" id="date" v-model="editForm.date" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label for="category">Category</label>
                        <select class="form-control" id="category" v-model="editForm.category_id">
                            <option v-for="category in categories" :value="category.id">
                                {{ category.name }}
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="vendor">Vendor</label>
                        <select class="form-control" id="vendor" v-model="editForm.vendor_id">
                            <option value="">No Vendor</option>
                            <option v-for="vendor in vendors" :value="vendor.id">
                                {{ vendor.name }}
                            </option>
                        </select>
                    </div>
                    <input type="submit" class="btn btn-primary" value="Save" />
                </form>
            </div>
            <div class="card">
                <h3>Delete Expense</h3>
                <form @submit.prevent="deleteExpense">
                    <div class="form-group">
                        <label for="delete" id="delete">Type 'delete' to delete expense</label>
                        <input
                            type="text"
                            v-model="deleteConfirm"
                            class="form-control"
                            id="delete"
                            autocomplete="off"
                        />
                    </div>
                    <input type="submit" class="btn btn-default" value="Delete Expense" />
                </form>
            </div>
        </div>
    </Layout>
</template>

<script>
import Layout from '../../Shared/Layout.vue'
import { useForm, Link } from '@inertiajs/vue3'

export default {
    data() {
        return {
            deleteConfirm: '',
        }
    },
    setup(props) {
        const deleteForm = useForm({})
        const editForm = useForm({
            amount: (props.expense.amount / 100).toFixed(2),
            name: props.expense.name,
            date: props.expense.date,
            category_id: props.expense.category_id,
            vendor_id: props.expense.vendor_id,
        })

        return { deleteForm, editForm }
    },
    methods: {
        deleteExpense() {
            if (this.deleteConfirm.toLowerCase() === 'delete') {
                this.deleteForm.delete(`/expenses/${this.expense.id}`)
            }
        },
    },
    components: {
        Layout,
        Link,
    },
    props: ['expense', 'categories', 'vendors'],
}
</script>
