require('./bootstrap');

import {InertiaApp} from '@inertiajs/inertia-vue';
import { Inertia } from '@inertiajs/inertia';
import Vue from 'vue';
import VueSweetalert2 from 'vue-sweetalert2';
import NProgress from 'nprogress';
import { InertiaProgress } from '@inertiajs/progress'

Vue.use(InertiaApp)
Vue.use(VueSweetalert2);

const app = document.getElementById('app')
InertiaProgress.init({
    // The delay after which the progress bar will
    // appear during navigation, in milliseconds.
    delay: 250,
  
    // The color of the progress bar.
    color: '#29d',
  
    // Whether to include the default NProgress styles.
    includeCSS: true,
  
    // Whether the NProgress spinner will be shown.
    showSpinner: true,
  })
Inertia.on('start', () => NProgress.start());
Inertia.on('finish', () => NProgress.done());

new Vue({
    render: h => h(InertiaApp, {
        props: {
            initialPage: JSON.parse(app.dataset.page),
            resolveComponent: name => require(`./Pages/${name}`).default,
        },
    }),
}).$mount(app)
