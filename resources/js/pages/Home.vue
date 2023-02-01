<template>
    <div class="code-cards flex flex-col">
        <code-card v-for="code in codes" :code="code"></code-card>
    </div>
</template>

<script>
    export default {
        data() {
            return {

            }
        },
        props: {
            codes: {
                type: Object,
                default: () => ({})
            }
        },
        methods: {

        }
    }
</script>

<style scoped lang="scss">
    * {
        @apply font-roboto;
    }
    .code-cards {
        @apply grid xl:grid-cols-4 lg:grid-cols-2 gap-5 justify-center items-center w-full;
    }
</style>
