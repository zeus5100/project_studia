import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createNotivue } from 'notivue'
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import 'notivue/notification.css';
import 'notivue/animations.css';
import 'notivue/notification-progress.css';
const notivue = createNotivue({
    limit: 1,
    enqueue: true,
    avoidDuplicates: true,
    notifications: {
        global: {
            duration: 4000
        }
    }
})
const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(notivue)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});

