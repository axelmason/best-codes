<template>
    <el-dialog :model-value="visible" :title="code.id ? code.title : 'Добавить код'" @close="closeDialog">
        <el-form require-asterisk-position="right" class="h-max overflow-y-scroll" v-loading="loading" label-position="top" :model="code">
            <el-tabs type="border-card">
                <el-tab-pane label="Код" lazy>
                    <el-row :gutter="25">
                        <el-col v-if="code.id">От пользователя: {{ code.user?.name }}</el-col>
                        <el-col :md="12">
                            <el-form-item label="Заголовок" required>
                                <el-input v-model="code.title"></el-input>
                            </el-form-item>
                        </el-col>
                        <el-col :md="12">
                            <el-form-item label="Код" required>
                                <el-input v-model="code.code"></el-input>
                            </el-form-item>
                        </el-col>
                        <el-col :md="12">
                            <el-form-item label="Тип">
                                <el-select v-model="code.type">
                                    <el-option v-for="(item, index) in codeTypes" :key="index" :label="item.label" :value="item.name"></el-option>
                                </el-select>
                            </el-form-item>
                        </el-col>
                    </el-row>
                    <el-row>
                        <el-col>
                            <div>Просмотров: {{ code.views_count }}</div>
                            <div>Использований: {{ code.usages_count }}</div>
                            <div>Время добавления:
                                <span v-if="!!code.created_at">{{ code.created_at }}</span>
                                <span v-else class="text-gray-400">неизвестно</span>
                            </div>
                        </el-col>
                    </el-row>
                </el-tab-pane>
                <el-tab-pane label="Описание кода">
                    <el-row>
                        <el-col>
                            <el-form-item label="Описание">
                                <div class="flex flex-col w-full quill-scroll max-h-[300px] h-[300px]">
                                    <QuillEditor :options="{'scrollingContainer': '.quill-scroll'}" toolbar="full" theme="snow" v-model:content="code.description" :content-type="'html'" />
                                </div>
                            </el-form-item>
                        </el-col>
                    </el-row>
                </el-tab-pane>
                <el-tab-pane label="Изображения">
                    <el-row>
                        <el-col>
                            <p v-if="images?.length">Список изображений</p>
                            <p v-else><i>Изображения отсуствуют</i></p>
                            <div class="images-grid py-5">
                                <div class="image-container place-self-center" v-for="(image, index) in images" :key="index">
                                    <div class="image-wrapper">
                                        <img :src="image.blob_src || ('/storage/' + image?.path)" class="image" alt="">
                                    </div>
                                    <div v-if="codeId" class="flex justify-between">
                                        <label class="inline-block bottom-0">
                                            <p>Изменить</p>
                                            <input @change="changeImage(e, image)" type="file" class="hidden">
                                        </label>
                                        <p @click="deleteImage(image.id)" class="cursor-pointer text-red-600">Удалить</p>
                                    </div>
                                </div>
                                <div v-if="images?.length < 10" class="image-container place-self-center">
                                    <div class="image-wrapper">
                                        <img src="/storage/images/default.png" class="image" alt="">
                                        <label class="inline-block">
                                            <input @change="uploadImages" multiple accept="image/*" type="file" class="hidden">
                                            <el-icon size="40" class="image-icon"><Plus /></el-icon>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </el-col>
                    </el-row>
                </el-tab-pane>
                <el-tab-pane label="Магазин" lazy>
                    <el-row>
                        <el-col>
                            <el-form-item label="Магазин" required>
                                <el-select @change="changeShop = true" v-model="code.shop_id" filterable clearable>
                                    <el-option v-for="(item, index) in shops" :key="index" :value="item.id" :label="item.name"></el-option>
                                </el-select>
                            </el-form-item>
                            <el-row class="items-center place-">
                                <el-col :md="11">
                                    <table class="border border-collapse table-fixed w-full">
                                        <thead>
                                            <tr>
                                                <th class="border px-3 py-2">Название</th>
                                                <th class="border px-3 py-2">Сайт</th>
                                                <th class="border px-3 py-2">Тип</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-if="codeId">
                                                <td class="border px-3 py-2">{{ code.shop.name }}</td>
                                                <td class="border px-3 py-2"><a :href="code.shop.url" target="_blank">Ссылка</a></td>
                                                <td class="border px-3 py-2">{{ code.shop.type.title }}</td>
                                            </tr>
                                            <tr v-else>
                                                <td class="border px-3 py-2">{{ getShopProperty()?.['name'] }}</td>
                                                <td class="border px-3 py-2" v-if="getShopProperty()?.['url']"><a :href="getShopProperty()?.['url']" target="_blank">Ссылка</a></td>
                                                <td class="border px-3 py-2">{{ getShopProperty()?.['type']?.['title'] }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </el-col>
                                <el-col v-if="changeShop && !!newCode && codeId" :md="2" class="text-center text-3xl"><el-icon><Right /></el-icon></el-col>
                                <el-col v-if="changeShop && !!newCode && codeId" :md="11">
                                    <table class="border border-collapse table-fixed w-full">
                                        <thead>
                                            <tr>
                                                <th class="border px-3 py-2">Название</th>
                                                <th class="border px-3 py-2">Сайт</th>
                                                <th class="border px-3 py-2">Тип</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="border px-3 py-2">{{ newCode.name }}</td>
                                                <td class="border px-3 py-2"><a :href="newCode.url" target="_blank">Ссылка</a></td>
                                                <td class="border px-3 py-2">{{ newCode.type.title }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </el-col>
                            </el-row>
                        </el-col>
                    </el-row>
                </el-tab-pane>
            </el-tabs>
            <div class="flex mt-3">
                <el-button type="primary" @click="submit">Сохранить</el-button>
                <el-button type="danger">Удалить</el-button>
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
        codeId: null,
        code: {},
        images: [],
        visible: false,
        loading: false,
        shops: [],
        changeShop: false,
        newImagesFormdata: null
    }),
    mounted() {},
    computed: {
        newCode() {
            return this.shops.find(el => el.id === this.code.shop_id) || false
        },
        codeTypes() {
            return [
                {label: "Промокод", name: "code"},
                {label: "Акция", name: "promo"},
                {label: "Другое", name: "other"},
            ]
        }
    },
    methods: {
        async getCode() {
            this.loading = true;
            await this.$http
                .get('/codes/'+this.codeId, {params: { withShops: true }})
                .then((res) => {
                    this.code = res.data.code;
                    this.shops = res.data.shops;
                    if(!!this.codeId) this.fetchImages()
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        async getShops() {
            this.loading = true
            await this.$http
                .get('/shops/all', {params: {withType: true}})
                .then((res) => {
                    this.shops = res.data
                }).finally(() => this.loading = false)
        },
        async show(id) {
            this.visible = true;
            this.loading = true
            this.codeId = id;

            if(this.codeId) {
                await this.getCode();
            } else {
                await this.getShops()
            }
            this.loading = false
        },
        closeDialog() {
            Object.assign(this.$data, this.$options.data())
        },
        submit() {
            this.loading = true;

            var data = this.codeId ? this.code : this.newImagesFormdata
            var config = {}
            let url;

            if(this.codeId) {
                data['_method'] = 'put'
                url = '/codes/'+this.codeId
            } else {
                Object.entries(this.code).map(([key, value]) => this.newImagesFormdata.append(key, value))
                url = '/codes'
                config = { headers: { 'Content-Type': 'multipart/form-data' } }
            }

            this.$http.post(url, data, config)
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
            if(!this.codeId) return this.uploadNewImages(event.target.files)
            this.loading = true;

            const formData = new FormData();
            const files = event.target.files;

            for (let i = 0; i < files.length; i++) {
                formData.append('images[]', files[i])
            }

            const config = { headers: { 'Content-Type': 'multipart/form-data' } };
            this.$http.post(`/codes/${this.code.id}/images/upload`, formData, config)
            .then(async (res) => {
                await this.fetchImages()
            })
        },
        uploadNewImages(files) {
            this.newImagesFormdata = new FormData()

            for (let i = 0; i < files.length; i++) {
                let blob = URL.createObjectURL(files[i])
                this.images.push({blob_src: blob})
                this.newImagesFormdata.append('images[]', files[i])
            }
        },
        deleteImage(id) {
            this.loading = true;
            axios.post(`/codes/${this.code.id}/images/delete`, {imageId: id}).then(async (res) => {
                await this.fetchImages()
            }).catch(error => {
                console.error(error);
            })
        },
        async fetchImages() {
            this.loading = true;
            await axios.get(`/codes/${this.code.id}/images/fetch`).then(async (res) => {
                this.images = await res.data.images;
            }).catch(error => {
                console.error(error);
            })
            this.loading = false
        },
        getShopProperty() {
            return this.shops.find(el => el.id === this.code.shop_id)
        }
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
