<script>
import Hump from './Hump.vue'
import { useMainStore } from "../store/main";
import { emit, listen } from '@tauri-apps/api/event'
export default {
	name: "Navbar",
	props: {
		toggleTheme: {
			type: Function,
			required: false,
		},
		theme: {
			type: String,
			required: false,
		},
	},
	computed: {
		store: () => useMainStore(),
	},
};
</script>

<template>
  <div class="navbar">
		<h1><Hump/></h1>
		<div class="buttons">
			<div v-if="store.loading" class="loading">Loading...</div>
			<button @click="toggleTheme">Theme: {{ theme }}</button>
			<button @click="store.clearEvents()">Clear</button>
		</div>
  </div>
</template>

<style lang="scss">
.navbar {
	display: grid;
	grid-template-columns: 1fr 1fr;
	gap: 10px;
	background-color: var(--background-light);
	padding: 10px 20px;
	align-items: center;

	h1 {
		margin: 0;
		font-size: 40px;
	}

	.buttons {
		margin-left: auto;
		display: grid;
		grid-template-columns: 1fr 1fr;
		gap: 10px;
	}
}
</style>
