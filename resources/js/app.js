import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'

createInertiaApp({
    resolve: name => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .mount(el)
    },
})

// Include CSS file
import 'halfmoon/css/halfmoon-variables.min.css'
/*
  Or,
  Include the following (no variables, supports IE11):
  require("halfmoon/css/halfmoon.min.css");
*/

// Import JS library
// const halfmoon = require('halfmoon')
