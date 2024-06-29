<template>
  <div class="container">
	    <Navbar :toggleTheme :theme="theme"/>
			<Events v-if="store.events.length"/>
			<InfoBox v-else/>
  </div>
</template>


<script>
import Navbar from "./components/Navbar.vue";
import Events from "./components/Events.vue";
import InfoBox from "./components/InfoBox.vue";

import { useMainStore } from "./store/main";
import { emit, listen } from '@tauri-apps/api/event'

export default {
	computed: {
		store: () => useMainStore(),
	},
	data() {
		return {
			root: null,
			theme: 'light',
			themes: {
				light: {
					/* Background Colors */
					"background": "#f5f5f5",
					"background-light": "#ffffff",
					"background-dark": "#e0e0e0",
					/* Text Colors */
					"text": "#333333",
					"text-muted": "#666666",
					"text-accent": "#007bff",
					"text-selection": "#007bff",
					/* UI Colors */
					"primary": "#007bff",
					"secondary": "#6c757d",
					"accent": "#ffc107",
					"border": "#ced4da",
				},
				dark: {
					/* Background Colors */
					"background": "#181825",
					"background-light": "#1e1e2e",
					"background-dark": "#11111b",
					/* Text Colors */
					"text": "#dcd3c1",
					"text-muted": "#9e8b7b",
					"text-accent": "#b18e60",
					"text-selection": "#b18e60",
					/* UI Colors */
					"primary": "#b18e60",
					"secondary": "#7eb0fa",
					"accent": "#ffcc66",
					"border": "#cba6f7",
				}
			}
		}
	},
	created() {
		this.theme = localStorage.getItem('theme') || 'light';

		listen('post', (event) => {
			console.log('Received post event:', event);
			this.store.addEvent(event);
		})

		listen('settings', (event) => {
			console.log('Received settings event:', event);
		})
	},
	mounted() {
		this.root = document.documentElement;
		this.loadTheme();
	},
	methods: {
		loadTheme() {
			Object.keys(this.themes[this.theme]).forEach(key => {
				const val = this.themes[this.theme][key];
				this.root.style.setProperty(`--${key}`, val);
			});
		},
		toggleTheme() {
			localStorage.setItem('theme', this.theme == 'light' ? 'dark' : 'light');
			this.theme = this.theme == 'light' ? 'dark' : 'light';
			this.loadTheme();
		}
	}
};
</script>



<style lang="scss">
body,
#app {
	height: 100vh;
	width: 100%;
	margin: 0;
	padding: 0;
	overflow: hidden;
	background-color: var(--background);
	color: var(--text);
	font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

input,
button {
	border-radius: 2px;
	border: 1px solid transparent;
	padding: 0.6em 0.6em;
	font-size: 14px;

	box-shadow: 0 2px 2px rgba(0, 0, 0, 0.2);
	background-color: var(--background);
	color: var(--text);
}

/* input checkbox */
input[type="checkbox"] {
	width: 20px;
	height: 20px;
	margin: 0;
	padding: 0;
	border: 1px solid var(--border);
	background-color: var(--background);
	color: var(--text);
}

.primary {
	background-color: var(--primary);
	color: var(--background);
}

button:hover,
button:active {
	border-color: var(--border);
}

input,
button {
	outline: none;
}

.container {
	display: grid;
	grid-template-rows: 70px auto;
	gap: 10px;
	min-height: 98vh;
}
</style>
