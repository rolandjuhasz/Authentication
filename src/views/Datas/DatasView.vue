<script setup>
import { useImagesStore } from "@/stores/photo";
import { usePostsStore } from "@/stores/posts";
import { onMounted, ref } from "vue";
import { RouterLink } from "vue-router";

const { getAllPosts } = usePostsStore();
const posts = ref([]);
onMounted(async () => (posts.value = await getAllPosts()));

const { getAllImages } = useImagesStore();  // A store metódus elérése
const images = ref([]);  // Ref a képek tárolására

onMounted(async () => {
  images.value = await getAllImages();  // Képek betöltése az API-ból
});



</script>

<template>
  <main>
    <h1 class="title bg-gradient-to-r from-green-400 via-blue-500 to-purple-600 text-white font-bold text-4xl p-4 rounded-lg shadow-lg">Eat healthy!</h1>
    <div class="flex justify-center gap-8">
  <div>
    <img :src="`http://localhost:8000/images/cardio.png`" alt="cardio" class="w-48 h-auto object-cover" />
  </div>
  <div>
    <img :src="`http://localhost:8000/images/crowding.png`" alt="crowding" class="w-48 h-auto object-cover" />
  </div>
</div>

  </main>
</template>
