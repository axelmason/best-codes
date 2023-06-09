<template>
    <div class="shop-card bg-white rounded-xl" :class="{'horizont': horizont}">
        <div class="img-wrapper">
            <img :src="getImage" @error="brokenImage">
        </div>
        <p class="title">{{ shop.name }}</p>
        <p class="type text-xs text-gray-500">{{ shop.type.title }}</p>
        <div class="flex mt-auto justify-between items-center w-full goto-btn">
            <a style="transition: .3s;" :href="`shop/${shop.alias}`" class="w-full font-bold text-primary border-primary border text-center py-1 my-3 rounded-2xl hover:bg-primary hover:text-white">Промокоды и акции</a>
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
        },
        horizont: {
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

            return this.shop.image ? '/storage/'+this.shop.image : '/storage/images/default.png';
        }
    }
}
</script>

<style scoped lang="scss">
.shop-card {
    @apply border px-5 py-2 my-2 flex flex-col items-center max-lg:mx-5;
    overflow: hidden;
    .title {
        @apply font-medium text-lg;
    }
    .img-wrapper {
        max-height: 150px;
        max-width: 200px;
        img {
            width: 100%;
            object-fit: contain;
        }
    }

    &.horizont {
        @apply max-lg:mx-0 my-0 rounded-xl border-0 grid grid-cols-1 items-start w-full bg-white p-5;

        .title {
            font-size: 24px;
            text-align: center;
            grid-row: span 2;
        }
        .type {
            place-self: center;
        }
        .img-wrapper {
            @apply self-center place-self-center h-[150px] ;
            img {
                object-fit: contain;
                width: 100%;
                height: 100%;
            }
        }
    }
}
</style>
