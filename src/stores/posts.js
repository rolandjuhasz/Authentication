import { defineStore } from "pinia";

export const usePostStore = defineStore('postStore', {
    state: () => {
        return {
            errors: {}
        }
    },
    actions: {
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
                console.log(data)
            }
        }
    }
})