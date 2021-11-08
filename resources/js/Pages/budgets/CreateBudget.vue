<template>
    <Layout>
        <div class="w-400 mx-auto mb-20">
            <h2>Create Budget</h2>
            <form class="form-inline" @submit.prevent="form.post('/budgets')">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" v-model="form.name" />
                </div>
                <hr />
                <div class="form-group" v-for="cat in form.budget_category_amounts">
                    <label :for="cat.name" class="w-200">{{ cat.name }}</label>
                    <input type="text" class="form-control" :id="cat.name" v-model="cat.amount" />
                </div>
                <button class="btn btn-primary ml-auto">Save</button>
            </form>
        </div>
    </Layout>
</template>

<script>
import Layout from '../../Shared/Layout.vue'
import { useForm } from '@inertiajs/inertia-vue3'

export default {
    setup(props) {
        let categoryIds = props.categories.map(cat => {
            return {
                name: cat.name,
                category_id: cat.id,
                amount: null,
            }
        })
        const form = useForm({
            name: null,
            budget_category_amounts: categoryIds,
        })

        return { form }
    },
    components: {
        Layout,
    },
    props: ['categories'],
}
</script>
