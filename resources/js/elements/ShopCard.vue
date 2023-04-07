<template>
    <div class="shop-card">
        <div class="img-wrapper">
            <img :src="getImage" @error="brokenImage">
        </div>
        <p class="title">{{ shop.name }}</p>
        <p class="type text-xs text-gray-500">{{ shop.type.title }}</p>
        <div class="flex mt-auto justify-between items-center w-full">
            <a style="transition: .3s;" :href="`shop/${shop.alias}`" class="w-full font-bold text-primary border-primary border text-center py-1 rounded-2xl hover:bg-primary hover:text-white">Промокоды и акции</a>
        </div>
    </div>
</template>

<script>
export default {
    name: "CodeCard",
    props: {
        shop: {
            type: Object,
            required: true,
            default: () => ({
                name: "",
                image: "",
                name: undefined,
            })
        },
        isPreview: {
            type: Boolean,
            default: false
        }
    },
    methods: {
        brokenImage(e) {
            return e.target.src = '/storage/images/default.png';
        }
    },
    computed: {
        getDescription() {
            if(this.shop.description.length > 0) {
                return this.shop.description.substring(0, 100)+'...'
            }
        },
        getImage() {
            if(this.isPreview) {
                return this.shop.image ? URL.createObjectURL(this.shop.image) : '/storage/images/default.png';
            }
            try {
                return this.shop.image ? '/storage/images/'+this.shop.image : '/storage/images/default.png';
            } catch (e) {
                console.log(e)
            }
        }
    }
}
</script>

<style scoped lang="scss">
.shop-card {
    @apply border px-5 py-2 my-2 flex flex-col items-center max-lg:mx-5 max-md:w-[260px] w-[320px];
    height: 100%;
    overflow: hidden;
    .title {
        @apply font-medium text-lg;
    }
    .img-wrapper {
        max-width: 200px;
        img {
            width: 100%;
        }
    }
}
</style>
