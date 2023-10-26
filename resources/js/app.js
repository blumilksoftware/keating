import { createInertiaApp, Head, Link } from '@inertiajs/inertia-vue3'
import { createApp, h } from 'vue'
import { autoAnimatePlugin } from '@formkit/auto-animate/vue'
import Toast from 'vue-toastification'
import '../css/app.css'

createInertiaApp({
  progress: {
    delay: 50,
    color: '#14b8a6',
  },
  title: (title) => title ? `${title} - Keating` : 'Keating',
  resolve: name => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })

    return pages[`./Pages/${name}.vue`]
  },
  setup({ el, App, props, plugin }) {
    return createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(autoAnimatePlugin)
      .use(Toast, {
        position: 'top-right',
        maxToast: 5,
        timeout: 3000,
        pauseOnFocusLoss: false,
      })
      .component('InertiaLink', Link)
      .component('InertiaHead', Head)
      .mount(el)
  },
})
