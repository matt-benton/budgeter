<template>
    <Layout>
        <h2>Edit Expense</h2>
        <div class="card">
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
    </Layout>
</template>

<script>
import Layout from '../../Shared/Layout.vue'
import { useForm } from '@inertiajs/inertia-vue3'

export default {
    data() {
        return {
            deleteConfirm: '',
        }
    },
    setup() {
        const deleteForm = useForm()

        return { deleteForm }
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
    },
    props: ['expense', 'categories'],
}
</script>
