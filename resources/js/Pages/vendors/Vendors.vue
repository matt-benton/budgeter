<template>
    <Layout>
        <div class="w-600 m-auto">
            <h2>Vendors</h2>
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

                    <input class="btn btn-primary" type="submit" value="Add Vendor" />
                </form>
            </div>
            <div class="card" v-for="vendor in vendors">
                <h2 class="card-title">
                    <Link :href="`/vendors/${vendor.id}`">{{ vendor.name }}</Link>
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
            this.form.post('/vendors')
            this.form.reset()
        },
    },
    props: ['vendors'],
    components: {
        Layout,
        Link,
    },
}
</script>
