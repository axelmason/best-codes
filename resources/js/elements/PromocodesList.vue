<template>
    <div class="flex flex-col gap-y-3">
        <div class="code-item bg-white py-4 px-5 flex" v-for="code in codes">
            <div class="code-img-wrapper"><img :src="'/storage/images/'+code.image" alt=""></div>
            <div class="flex flex-col">
                <p class="font-bold text-primary" style="font-size: 20px;">{{ getTypeName(code.type) }}</p>
                <p class="font-semibold text-[#505050]" style="font-size: 32px;">{{ code.title }}</p>
                <p class="text-[#b1b1b1] font-medium" style="font-size: 16px;">{{ parseDate(code.end_date) }}</p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        codes: {
            type: Array
        }
    },
    methods: {
        getTypeName(type) {
            switch (type) {
                case 'promo':
                    return 'Акция'
                case 'code':
                    return 'Промокод'

                default:
                    return ''
            }
        },
        parseDate(date) {
            let dt = new Date(date)

            let result = dt.toLocaleDateString("ru", { day: 'numeric', month: 'long', year: 'numeric' })
            return `Действует до ${result}`
        }
    },
}
</script>

<style lang="scss" scoped>
.code-img-wrapper {
    max-width: 200px;
}
</style>
