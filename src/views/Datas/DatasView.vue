<script setup>
import { useImagesStore } from "@/stores/photo";
import { usePostsStore } from "@/stores/posts";
import { computed, onMounted, ref } from "vue";
import { RouterLink } from "vue-router";

const { getAllPosts } = usePostsStore();
const posts = ref([]);
onMounted(async () => (posts.value = await getAllPosts()));

const { getAllImages } = useImagesStore(); 
const images = ref([]);

onMounted(async () => {
  images.value = await getAllImages();
});

const selectedForm = ref(null)

// Szűrjük le a 'cardio' kategóriájú képeket
const filteredCardioImages = computed(() => {
  return images.value.filter(image => image.category === 'cardio');
});
</script>

<template>
  <main>
    <h1 class="title bg-gradient-to-r from-green-400 via-blue-500 to-purple-600 text-white font-bold text-4xl p-4 rounded-lg shadow-lg">Eat healthy!</h1>
    
    <div class="flex justify-between gap-8">
      <div class="flex flex-col items-center">
        <img :src="`http://localhost:8000/images/cardio.png`" alt="cardio" class="w-48 h-auto object-cover" />
        <button class="mt-5" @click="selectedForm = 'cardio'">Cardio</button>
      </div>
      
      <div class="flex flex-col items-center">
        <h1 v-if="selectedForm === null">Please choose a workout form</h1>
        
        <h1 v-if="selectedForm === 'cardio'">
  <label for="" class="text-center">Height</label>
  <input type="text">
  <label for="" class="text-center mt-5">Current Weight</label>
  <input type="text">
  <label for="" class="text-center mt-5">Expected weight</label>
  <input type="text">
  
  <div class="flex justify-center mt-5">
    <button class="bg-blue-500 text-white font-semibold py-1.5 px-2 rounded-lg shadow-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
      Calculating
    </button>
  </div>
</h1>
        <p v-if="selectedForm === 'crowding'">This is the crowding</p>
      </div>


      <div class="flex flex-col items-center">
        <img :src="`http://localhost:8000/images/crowding.png`" alt="crowding" class="w-48 h-auto object-cover" />
        <button class="mt-5" @click="selectedForm = 'crowding'">Crowding</button>
      </div>
    </div>
  </main>

 <!-- Képek megjelenítése, ha 'cardio' kategória van -->
 <div v-if="selectedForm === 'cardio' && filteredCardioImages.length > 0">
          <img 
            v-for="image in filteredCardioImages" 
            :key="image.id" 
            :src="`http://localhost:8000/images/${image.image_name}`" 
            :alt="image.category" 
            class="w-48 h-auto object-cover mt-5"
          />
        </div>

    <!-- Ha nincsenek cardio kategóriájú képek -->
    <p v-if="selectedForm === 'cardio' && filteredCardioImages.length === 0">
      No cardio images available.
    </p>
</template>
