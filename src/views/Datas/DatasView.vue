<script setup>
import { useImagesStore } from "@/stores/photo";
import { usePostsStore } from "@/stores/posts";
import { onMounted, ref } from "vue";
import { RouterLink } from "vue-router";

const { getAllPosts } = usePostsStore();
const posts = ref([]);
onMounted(async () => (posts.value = await getAllPosts()));

const { getAllImages } = useImagesStore(); // A photo store getAllImages metódusának elérése
const images = ref([]); // Ref a képek tárolására

onMounted(async () => {
  images.value = await getAllImages(); // Képek betöltése a Pinia store-ból
});

</script>

<template>
  <main>
    <h1 class="title bg-gradient-to-r from-green-400 via-blue-500 to-purple-600 text-white font-bold text-4xl p-4 rounded-lg shadow-lg">Eat healthy!</h1>
    <div class="grid grid-cols-3 gap-4">
        <div v-for="image in images" :key="image.id">
            <img :src="`/images/${image.image1}.png`" alt="Image" />

    </div>
 </div>

  </main>
</template>