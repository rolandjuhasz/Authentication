<script setup>
import { useAuthStore } from "@/stores/auth";
import { useImagesStore } from "@/stores/photo";
import { usePostsStore } from "@/stores/posts";
import { computed, onMounted, ref } from "vue";
import { RouterLink } from "vue-router";
import CardioView from "./CardioView.vue";

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

</script>

<template>
  <main>
    <h1 class="title bg-gradient-to-r from-green-400 via-blue-500 to-purple-600 text-white font-bold text-4xl p-4 rounded-lg shadow-lg">
      Eat healthy!
    </h1>

    <div class="flex justify-between gap-8">

      <div class="flex flex-col items-center">
        <!-- <img
          src="http://localhost:8000/images/cardio.png"
          alt="cardio"
          class="w-48 h-auto object-cover"
        /> -->
        <button
          class="mt-5 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
          :class="{ 'cursor-not-allowed opacity-50': !authStore.user }"
          :disabled="!authStore.user"
          @click="selectedForm = 'cardio'"
        >
          Cardio
        </button>
      </div>


       <div class="flex flex-col items-center">
        <h1 v-if="!authStore.user">Please log in!</h1>
        <h1 v-else-if="!selectedForm">Please choose a workout form!</h1>

        <div v-if="authStore.user && selectedForm === 'cardio'" class="w-full max-w-md p-4">
          <CardioView />
        </div>


        <p v-if="selectedForm === 'crowding'">SOON</p>
      </div>


      <div class="flex flex-col items-center">
        <!-- <img
          src="http://localhost:8000/images/crowding.png"
          alt="crowding"
          class="w-48 h-auto object-cover"
        /> -->
        <button
          class="mt-5 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
          :class="{ 'cursor-not-allowed opacity-50': !authStore.user }"
          :disabled="!authStore.user"
          @click="selectedForm = 'crowding'"
        >
          Crowding
        </button>
      </div>
    </div>


    <div
      v-if="selectedForm === 'cardio' && filteredCardioImages.length> 23"
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
        <div class="p-4 text-center">
          <h4 class="text-lg text-gray-700">{{ image.food_info }}</h4>
          <p class="text-gray-500 text-sm">({{ image.calories }})</p>
        </div>
      </div>
    </div>

    <p v-if="selectedForm === 'cardio' && !filteredCardioImages.length" class="mt-4 text-center">
      No cardio images available.
    </p>
  </main>
</template>
