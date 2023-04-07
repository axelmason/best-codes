<template>
    <div class="shop-page mt-10">
        <div class="grid grid-cols-4 gap-5 font-roboto">
            <div class="col-span-1 flex flex-col space-y-5">
                <div class="shop-card flex flex-col items-center">
                    <div class="img-wrapper"><img :src="'/storage/images/'+shop.image" alt=""></div>
                    <p class="text-[#505050]" style="font-size: 24px;">{{ shop.codes.length }} действующих купонов</p>
                </div>
                <div class="shop-card flex flex-col">
                    <h3 class="text-primary font-medium" style="font-size: 24px;">О магазине</h3>
                    <p class="text-[#8A9397]">{{ shop.description }}</p>
                </div>
                <div class="flex flex-col">
                    <h3 class="font-medium" style="font-size: 24px;">Похожие магазины</h3>
                    <div class="related-shops w-full flex flex-wrap gap-3">
                        <a class="related-item bg-white px-7 py-2.5 rounded" :href="'/shop/'+item.alias" v-for="item in related">{{ item.name }}</a>
                    </div>
                </div>
            </div>
            <div class="col-span-3 flex flex-col">
                <h1 class="font-bold text-[#505050]" style="font-size: 32px;">Промокоды {{ shop.name }}</h1>
                <div class="flex justify-between">
                    <div class="type-selector font-bold space-x-10">
                        <span class="active">Все купоны</span>
                        <span class="">Промокоды</span>
                        <span class="">Скидки</span>
                    </div>
                    <a href="/suggest" class="suggest-button underline underline-offset-4 text-primary font-bold">Добавить купон</a>
                </div>
                <promocodes-list :codes="shop.codes" />
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {

        }
    },
    props: {
        shop: {
            type: Object,
        },
        related: {
            type: Array
        }
    },
}
</script>

<style lang="scss" scoped>
.img-wrapper {
    width: 275px;
}
.shop-card {
    @apply bg-white py-5 px-4 rounded-md;
}
.suggest-button {
    display: flex;
    &::before {
        content: url(@/assets/img/plus.svg);
        // margin-right: 5px;
    }
}
.type-selector {
    color: #505050;
    cursor: pointer;
    .active {
        text-decoration: underline;
        text-underline-offset: 4px;
        color: #4671D5;
    }
}
</style>
