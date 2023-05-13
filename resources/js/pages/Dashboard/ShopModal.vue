<template>
    <el-dialog :model-value="visible" :title="!!shopId ? shop.name : 'Добавить магазин'" @close="closeDialog">
        <el-form require-asterisk-position="right" class="h-max overflow-y-scroll" v-loading="loading" label-position="top" :model="shop">
            <el-tabs type="border-card">
                <el-tab-pane label="Магазин" lazy>
                        <el-row :gutter="25">
                            <el-col :md="12">
                                <el-form-item label="Название магазина" required>
                                    <el-input v-model="shop.name"></el-input>
                                </el-form-item>
                            </el-col>
                            <el-col :md="12">
                                <el-form-item label="Тип" required>
                                    <el-select class="w-full" v-model="shop.type_id" filterable clearable>
                                        <el-option v-for="(item, index) in types" :key="index" :value="item.id" :label="item.title"></el-option>
                                    </el-select>
                                </el-form-item>
                            </el-col>
                        </el-row>
                        <el-row :gutter="25">
                            <el-col :md="12">
                                <el-form-item label="Ссылка для активации" required>
                                    <el-input v-model="shop.url">
                                        <template #prepend>http://</template>
                                    </el-input>
                                </el-form-item>
                            </el-col>
                        </el-row>
                    </el-tab-pane>
                <el-tab-pane label="Описание">
                    <el-row>
                        <el-col>
                            <p>Обложка магазина</p>
                            <div class="image-container" v-if="shopId">
                                <div class="image-wrapper">
                                    <img :src="'/storage/'+shop.image" alt="" class="image">
                                </div>
                            </div>
                            <label class="inline-block bottom-0">
                                <p>Изменить</p>
                                <input @change="uploadImages" type="file" class="hidden">
                            </label>
                            <div v-if="image" class="text-green-500 ms-3">Изображение будет обновлено</div>
                        </el-col>
                    </el-row>
                </el-tab-pane>
                <el-tab-pane label="Описание">
                    <el-row>
                        <el-col>
                            <el-form-item label="Описание">
                                <div class="flex flex-col w-full quill-scroll max-h-[300px] h-[300px]">
                                    <QuillEditor :options="{'scrollingContainer': '.quill-scroll'}" toolbar="full" theme="snow" v-model:content="shop.description" :content-type="'html'" />
                                </div>
                            </el-form-item>
                        </el-col>
                    </el-row>
                </el-tab-pane>
            </el-tabs>
            <div class="flex mt-3">
                <el-button type="primary" @click="submit">{{ shopId ? 'Сохранить' : 'Добавить' }}</el-button>
                <el-button type="danger" v-if="shopId">Удалить</el-button>
            </div>
        </el-form>
    </el-dialog>
</template>

<script>
import { QuillEditor } from '@vueup/vue-quill'
import {ElMessage} from 'element-plus'
import '@vueup/vue-quill/dist/vue-quill.snow.css';

export default {
    components: { QuillEditor },
    data: () => ({
        shopId: null,
        shop: {},
        // images: [],
        types: [],
        visible: false,
        loading: false,
        image: null
    }),
    mounted() {},
    methods: {
        async getShop() {
            this.loading = true;
            await this.$http
                .get('/shops/'+this.shopId)
                .then((res) => {
                    this.shop = res.data.shop;
                    this.types = res.data.types
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        async show(id) {
            this.visible = true;
            this.loading = true
            this.shopId = id;
            if(this.shopId) {
                await this.getShop();
            } else {
                await this.getTypes();
            }
            this.loading = false
        },
        async getTypes() {
            await this.$http.get('/shops/types').then((res) => {
                this.types = res.data.types
            })
        },
        closeDialog() {
            this.shopId = null;
            this.shop = {}
            this.visible = false;
        },
        submit() {
            this.loading = true;

            let url = !!this.shopId ? `/shops/${this.shopId}` : '/shops';
            const config = { headers: { 'Content-Type': 'multipart/form-data' } };

            let form = new FormData()
            form.set('image', this.image)
            for(const [key, value] of Object.entries(this.shop)) {
                form.append(key, value)
            }
            if(this.shopId) form.append('_method', 'PUT')

            this.$http.post(url, form, config)
                .then((res) => {
                    ElMessage({
                        message: "Изменения успешно сохранены",
                        type: "success"
                    });
                    this.closeDialog();
                    this.$emit('submit');
                }).catch((err) => {
                    this.errors = err.response.data.errors
                    ElMessage({
                        message: "Заполните обязательные поля",
                        type: "error",
                        duration: 5000,
                        showClose: true
                    });
                }).finally(() => {
                    this.loading = false;
                })
        },
        uploadImages(event) {
            const file = event.target.files[0]
            if(!file) return

            this.image = file;
        },
    },
};
</script>

<style scoped lang="scss">
.images-grid {
    display: grid;
    gap: 2em 1em;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr))
}
.image-container {
    @apply w-[200px] h-[100px] border border-black;

    .image-wrapper {
        @apply relative flex w-full h-full items-center justify-center text-black;

        .image {
            @apply object-contain absolute w-full h-full opacity-90;

        }
        .image-icon {
            @apply cursor-pointer hover:text-blue-600 transition-colors;
        }
    }
}
</style>
