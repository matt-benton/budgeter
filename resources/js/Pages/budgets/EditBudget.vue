<template>
    <Layout>
        <div class="content w-500 mx-auto mb-20">
            <nav>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><Link href="/budgets">Budgets</Link></li>
                    <li class="breadcrumb-item">
                        <Link :href="`/budgets/${budget.id}`">{{ budget.name }}</Link>
                    </li>
                    <li class="breadcrumb-item active">Edit</li>
                </ul>
            </nav>
            <div class="card">
                <h2>Edit Budget</h2>
                <form class="form-inline" @submit.prevent="editForm.put(`/budgets/${budget.id}`)">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" v-model="editForm.name" />
                    </div>
                    <hr />
                    <div class="form-group" v-for="cat in editForm.budget_category_amounts">
                        <label :for="cat.name" class="w-200">{{ cat.name }}</label>
                        <input
                            type="text"
                            class="form-control"
                            :id="cat.name"
                            v-model="cat.amount"
                        />
                    </div>
                    <button class="btn btn-primary ml-auto">Save</button>
                </form>
            </div>
            <div class="card">
                <h3>Delete Budget</h3>
                <form @submit.prevent="deleteBudget">
                    <div class="form-group">
                        <label for="delete" id="delete">Type 'delete' to delete budget</label>
                        <input
                            type="text"
                            v-model="deleteConfirm"
                            class="form-control"
                            id="delete"
                            autocomplete="off"
                        />
                    </div>
                    <input type="submit" class="btn btn-default" value="Delete Budget" />
                </form>
            </div>
        </div>
    </Layout>
</template>

<script>
import Layout from '../../Shared/Layout.vue'
import { useForm, Link } from '@inertiajs/inertia-vue3'

export default {
    data() {
        return {
            deleteConfirm: '',
        }
    },
    setup(props) {
        let budget_category_amounts = props.categories.map(cat => {
            let matchingBca = props.budget.budget_category_amounts.find(
                bca => bca.category_id === cat.id,
            )

            return {
                name: cat.name,
                category_id: cat.id,
                amount: matchingBca ? (matchingBca.amount / 100).toFixed(2) : null,
            }
        })

        const editForm = useForm({
            name: props.budget.name,
            budget_category_amounts,
        })

        const deleteForm = useForm()

        return { editForm, deleteForm }
    },
    methods: {
        deleteBudget() {
            if (this.deleteConfirm.toLowerCase() === 'delete') {
                this.deleteForm.delete(`/budgets/${this.budget.id}`)
            }
        },
    },
    props: ['budget', 'categories'],
    components: {
        Layout,
        Link,
    },
}
</script>
