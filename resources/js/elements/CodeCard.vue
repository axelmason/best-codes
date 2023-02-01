<template>
    <div class="code-card">
        <div class="img-wrapper">
            <img :src="getImage" @error="brokenImage">
        </div>
        <div class="title mb-3">{{ code.title }}</div>
        <div class="content">{{ getDescription }}</div>
        <div class="flex mt-auto justify-between items-center w-full">
            <a :href="`code/${code.id}`" class="btn btn-primary" v-if="code.id">Открыть</a>
            <button class="btn btn-primary" v-else>Открыть</button>
            <div class="flex space-x-3">
                <div class="views"><i class="la la-eye"></i> {{ code.views_count ?? 0 }}</div>
                <div class="usages"><i class="fa-regular fa-square-check"></i> {{ code.usages_count ?? 0 }}</div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "CodeCard",
    props: {
        code: {
            type: Object,
            required: true,
            default: () => ({
                image: undefined,
                code: '',
                title: '',
                description: '',
                views_count: 0,
                usages_count: 0
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
            if(this.code.description.length > 0) {
                return this.code.description.substring(0, 100)+'...'
            }
        },
        getImage() {
            if(this.isPreview) {
                return this.code.image ? URL.createObjectURL(this.code.image) : '/storage/images/default.png';
            }
            try {
                return this.code.image ? '/storage/images/'+this.code.image : '/storage/images/default.png';
            } catch (e) {
                console.log(e)
            }

        }
    }
}
</script>

<style scoped lang="scss">
.code-card {
    @apply border px-5 py-2 my-2 flex flex-col items-center max-lg:mx-5 max-md:w-[260px] w-[320px];
    height: 100%;
    overflow: hidden;
    .title {
        @apply font-medium text-lg mb-3;
    }
    .img-wrapper {
        max-width: 200px;
        img {
            width: 100%;
        }
    }
}
</style>
