import { createApp } from 'vue'
import './style.css'
import App from './App.vue'
import router from './router'
import VueQueryPlugin, { queryClient } from './plugins/query'

const app = createApp(App)

// Register plugins
app.use(router)
app.use(VueQueryPlugin, { queryClient })

// Mount the app
app.mount('#app')
