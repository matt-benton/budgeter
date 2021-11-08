<template>
    <nav class="navbar">
        <Link href="/" class="navbar-brand"> Budgeter </Link>
        <ul class="navbar-nav">
            <li class="nav-item" :class="{ active: path === '/categories' }">
                <Link href="/categories" class="nav-link">Categories</Link>
            </li>
            <li class="nav-item" :class="{ active: path === '/budgets' }">
                <Link href="/budgets" class="nav-link">Budgets</Link>
            </li>
        </ul>
        <Link href="/expenses/create" class="btn btn-primary ml-auto">Add Expenses</Link>
    </nav>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3'

export default {
    computed: {
        path() {
            return window.location.pathname
        },
    },
    components: {
        Link,
    },
}
</script>
