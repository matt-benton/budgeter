<template>
    <div class="page-wrapper with-navbar">
        <Navbar />
        <div class="content-wrapper">
            <div class="container">
                <slot></slot>
            </div>
        </div>
    </div>
</template>

<script>
import Navbar from './Navbar.vue'

export default {
    components: {
        Navbar,
    },
}
</script>
