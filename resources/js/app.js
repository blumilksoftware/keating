import { createInertiaApp, Head, Link } from '@inertiajs/inertia-vue3'
import { createApp, h } from 'vue'
import { autoAnimatePlugin } from '@formkit/auto-animate/vue'
import Toast from 'vue-toastification'
import '../css/app.css'

const pageTitle = document.getElementsByName('title')[0].content ?? 'Keating'

createInertiaApp({
  progress: {
    delay: 50,
    color: '#14b8a6',
  },
  title: function(title) {
    return title && title !== '/' ? `${title} - ${pageTitle}` : pageTitle
  },
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
