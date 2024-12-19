import { defineStore } from "pinia";

export const useImagesStore = defineStore("imagesStore", {
  state: () => ({
    errors: {},
  }),
  actions: {
    async getAllImages() {
      const res = await fetch("/api/images");
      const data = await res.json();

      return data; // Az API által visszaadott képadatok
    },
  },
});
