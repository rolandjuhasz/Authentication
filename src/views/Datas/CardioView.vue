<script setup>
import { useAuthStore } from "@/stores/auth";
import { useImagesStore } from "@/stores/photo";
import { usePostsStore } from "@/stores/posts";
import { computed, onMounted, ref } from "vue";

const authStore = useAuthStore();

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
</template>