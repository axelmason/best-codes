<template>
    <button class="btn btn-white" @click="(modalOpen = !modalOpen)">Войти</button>
    <show-modal
    title="Логин"
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
                    email: {
                        name: 'Почта',
                        required: true
                    },
                    password: {
                        name: 'Пароль',
                        required: true
                    },
                },
                errors: {}
            }
        },
        props: {

        },
        methods: {
            submit(data) {
                this.errors = {}

                window.axios.post('/users/login', data)
                .then(() => {
                    location.reload();
                })
                .catch((e) => {
                    this.errors = e.response.data.errors
                })
            }
        }
    }
</script>

<style scoped>

</style>
