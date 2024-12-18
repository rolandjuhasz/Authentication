import { defineStore } from "pinia";

export const usePhotosStore = defineStore("photosStore", {
  state: () => ({
    photos: [], // Tárolja a képeket
    errors: {}, // Hibák tárolása
  }),
  actions: {
    async getAllPhotos() {
      try {
        const res = await fetch("/api/photos");
        const data = await res.json();
        this.photos = data; // Képek tárolása a Vue store-ban
      } catch (error) {
        this.errors = { fetch: "Hiba történt a képek lekérésekor." };
        console.error(error);
      }
    },
  },
});
