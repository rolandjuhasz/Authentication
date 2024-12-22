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


const filteredCardioImages = computed(() => {
  return images.value.filter(image => image.category === 'cardio');
});

const height = ref(""); // Magasság input
const weight = ref(""); // Súly input
const bmi = ref(null); // Kiszámított BMI

// BMI számítás funkció
const calculateBMI = () => {
  // Ellenőrzés, hogy a bemeneti értékek érvényesek-e
  if (height.value && weight.value) {
    const heightInMeters = parseFloat(height.value) / 100; // Átváltás méterre
    const weightInKg = parseFloat(weight.value); // Súly kg-ban
    bmi.value = weightInKg / (heightInMeters ** 2); // BMI számítása
  } else {
    bmi.value = null; // Ha nincsenek meg a bemeneti adatok
  }
};
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
          <label for="height" class="text-center">Height (in cm)</label>
          <input
            id="height"
            v-model="height"
            type="number"
            placeholder="Enter your height"
            class="mt-2 p-2 border border-gray-300 rounded"
          />
          <label for="weight" class="text-center mt-5">Current Weight (in kg)</label>
          <input
            id="weight"
            v-model="weight"
            type="number"
            placeholder="Enter your weight"
            class="mt-2 p-2 border border-gray-300 rounded"
          />
  <label for="" class="text-center mt-5">Expected weight</label>
  <input type="text">
  
  <div class="flex justify-center mt-5">
    <button class="bg-blue-500 text-white font-semibold py-1.5 px-2 rounded-lg shadow-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300" 
    @click="calculateBMI">
      Calculating
    </button>
    <div v-if="bmi !== null" class="mt-4 text-center">
            <p>Your BMI is: {{ bmi.toFixed(2) }}</p>
          </div>
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

  <div 
  v-if="selectedForm === 'cardio' && filteredCardioImages.length && bmi > 23" 
  class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mt-5"
>
  <div 
    v-for="image in filteredCardioImages" 
    :key="image.id" 
    class="bg-white rounded-lg shadow-md overflow-hidden transform transition duration-300 hover:scale-105"
  >
    <img 
      :src="`http://localhost:8000/images/foods/${image.image_name}`" 
      :alt="image.category" 
      class="w-32 h-32 object-cover mx-auto mt-4"
    />
    <div class="p-4">
      <h3 class="font-bold text-lg text-center text-gray-700">{{ image.image_name.slice(0, 5) }}</h3>
      <p class="text-gray-500 text-sm text-center">This food is recommended based on your BMI.</p>
    </div>
  </div>
</div>


    <p v-if="selectedForm === 'cardio' && filteredCardioImages.length === 0">
      No cardio images available.
    </p>
</template>
