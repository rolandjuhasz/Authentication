<script setup>
import { usePostStore } from '@/stores/posts';
import { storeToRefs } from 'pinia';
import { reactive } from 'vue';

const formdata = reactive({
    title: '',
    body: ''
});

const {errors} = storeToRefs(usePostStore())
const {createPost} = usePostStore()
</script>

<template>
    <main class="title">
        <h1>Create a new post</h1>

        <form @submit.prevent="createPost(formdata)" class="w-1/2 mx-auto space-y-6">

            <div>
                <input type="text" placeholder="Post Title" v-model="formdata.title">
                <p v-if="errors.title" class="error">{{ errors.title[0] }}</p>
            </div>

            <div>
                <textarea rows="6" placeholder="Post Content" v-model="formdata.body"></textarea>
                <p v-if="errors.body" class="error">{{ errors.title[0] }}</p>
            </div>

            <button class="primary-btn">Create</button>

        </form>
    </main>
</template>