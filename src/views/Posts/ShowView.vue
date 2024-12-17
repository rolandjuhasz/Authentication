<script setup>
import { usePostStore } from '@/stores/posts';
import { onMounted, ref } from 'vue';
import { useRoute } from 'vue-router';

const route = useRoute()
const {getPost} = usePostStore();
const post = ref(null);

onMounted(async () => (post.value = await getPost(route.params.id)));

</script>

<template>
<main>
    <div v-if="post">
      <div class="border-l-4 border-blue-500 pl-5 mt-12">
        <h2 class="font-bold text-3xl">{{ post.title }}</h2>
        <p class="text-xs text-slate-600 mb-4">Posted by {{ post.user.name }}</p>
        <p>{{ post.body }}</p>
      </div>
    </div>

    <div v-else>
      <h2>The post doesn't exists</h2>
    </div>
</main>

</template>