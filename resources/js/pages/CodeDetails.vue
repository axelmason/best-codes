<template>
    <div class="box p-5">
        <h1 class="title">{{ code.title }}</h1>
        <div class="img-wrapper">
            <img :src="'/storage/images/'+code.image">
        </div>
        <h2 class="description">
            Описание
        </h2>
        <p class="mb-5">{{ code.description }}</p>
        <p>Количество просмотров: <b>{{ code.views_count }}</b></p>
        <p>Количество использований: <b>{{ code.usages_count }}</b></p>
        <button class="btn btn-primary mt-3" @click="openShowModal()">Показать код</button>
    </div>
    <show-modal :show="showCode" :title="'Активация кода'" @close="showCode = !showCode">
        <p>Ваш код (нажмите, чтобы скопировать): <button class="select-code" @click="selectCode()">{{ code.code }}</button></p>
        <br>
        <a :href="code.activate_url" @click="useCode()" target="_blank" class="btn btn-primary">Перейти к ресурсу</a>
    </show-modal>
</template>

<script>
export default {
    name: "CodeDetails",
    props: {
        code: {
            type: Object,
            required: true
        },
    },
    data: () => ({
        showCode: false
    }),
    mounted() {
        setTimeout(() => {
            window.axios.put(`/code/${this.code.id}/viewed`, {views_count : this.code.views_count+1})
        }, 5000);
    },
    methods: {
        openShowModal() {
            this.showCode = true;
        },
        selectCode() {
            navigator.clipboard.writeText(code.code)
        },
        useCode() {
            window.axios.put(`/code/${this.code.id}/viewed`, {usages_count : this.code.usages_count+1})
        }
    }
}
</script>

<style scoped lang="scss">
    .title {
        @apply text-3xl;
    }
    .img-wrapper {
        max-width: 300px;
    }
    p, .description, .title {
        @apply font-roboto;
    }
    .select-code {
        @apply font-bold;
        transition: .1s ease;

        &:active {
            transform: translateY(-5px);
        }
    }
</style>
