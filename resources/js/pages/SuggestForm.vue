<template>
    <div class="flex max-lg:flex-col justify-center gap-5 mt-3">
        <div class="box p-4" :class="{hidden: display === 'preview' && windowWidth < 1024}">
            <div class="flex justify-between">
                <h1>Предложите свой код</h1>
                <button class="btn btn-primary" @click="display = 'preview'" v-if="windowWidth < 1024">Превью</button>
            </div>
            <form action="" @submit.prevent="submit" enctype="multipart/form-data">
                <div class="form-group required">
                    <label for="">Код</label>
                    <input type="text" v-model="code.code">
                    <div class="text-sm text-gray-400">Будет отображаться только на странице кода</div>
                    <div class="error-message" v-for="error in errors.code">{{ error }}</div>
                </div>
                <div class="form-group required">
                    <label for="">Заголовок</label>
                    <input type="text" v-model="code.title">
                    <div class="error-message" v-for="error in errors.title">{{ error }}</div>
                </div>
                <div class="form-group required">
                    <label for="">Описание</label>
                    <textarea type="text" v-model="code.description"></textarea>
                    <div class="text-sm text-gray-400">100 символов на карточке. Весь текст на странице кода.</div>
                    <div class="error-message" v-for="error in errors.description">{{ error }}</div>
                </div>
                <div class="form-group required">
                    <label for="">Ссылка для активации</label>
                    <input type="text" v-model="code.activate_url">
                    <div class="text-sm text-gray-400">Ссылка будет доступна на странице кода.</div>
                    <div class="error-message" v-for="error in errors.activate_url">{{ error }}</div>
                </div>
                <div class="form-group">
                    <label for="">Картинка</label>
                    <input type="file" accept="image/*" @change="onImageChange">
                    <div class="text-sm text-gray-400">Ссылка будет доступна на странице кода.</div>
                </div>
                <button type="submit" class="btn btn-primary">Отправить</button>
            </form>
        </div>
        <div class="box p-4 h-[1000px] pb-[3em]" :class="{hidden: display === 'form' && windowWidth < 1024}">
            <div class="flex justify-between">
                <h1>Превью</h1>
                <button class="btn btn-primary" @click="display = 'form'" v-if="windowWidth < 1024">Форма</button>
            </div>
            <code-card :code="code" :isPreview="true"></code-card>
        </div>
    </div>

</template>

<script>
export default {
    name: "SuggestForm",
    data: () => ({
        code: {
            code: '',
            title: '',
            description: '',
            activate_url: '',
            image: undefined
        },
        display: 'form',
        errors: {}
    }),
    computed: {
        windowWidth() {
            return window.innerWidth;
        }
    },
    methods: {
        submit() {
            let config = {headers: {
                'content-type': 'multipart/form-data',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            }}

            window.axios.post('/codes', {...this.code}, config)
                .then(() => {
                    this.$store.dispatch('sendNotification', {
                        code: this.code,
                        reason: 'code_sent'
                    }).then(() => location.href = '/')
                })
                .catch((e) => {
                    this.errors = e.response.data.errors
                })
        },
        onImageChange(e) {
            this.code.image = e.target.files[0];
        }
    }
}
</script>

<style scoped>

</style>
