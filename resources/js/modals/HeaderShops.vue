<template>
    <div class="shops-wrapper z-30" @mouseenter="open=true" @mouseleave="open=false">
        <span class="font-roboto font-bold text-white hover:cursor-pointer flex">Все магазины <img class="ml-1 transition-transform" :class="{'rotate-180': open}" src="@/assets/img/arrow_down.svg" alt=""></span>
        <transition name="fade">
            <div class="content py-5 px-5 bg-[#F5F5F5] shadow-lg rounded-lg font-roboto font-medium" v-if="open">
                <div class="grid grid-cols-2 gap-y-5 gap-x-8">
                    <a :href="'/shop/'+shop.alias" class="shop-item" v-for="shop in shops">
                        <div class="flex items-center gap-x-2">
                            <div class="img-wrapper max-w-[150px] w-[150px] h-[100px]">
                                <img class="h-full w-full object-contain" :src="'/storage/images/'+shop.image" alt="">
                            </div>
                            <span class="shop-name">{{ shop.name }}</span>
                        </div>
                    </a>
                    <a href="" class="font-bold col-span-2 text-primary border-primary border text-center py-1 rounded-2xl hover:bg-primary hover:text-white transition-colors">Все магазины</a>
                </div>
            </div>
        </transition>
    </div>
</template>
<script>

export default {
    data() {
        return {
            open: false,
            shops: [],
            loading: false
        }
    },
    created() {
        this.getShops()
    },
    methods: {
        getShops() {
            this.loading = true

            window.axios.get('/shops/top')
            .then((res) => {
                this.shops = res.data.shops
            }).catch((err) => {

            });
        }
    },
}
</script>
<style lang="scss" scoped>
.shops-wrapper {
    position: relative;
}
    .content {
        position: absolute;
        right: 0;
        width: max-content;
    }
</style>
