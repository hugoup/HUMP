import { defineStore } from "pinia";

export const useMainStore = defineStore("main", {
  state: () => ({
    loading: false,
    events: [],
  }),
  actions: {
    addEvent(event) {
      const msg = event.payload.message;
      this.events.unshift(JSON.parse(msg));
    },
    clearEvents() {
      this.events = [];
    },
    removeEvent(i) {
      this.events.splice(i, 1);
    },
  },
});
