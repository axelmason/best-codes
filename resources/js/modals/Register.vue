<template>
    <button class="btn btn-white" @click="(modalOpen = !modalOpen)">Регистрация</button>
    <show-modal
    title="Регистрация"
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
                        name: 'Имя',
                    },
                    login: {
                        name: 'Логин',
                    },
                    email: {
                        name: 'Почта',
                    },
                    password: {
                        name: 'Пароль',
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
