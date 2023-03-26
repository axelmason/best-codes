<template>
    <div class="shops-wrapper" @mouseenter="open=true" @mouseleave="open=false">
        <span @click="open =! open" class="font-roboto font-bold text-white hover:cursor-pointer flex">Все магазины <img class="ml-1" src="/arrow_down.svg" alt=""></span>
        <transition name="fade">
            <div class="content py-4 px-3 bg-[#F5F5F5] shadow-lg rounded-lg" v-if="open">
                <div class="grid grid-cols-2">
                    <a :href="'/shop/'+shop.id" class="shop-item" v-for="shop in shops">
                        <div class="flex items-center">
                            <div class="img-wrapper w-[150px]"><img class="w-full" :src="'/storage/images/'+shop.image" alt=""></div>
                            <span class="shop-name">{{ shop.name }}</span>
                        </div>
                    </a>
                    <a href="" class="font-bold col-span-2 text-primary border-primary border text-center py-1 rounded-2xl hover:bg-primary hover:text-white">Все магазины</a>
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
