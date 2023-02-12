import { defineStore } from "pinia";

export const useIndexStore = defineStore("index", {
  state: () => ({
    loading: false,
  }),
  getters: {
    isLoading(state) {
      return !!state.loading;
    },
  },
  actions: {
    setLoading(loading = true) {
      this.loading = loading;
    },
  },
});
