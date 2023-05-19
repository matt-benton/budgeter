require('./bootstrap')

import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'

createInertiaApp({
    resolve: name => require(`./Pages/${name}`),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .mount(el)
    },
})

// Include CSS file
require('halfmoon/css/halfmoon-variables.min.css')
/*
  Or,
  Include the following (no variables, supports IE11):
  require("halfmoon/css/halfmoon.min.css");
*/

// Import JS library
const halfmoon = require('halfmoon')
