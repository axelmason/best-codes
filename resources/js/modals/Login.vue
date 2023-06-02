<template>
    <button class="btn btn-white" @click="(modalOpen = !modalOpen)">Войти</button>
    <show-modal
    title="Логин"
    promotion
    :show="modalOpen"
    :fields="fields"
    :errors="errors"
    button-text="Войти"
    @close="modalOpen = !modalOpen"
    @onSubmit="submit"
    >
        <template v-slot:extra>
        <div class="flex flex-col">
            <span>Забыли пароль? <a href="" class="text-primary">Восстановить</a></span>
            <span>Ещё не зарегистрированны? <a href="" class="text-primary">Регистрация</a></span>
        </div>
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
