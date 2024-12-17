<script setup>
import { usePostStore } from '@/stores/posts';
import { onMounted, ref } from 'vue';
import { RouterLink } from 'vue-router';


const {getAllPost} = usePostStore()

const posts = ref([])

onMounted(async() => posts.value = await getAllPost());

</script>

<template>
  <main>
    <h1 class="title">Latest Post</h1>

    <div v-if="posts.length > 0">
      <div v-for="item in posts" :key="item.id" class="border-l-4 border-blue-500 pl-5 mb-12">
        <h2 class="font-bold text-3xl">{{ item.title }}</h2>
        <p class="text-xs text-slate-600 mb-4">Posted by {{ item.user.name }}</p>
        <p>{{ item.body }}</p>
        <RouterLink :to="{name: 'show', params: {id: item.id}}" class="text-blue-500 font-bold underline">Read more...</RouterLink>
      </div>
    </div>

    <div v-else>
      <h2 class="title">There are no post</h2>
    </div>
  </main>
</template>
