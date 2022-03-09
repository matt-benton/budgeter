<template>
    <Layout>
        <div class="content">
            <nav>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><Link href="/vendors">Vendors</Link></li>
                    <li class="breadcrumb-item">
                        <Link :href="`/vendors/${vendor.id}`">{{ vendor.name }}</Link>
                    </li>
                    <li class="breadcrumb-item active">Edit</li>
                </ul>
            </nav>
            <div class="w-600 m-auto">
                <h1>Edit Vendor</h1>
                <div class="card">
                    <form @submit.prevent="form.put(`/vendors/${vendor.id}`)">
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

                        <input class="btn btn-primary" type="submit" value="Update Vendor" />
                    </form>
                </div>
            </div>
        </div>
    </Layout>
</template>

<script>
import Layout from '../../Shared/Layout.vue'
import { useForm, Link } from '@inertiajs/inertia-vue3'

export default {
    setup(props) {
        const form = useForm({
            name: props.vendor.name,
        })

        return { form }
    },
    props: ['vendor'],
    components: {
        Layout,
        Link,
    },
}
</script>
