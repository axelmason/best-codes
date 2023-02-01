<template>
    <button class="btn btn-white" @click="(modalOpen = !modalOpen)">Register</button>
    <show-modal
    title="Register"
    :show="modalOpen"
    :fields="fields"
    :errors="errors"
    @close="modalOpen = !modalOpen"
    @onSubmit="submit"
    ></show-modal>
</template>

<script>
import Modal from '../elements/Modal.vue';

    export default {
        components: { Modal },
        data() {
            return {
                modalOpen: false,
                fields: {
                    name: {
                        name: 'Name',
                    },
                    login: {
                        name: 'Login',
                    },
                    email: {
                        name: 'Email',
                    },
                    password: {
                        name: 'Password',
                    },
                },
                errors: {}
            }
        },
        props: {
            route: {}
        },
        methods: {
            submit(data) {
                this.errors = {}

                window.axios.post('/users/register', data)
                .then(() => { location.reload() })
                .catch((e) => {
                    this.errors = e.response.data.errors
                })
            }
        }
    }
</script>

<style scoped>

</style>
