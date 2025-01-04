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
const expectedWeight = ref(""); 
const bmi = ref(null); 
const errorMessage = ref(""); 

const age = ref(null); 
const gender = ref(null);
const activityLevel = ref(1.2);
const calories = ref(null); 

const calculateBmr = () => {
  if(height.value > 0 || weight.value > 0 || age.value > 0) {
    
  let BMR = null;
  if(gender.value === 'male') {
    BMR = (10 * weight.value) + (6.25 * height.value) - (5 * age.value) + 5
  } else if(gender.value === 'female') {
    BMR = (10 * weight.value) + (6.25 * height.value) - (5 * age.value) - 161
  } else {
    errorMessage.value = "Please select a valid gender!";
    return
  }
  const TDEE = BMR * activityLevel.value;

  calories.value = {
    BMR: BMR.toFixed(1),
    TDEE: TDEE.toFixed(1),
    caloriesToLose: (TDEE - 500).toFixed(1)
  }
  errorMessage.value = ""
} else {
  errorMessage.value = "All fields are required"
  }
}

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
          <label for="height" class="text-center">Height (in cm)</label>
          <input
            id="height"
            v-model.number="height"
            type="number"
            placeholder="Enter your height"
            class="mt-2 p-2 border border-gray-300 rounded w-full"
          />

          <label for="weight" class="text-center mt-5">Current Weight (in kg)</label>
          <input
            id="weight"
            v-model.number="weight"
            type="number"
            placeholder="Enter your weight"
            class="mt-2 p-2 border border-gray-300 rounded w-full"
          />

          <label for="expectedWeight" class="text-center mt-5">Expected Weight</label>
          <input
            id="expectedWeight"
            v-model.number="expectedWeight"
            type="number"
            placeholder="Enter your expected weight"
            class="mt-2 p-2 border border-gray-300 rounded w-full"
          />

          <label for="age" class="text-center mt-5">Age</label>
          <input
            id="age"
            v-model.number="age"
            type="number"
            placeholder="Enter your age"
            class="mt-2 p-2 border border-gray-300 rounded w-full"
          />

          <label for="gender" class="text-center mt-5">Gender</label>
          <select
            id="gender"
            v-model="gender"
            class="mt-2 p-2 border border-gray-300 rounded w-full"
          >
            <option value="" disabled>Select gender</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
          </select>

          <label for="activityLevel" class="text-center mt-5">Activity Level</label>
          <select
            id="activityLevel"
            v-model="activityLevel"
            class="mt-2 p-2 border border-gray-300 rounded w-full"
          >
            <option value="1.2">Sedentary (little to no exercise)</option>
            <option value="1.375">Light Activity (light exercise/sports 1-3 days/week)</option>
            <option value="1.55">Moderate Activity (moderate exercise/sports 3-5 days/week)</option>
            <option value="1.725">Very Active (hard exercise/sports 6-7 days a week)</option>
            <option value="1.9">Extremely Active (very hard exercise/physical job)</option>
          </select>

          <div class="flex justify-center mt-5">
            <button
              class="bg-green-500 text-white font-semibold py-1.5 px-2 rounded-lg shadow-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300 ml-4"
              @click="calculateBmr"
            >
              Calculate BMR
            </button>
          </div>

          <div v-if="calories" class="text-center mt-10">
      <p>BMR: {{ calories.BMR }} kcal/day</p>
      <p>TDEE: {{ calories.TDEE }} kcal/day</p>
      <p>Calories to lose weight: {{ calories.caloriesToLose }} kcal/day</p>
      <p>Calories to gain weight: {{ calories.caloriesToGain }} kcal/day</p>
    </div>

          <div v-if="errorMessage" class="mt-4 text-center">
            <p class="text-red-500 font-bold">{{ errorMessage }}</p>
          </div>
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
