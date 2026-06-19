import { createApp } from 'vue'
import App from './App.vue'

const el = document.getElementById('admin')
if (el) {
	const app = createApp(App)
	app.mount(el)
}
