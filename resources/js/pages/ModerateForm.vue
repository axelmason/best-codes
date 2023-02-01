<template>
    <div class="container lg:px-[25%]">
        <div class="box mt-3 p-4">
            <div class="flex items-center">
                <div @click="goBack()" class="cursor-pointer"><i class="las la-angle-double-left"></i>Назад</div>
                <h1 class="grow justify-self-end">Модерация кода {{ code.code }}</h1>
            </div>
            <alert :title="'Статус - '+code.moderate_status" :child-class="{
                'bg-fuchsia-100': code.moderate_status === 'new',
                'bg-orange-100': code.moderate_status === 'in_work',
                'bg-green-100': code.moderate_status === 'accepted',
                'bg-red-100': code.moderate_status === 'rejected',
            }" :text="code.moderate_message ? 'Причина: '+code.moderate_message : null"></alert>
            <form action="" class="moderate-form">
                <div class="form-group required">
                    <label for="">Код</label>
                    <input type="text" v-model="code.code" :disabled="!getStatus('in_work')">
                    <div class="error-message" v-for="error in errors.code">{{ error }}</div>
                </div>
                <div class="form-group required">
                    <label for="">Заголовок</label>
                    <input type="text" v-model="code.title" :disabled="!getStatus('in_work')">
                    <div class="error-message" v-for="error in errors.title">{{ error }}</div>
                </div>
                <div class="form-group required">
                    <label for="">Описание</label>
                    <textarea rows="5" type="text" v-model="code.description"
                              :disabled="!getStatus('in_work')"></textarea>
                    <div class="error-message" v-for="error in errors.description">{{ error }}</div>
                </div>
                <div class="form-group required">
                    <label for="">Ссылка</label>
                    <input type="text" v-model="code.activate_url" :disabled="!getStatus('in_work')">
                    <div class="error-message" v-for="error in errors.activate_url">{{ error }}</div>
                </div>
            </form>
            <button v-if="getStatus('in_work')" @click="submit(code.id)">Отправить</button>
            <button v-if="getStatus('in_work')" @click="showModal = !showModal">Отклонить</button>
            <button v-if="getStatus('new')" class="btn" @click="startEdit(codeProp.id)">Править</button>
            <div v-if="getStatus('accepted', true) || getStatus('rejected', true)">Чтобы изменить данный код, обратитесь
                к администратору.
            </div>
        </div>
    </div>
    <show-modal
        :title="'Причина отклонения заявки'"
        :fields="fields"
        :show="showModal"
        @close="showModal = !showModal"
        @onSubmit="rejectEdit"
    ></show-modal>
</template>

<script>
export default {
    data() {
        return {
            code: {
                code: "",
                title: "",
                description: "",
                activate_url: "",
            },
            fields: {
                moderate_message: {
                    name: 'Причина'
                }
            },
            showModal: false,
            editAllow: false,
            errors: {
                code: "",
                title: "",
                description: "",
                activate_url: "",
            }
        };
    },
    props: {
        codeProp: {
            type: Object,
            required: true
        }
    },
    methods: {
        submit(code_id) {
            window.axios.put(`/codes/${code_id}`, this.code)
                .then(() => this.acceptEdit(code_id))
                .catch((e) => this.errors = e.response.data.errors)
        },
        startEdit(code_id) {
            window.axios.put(`/moderate/${code_id}/edit`, {
                moderate_status: 'in_work'
            })
                .then(() => {
                    this.$store.dispatch('sendNotification', {
                        user_id: this.code.user_id,
                        code: this.code,
                        reason: 'status'
                    })
                }).then(() => location.reload());
        },
        acceptEdit(code_id) {
            window.axios.put(`/moderate/${code_id}/edit`, {
                moderate_status: 'accepted'
            })
                .then(() => {
                    this.$store.dispatch('sendNotification', {
                        user_id: this.code.user_id,
                        code: this.code,
                        reason: 'accept'
                    }).then(() => location.href = '/moderate')
                });
        },
        rejectEdit(data) {
            window.axios.put(`/moderate/${this.code.id}/edit`, {
                moderate_status: 'rejected',
                moderate_message: data.moderate_message
            })
                .then(() => {
                    this.$store.dispatch('sendNotification', {
                        user_id: this.code.user_id,
                        code: this.code,
                        text: data.moderate_message,
                        reason: 'reject'
                    }).then(() => location.href = '/moderate')
                });
        },
        goBack() {
            location.href = '/moderate'
        },
        getStatus(need) {
            return this.codeProp.moderate_status === need
        }
    },
    mounted() {
        this.code = JSON.parse(JSON.stringify(this.codeProp));
    }
}
</script>

<style scoped lang="scss">
h1 {
    text-align: center;
    font-weight: 600;
    font-size: 24px;
}

.moderate-form {
    width: 100%;
}
</style>
