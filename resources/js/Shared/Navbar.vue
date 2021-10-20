<template>
    <nav class="navbar">
        <Link href="/" class="navbar-brand"> Budgeter </Link>
        <ul class="navbar-nav">
            <li class="nav-item" :class="{ active: path === '/categories' }">
                <Link href="/categories" class="nav-link">Categories</Link>
            </li>
        </ul>
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
