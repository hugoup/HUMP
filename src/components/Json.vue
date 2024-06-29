<template>
	<VueJsonPretty 
				:show-line="false"
				:show-length="true"
				:show-icon="true"
				:virtual="false"
				:deep="2"
				theme="dark"
				:data="item"
				clasS="json"
			/>
</template>

<script>
import VueJsonPretty from 'vue-json-pretty';
import 'vue-json-pretty/lib/styles.css';
export default {
	name: 'Json',
	props: ['item'],
	components: {
		VueJsonPretty
	}
}
</script>


<style lang="scss">
.json {
	font-size: 10px;
	font-family: monospace;
}
</style>
