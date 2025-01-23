<script setup>
import { usePostsStore } from "@/stores/posts";
import { useAuthStore } from "@/stores/auth";
import { onMounted, ref } from "vue";

const { getAllPosts } = usePostsStore();
const authStore = useAuthStore();
const userPosts = ref([]);

onMounted(async () => {
  const allPosts = await getAllPosts();
  userPosts.value = allPosts.filter(
    (post) => post.user_id === authStore.user.id
  );
});
</script>

<template>
  <main>
    <h1 class="title">My Posts</h1>

    <div v-if="userPosts.length > 0">
      <div
        v-for="post in userPosts"
        :key="post.id"
        class="border-l-4 border-blue-500 pl-4 mb-12"
      >
        <h2 class="font-bold text-3xl">{{ post.title }}</h2>
        <p class="text-xs text-slate-600 mb-4">
          Posted by You
        </p>
        <p>
          {{ post.body }}
        </p>
      </div>
    </div>
    <div v-else>
      <h2 class="title">You haven't posted anything yet!</h2>
    </div>
  </main>
</template>
