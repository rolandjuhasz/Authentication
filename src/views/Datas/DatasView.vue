<script setup>
import { usePhotosStore } from "@/stores/photo";
import { usePostsStore } from "@/stores/posts";
import { onMounted, ref } from "vue";
import { RouterLink } from "vue-router";

const { getAllPosts } = usePostsStore();
const posts = ref([]);
onMounted(async () => (posts.value = await getAllPosts()));


const { getAllPhotos, photos } = usePhotosStore();
onMounted(() => {
    getAllPhotos(); // Lekérjük az összes képet
  console.log(photos.value)
});
</script>

<template>
  <main>
    <h1 class="title bg-gradient-to-r from-green-400 via-blue-500 to-purple-600 text-white font-bold text-4xl p-4 rounded-lg shadow-lg">Eat healthy!</h1>
    <div class="grid grid-cols-3 gap-4">
        <div v-for="item in photos" :key="item.id" class="p-4">
            <img :src="`/storage/${item.file_path}`" alt="Kép" class="rounded-lg shadow-lg w-full h-auto">
        </div>
    </div>

  </main>
</template>