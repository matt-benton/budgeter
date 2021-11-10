<template>
    <Layout>
        <div class="w-600 m-auto">
            <h2>Categories</h2>
            <div class="card">
                <form @submit.prevent="submitForm">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input
                            type="text"
                            v-model="form.name"
                            class="form-control"
                            id="name"
                            required="required"
                        />
                    </div>

                    <input class="btn btn-primary" type="submit" value="Add Category" />
                </form>
            </div>
            <div class="card" v-for="cat in categories">
                <h2 class="card-title">
                    <Link :href="`/categories/${cat.id}`">{{ cat.name }}</Link>
                </h2>
            </div>
        </div>
    </Layout>
</template>

<script>
import { useForm, Link } from '@inertiajs/inertia-vue3'
import Layout from '../../Shared/Layout.vue'

export default {
    setup() {
        const form = useForm({
            name: null,
        })

        return { form }
    },
    methods: {
        submitForm() {
            this.form.post('/categories')
            this.form.reset()
        },
    },
    props: ['categories'],
    components: {
        Layout,
        Link,
    },
}
</script>
