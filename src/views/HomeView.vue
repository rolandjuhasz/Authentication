<script setup>
import { usePostsStore } from "@/stores/posts";
import { onMounted, ref } from "vue";
import { RouterLink } from "vue-router";

const { getAllPosts } = usePostsStore();
const posts = ref([]);

onMounted(async () => {
  const allPosts = await getAllPosts();
  
  posts.value = allPosts.sort((a, b) => {
    if (a.user.admin && !b.user.admin) return -1;
    if (!a.user.admin && b.user.admin) return 1;
    return 0;
  });
});


</script>

<template>
  <main>
    <h1 class="title">Latest Posts</h1>

    <div v-if="posts.length > 0">
      <div
        v-for="post in posts"
        :key="post.id"
        :class="{'border-l-4 border-red-800' : post.user.admin, 'border-l-4 border-blue-500 pl-4 mb-12' : post.user}"
      >
        <h2 class="font-bold text-3xl">
          <span v-if="post.user.admin">
            <i class="fa-solid fa-thumbtack text-yellow-600"></i>
          </span>
          {{ post.title }}
          </h2>
        <p class="text-xs text-slate-600 mb-4">
          Posted by  <span :class="{'text-red-800 font-bold' : post.user.admin}">{{ post.user.admin ? 'Admin' : post.user.name }} </span> 
          <br>
        </p>
        <p>
          {{ post.body }}
          <RouterLink
            :to="{ name: 'show', params: { id: post.id } }"
            class="text-blue-500 font-bold underline"
            >Read more...</RouterLink
          >
        </p>
      </div>
    </div>
    <div v-else>
      <h2 class="title">There are no posts</h2>
    </div>
  </main>
</template>