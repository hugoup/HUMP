<template>
	<div class="events">
		<div class="event" v-for="event, idx in  store.events ">
			<div class="titlebar">
				<div class="title">{{ event.title }}</div>
				<div class="timestamp">{{ event.timestamp }}</div>

				<div class="type">{{ event.type }}</div>

				<div class="buttons">
					<i class="icon" @click="copyText(event.output)">📋</i>
					<i class="icon" @click="removeEvent(idx)">🗑️</i>
				</div>
			</div>

			<Json :item="event.output" class="output" v-if="event.output"></Json>

			<!-- <div class="html" v-html="event.html" v-if="event.html"></div> -->
			<HTMLOutput :html="event.html" v-if="event.html" :key="event"></HTMLOutput>

			<div class="trace">
				<div v-for="line in event.trace">{{ line }}</div>
			</div>

			<div class="extra">
				<div class="" v-for="item, name in  event.extra ">
					<details v-if="Object.keys(item).length">
						<summary>{{ name }} ({{ Object.keys(item).length }})</summary>
						<Json :item="item" class="item"/>
					</details>
				</div>
			</div>

		</div>
</div>


</template>

<script>

import { useMainStore } from "../store/main";
import HTMLOutput from "./HTMLOutput.vue";
import Json from "./Json.vue";
export default {
  name: 'Events',
  computed: {
    store: () => useMainStore(),
  },
  methods: {
    copyText(text) {
      navigator.clipboard.writeText(JSON.stringify(text));
    },
    removeEvent(idx) {
      this.store.removeEvent(idx)
    }
  }

}
</script>

<style lang="scss">
.events {
  display: block;
  max-height: calc(100vh - 90px);
  overflow-y: scroll;

  .event {
    margin: 0 20px;
    margin-bottom: 10px;
    border: 1px solid var(--background-dark);
    border-radius: 2px;
    display: grid;

    .titlebar {
      background-color: var(--background-light);
      padding: 5px;
      display: grid;
      grid-template-columns: auto 200px 60px 80px;
      align-items: center;

      .title {
        font-weight: bold;
        text-transform: uppercase;
      }

      .type {
        background-color: var(--accent);
        display: grid;
        place-items: center;
        border-radius: 10px;
        color: var(--background);
        font-size: 12px;
        font-weight: bold;
        padding: 5px;
      }

      .buttons {
        display: flex;
        margin-left: auto;

        i {
          padding: 0;
          margin: 0 5px;
          border: 0;
          cursor: pointer;
        }
      }
    }

    .output {
      padding: 5px;
    }

    .trace {
      font-size: 10px;
      line-height: 1.3;
      background-color: var(--background-dark);
      padding: 5px;
    }

    .extra {
      background-color: var(--background-light);
      padding: 5px;
      display: grid;
      gap: 10px;
      font-size: 12px;

      summary {
        cursor: pointer;
        font-weight: bold;
        text-transform: uppercase;
      }
    }
  }
}
</style>
