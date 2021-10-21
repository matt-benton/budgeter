<template>
    <Layout>
        <div class="w-600 m-auto">
            <h2>Create Expense</h2>
            <div class="card">
                <form @submit.prevent="submitForm">
                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input
                            type="number"
                            class="form-control"
                            id="amount"
                            v-model="form.amount"
                            step="0.01"
                        />
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" v-model="form.name" />
                    </div>
                    <div class="form-group">
                        <label for="date">Date</label>
                        <input type="date" class="form-control" id="date" v-model="form.date" />
                    </div>
                    <div class="form-group">
                        <label for="category">Category</label>
                        <select class="form-control" id="category" v-model="form.category_id">
                            <option v-for="category in categories" :value="category.id">
                                {{ category.name }}
                            </option>
                        </select>
                    </div>
                    <input type="submit" class="btn btn-primary" value="Add Expense" />
                </form>
            </div>
        </div>
    </Layout>
</template>

<script>
import Layout from '../../Shared/Layout.vue'
import { useForm } from '@inertiajs/inertia-vue3'

export default {
    setup() {
        const form = useForm({
            amount: null,
            name: null,
            date: null,
            category_id: null,
        })

        return { form }
    },
    methods: {
        submitForm() {
            this.form.post('/expenses')
            this.form.reset()
        },
    },
    components: {
        Layout,
    },
    props: ['categories'],
}
</script>
