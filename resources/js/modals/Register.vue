<template>
    <button class="btn btn-white" @click="(modalOpen = !modalOpen)">Регистрация</button>
    <show-modal
    title="Регистрация"
    promotion
    :show="modalOpen"
    :fields="fields"
    :errors="errors"
    button-text="Зарегистрироваться"
    @close="modalOpen = !modalOpen"
    @onSubmit="submit"
    >
        <template v-slot:extra>
            <span>Уже зарегистрированны? <a href="" class="text-primary">Войти</a></span>
        </template>
    </show-modal>
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
                        type: 'text',
                        required: true
                    },
                    login: {
                        name: 'Логин',
                        type: 'text',
                        required: true
                    },
                    email: {
                        name: 'Почта',
                        type: 'email',
                        required: true
                    },
                    password: {
                        name: 'Пароль',
                        type: 'password',
                        required: true
                    },
                    password_confirmation: {
                        name: 'Подтвердить пароль',
                        type: 'password',
                        required: true
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
