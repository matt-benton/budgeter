<template>
    <Layout>
        <div class="content">
            <nav>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><Link href="/categories">Categories</Link></li>
                    <li class="breadcrumb-item">
                        <Link :href="`/categories/${category.id}`">{{ category.name }}</Link>
                    </li>
                    <li class="breadcrumb-item active">Edit</li>
                </ul>
            </nav>
            <div class="w-600 m-auto">
                <h1>Edit Category</h1>
                <div class="card">
                    <form @submit.prevent="form.put(`/categories/${category.id}`)">
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

                        <input class="btn btn-primary" type="submit" value="Update Category" />
                    </form>
                </div>
            </div>
        </div>
    </Layout>
</template>

<script>
import Layout from '../../Shared/Layout.vue'
import { useForm, Link } from '@inertiajs/vue3'

export default {
    setup(props) {
        const form = useForm({
            name: props.category.name,
        })

        return { form }
    },
    props: ['category'],
    components: {
        Layout,
        Link,
    },
}
</script>
