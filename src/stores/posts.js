import { defineStore } from "pinia";

export const usePostStore = defineStore('postStore', {
    state: () => {
        return {
            errors: {}
        }
    },
    actions: {
/*********get all POST*********/
async getAllPost() {
    const res = await fetch('/api/posts')
    const data = await res.json()
    console.log(data)
    return data;
},

/*********get post*********/
async getPost(post) {
    const res = await fetch(`/api/posts/${post}`)
    const data = await res.json()
    console.log(data)
    return data.post
},

        /*********CREATE A POST*********/
        async createPost(formData) {
            const res = await fetch('/api/posts/', {
                method: 'post',
                headers: {
                    Authorization: `Bearer ${localStorage.getItem('token')}`,
                },
                body: JSON.stringify(formData),
            });

            const data = await res.json();
            
            if(data.errors) {
                this.errors = data.errors;
            } else {
                this.router.push({name: 'home'})
            }
        }
    }
})