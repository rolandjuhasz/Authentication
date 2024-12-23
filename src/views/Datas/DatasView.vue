<script setup>
import { useAuthStore } from "@/stores/auth";
import { useImagesStore } from "@/stores/photo";
import { usePostsStore } from "@/stores/posts";
import { computed, onMounted, ref } from "vue";
import { RouterLink } from "vue-router";

const authStore = useAuthStore();

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
  return images.value.filter(image => image.category === 'cardio' || image.category === 'crow');
});

const height = ref("");
const weight = ref(""); 
const bmi = ref(null); 
const errorMessage = ref(""); 


const calculateBMI = () => {
  if (height.value && weight.value) {
    const heightInMeters = parseFloat(height.value) / 100;
    const weightInKg = parseFloat(weight.value);
    bmi.value = weightInKg / (heightInMeters ** 2);
  } else {
    bmi.value = null;
    errorMessage.value = "Please enter a valid number"
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
        <h1 v-if="!authStore.user">Please log in!</h1>
        <h1 v-else-if="authStore.user && selectedForm === null">Please choose a workout form!</h1>
        
        <h1 v-if="selectedForm === 'cardio' && authStore.user">
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
  </div>
    <div v-if="bmi !== null" class="mt-4 text-center">
            <p>Your BMI is: {{ bmi.toFixed(2) }}</p>
          </div>
          <div v-else class="mt-4 text-center">
            <p class=" text-red-500 font-bold">{{ errorMessage}}</p>
          </div>
</h1>

        <p v-if="selectedForm === 'crowding' && authStore.user">This is the crowding</p>
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
    class="bg-green-200 rounded-lg shadow-md overflow-hidden transform transition duration-300 hover:scale-105"
  >
    <img 
      :src="`http://localhost:8000/images/foods/${image.image_name}`" 
      :alt="image.category" 
      class="w-32 h-32 object-cover mx-auto mt-4"
    />
    <div class="flex">
      <div class="p-4 justify-center">
        <h4 class=" text-lg text-center text-gray-700">{{ image.food_info }}</h4>
        <p class="text-gray-500 text-sm text-center">({{ image.calories }})</p>
      </div>
    </div>
  </div>
</div>


    <p v-if="selectedForm === 'cardio' && !filteredCardioImages.length">
      No cardio images available.
    </p>
</template>
