<template>
    <div class="box p-5 bg-white mt-5">
        <h1 class="title">{{ code.title }}</h1>
        <el-carousel ref="carousel" trigger="click" class="max-w-[500px]" @change="changeImage" :autoplay="false" indicator-position="none" arrow="always">
            <div class="img-wrapper">
                <el-carousel-item v-for="item in code.images" :key="item">
                    <img :src="'/storage/'+item.path" alt="">
                </el-carousel-item>
            </div>
        </el-carousel>
        <div class="mini-images my-3">
            <div class="flex gap-x-2">
                <div class="mini-image" :class="{active: index === activeImage}" v-for="(img, index) in code.images" :key="index">
                    <img @click="setActiveImage(index)" :src="'/storage/'+img.path" alt="">
                </div>
            </div>
        </div>
        <h2 class="description">
            Описание
        </h2>
        <p class="mb-5" v-html="code.description"></p>
        <p>Количество просмотров: <b>{{ code.views_count }}</b></p>
        <p>Количество использований: <b>{{ code.usages_count }}</b></p>
        <button class="btn btn-primary mt-3" @click="openShowModal()">Показать код</button>
    </div>
    <el-dialog v-model="showCode" class="max-w-[500px] min-w-[320px]" title="Активация кода">
        <p>Ваш код (нажмите, чтобы скопировать): <button class="select-code" @click="selectCode">{{ code.code }}</button></p>
        <br>
        <a :href="code.shop.url" @click="useCode()" target="_blank" class="btn btn-primary">Перейти к ресурсу</a>
    </el-dialog>
</template>

<script>
import { ElNotification } from 'element-plus';

export default {
    name: "CodeDetails",
    props: {
        code: {
            type: Object,
            required: true
        },
    },
    data: () => ({
        showCode: false,
        activeImage: 0
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
        async selectCode(e) {
            var copyTextarea = document.createElement("textarea");
            copyTextarea.style.position = "fixed";
            copyTextarea.style.opacity = "0";
            copyTextarea.textContent = e.target.textContent

            document.body.appendChild(copyTextarea);
            copyTextarea.select();
            document.execCommand("copy");
            document.body.removeChild(copyTextarea);
            ElNotification({
                title: "Код скопирован",
                type: "success"
            })
        },
        useCode() {
            window.axios.put(`/code/${this.code.id}/viewed`, {usages_count : this.code.usages_count+1})
            this.showCode = false
        },
        changeImage(e) {
            this.activeImage = e
        },
        setActiveImage(item) {
            this.$refs['carousel'].setActiveItem(item)
            this.activeImage = item
        }
    }
}
</script>

<style scoped lang="scss">
.mini-image {
    width: 100px;
    height: 100px;
    img {
        object-fit: contain;
        width: 100%;
        height: 100%;
    }
    &.active {
        outline: 1px;
        outline-style: solid;
        @apply outline-primary;
    }
}
    .title {
        @apply text-3xl;
    }
    .img-wrapper {
        max-width: 300px;
        max-height: 300px;
        img {
            object-fit: contain;
            width: 100%;
            height: 100%;
        }
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
